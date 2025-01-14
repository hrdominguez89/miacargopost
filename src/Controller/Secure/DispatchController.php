<?php

namespace App\Controller\Secure;

use App\Constants\ConstantsStatusBag;
use App\Constants\ConstantsStatusDispatch;
use App\Entity\Bags;
use App\Entity\Dispatch;
use App\Entity\PostalServiceRange;
use App\Entity\StatusBag;
use App\Form\DispatchType;
use App\Repository\BagsRepository;
use App\Repository\DispatchRepository;
use App\Repository\OfficesRepository;
use App\Repository\PostalServiceRangeRepository;
use App\Repository\RoutesRepository;
use App\Repository\StatusBagRepository;
use App\Repository\StatusDispatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dispatch')]
class DispatchController extends AbstractController

{
    #[Route('/new', name: 'app_secure_new_dispatch')]
    public function new(Request $request, EntityManagerInterface $em, OfficesRepository $officesRepository, RoutesRepository $routesRepository, StatusDispatchRepository $statusDispatchRepository, PostalServiceRangeRepository $postalServiceRangeRepository): Response
    {
        $data['active'] = 'dispatch';
        $data['title'] = 'Crear despacho';
        $data['dispatch'] = new Dispatch;
        $data['dispatches'] = [];
        $data['form'] =  $this->createForm(DispatchType::class, $data['dispatch']);

        $data['form']->handleRequest($request);
        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $originOffice = $officesRepository->findOneBy(['id' => $request->get('dispatch')['originOffice']]);
            $destinationOffice = $officesRepository->findOneBy(['id' => $request->get('dispatch')['destinationOffice']]);
            $route =  $routesRepository->findOneBy(['id' => $request->get('dispatch')['routeId']]);
            $statusDispatch =  $statusDispatchRepository->findOneBy(['id' => ConstantsStatusDispatch::OPENED]);
            $postalServiceRange =  $postalServiceRangeRepository->findOneBy(['id' => $request->get('dispatch')['postalServiceRange']]);


            $data['dispatch']->setOriginOffice($originOffice)
                ->setDestinationOffice($destinationOffice)
                ->setRoute($route)
                ->setStatusDispatch($statusDispatch)
                ->setNumberDispatch($request->get('dispatch')['numberDispatch'])
                ->setItinerary($request->get('dispatch')['itinerary'])
                ->setPostalServiceRange($postalServiceRange)
                ->setDispatchCode($originOffice->getImpcCode() . $destinationOffice->getImpcCode() . 'A' . $postalServiceRange->getPrincipalCharacter() . $postalServiceRange->getSecondCharacterFrom() . substr(date('Y'), -1) . str_pad($request->get('dispatch')['numberDispatch'], 4, '0', STR_PAD_LEFT));
            $em->persist($data['dispatch']);
            $em->flush();
            return $this->redirectToRoute('app_secure_dispatch_index', ['status_dispatch', 'OPENED']);
        }
        return $this->render('secure/dispatch/new_dispatch.html.twig', $data);
    }

    #[Route('/bags/{dispatch_id}', name: 'app_secure_new_bags')]
    public function edit($dispatch_id, DispatchRepository $dispatchRepository, BagsRepository $bagsRepository, StatusBagRepository $statusBagRepository, Request $request, EntityManagerInterface $em, OfficesRepository $officesRepository, RoutesRepository $routesRepository, StatusDispatchRepository $statusDispatchRepository, PostalServiceRangeRepository $postalServiceRangeRepository): Response
    {
        $data['dispatch'] =  $dispatchRepository->find($dispatch_id);
        if ($data['dispatch']->getStatusDispatch()->getId() != ConstantsStatusDispatch::OPENED) {
            $data['bags'] = $data['dispatch']->getBags()->toArray(); // Convertimos la colección a un array

            // Ordenamos los bags por su ID
            usort($data['bags'], function ($a, $b) {
                return $a->getId() <=> $b->getId(); // Orden ascendente
            });

            $data['active'] = 'dispatch';
            $data['title'] = 'Crear envases';

            return $this->render('secure/dispatch/closed_bags.html.twig', $data);
        }


        $statusBag = $statusBagRepository->find(ConstantsStatusBag::OPENED);

        if ($request->request->has('cerrarEnvase')) {
            $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBag], ['id' => 'DESC']);
            if ($data['bag']->getS10Codes()[0]) {
                $data['bag']->setStatus($statusBagRepository->find(ConstantsStatusBag::CLOSED));
                $data['bag']->setBagCode($data['bag']->generateBagCode());
                $em->persist($data['bag']);
                $em->flush();
                $this->addFlash('success', 'El envase se ha cerrado correctamente.');
                return $this->redirectToRoute('app_secure_new_bags', ['dispatch_id' => $dispatch_id]);
            } else {
                $this->addFlash('error', 'No se puede cerrar un envase vacio.');
                return $this->redirectToRoute('app_secure_new_bags', ['dispatch_id' => $dispatch_id]);
            }
        } elseif ($request->request->has('cerrarDespacho')) {
            $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBag], ['id' => 'DESC']);
            if ($data['bag']->getS10Codes()[0]) {
                $data['bag']->setIsFinalBag(true);
                $data['bag']->setBagCode($data['bag']->generateBagCode());
                $data['bag']->setStatus($statusBagRepository->find(ConstantsStatusBag::CLOSED));
                $em->persist($data['bag']);
                $data['dispatch']->setStatusDispatch($statusDispatchRepository->find(ConstantsStatusDispatch::CLOSED));
                $em->persist($data['dispatch']);
                $em->flush();
            } else {
                $em->remove($data['bag']);
                $em->flush();
                $statusBagClosed = $statusBagRepository->find(ConstantsStatusBag::CLOSED);
                $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBagClosed], ['id' => 'DESC']);
                $data['bag']->setIsFinalBag(true);
                $data['bag']->setBagCode($data['bag']->generateBagCode());
                $em->persist($data['bag']);
                $data['dispatch']->setStatusDispatch($statusDispatchRepository->find(ConstantsStatusDispatch::CLOSED));
                $em->persist($data['dispatch']);
                $em->flush();
                $this->addFlash('success', ' se ha cerrado el despacho correctamente.');
                return $this->redirectToRoute('app_secure_new_bags', ['dispatch_id' => $dispatch_id]);
            }
            $this->addFlash('success', ' se ha cerrado el despacho correctamente.');
            return $this->redirectToRoute('app_secure_new_bags', ['dispatch_id' => $dispatch_id]);
        }

        $data['bag'] = $bagsRepository->findOneBy(['dispatch' => $data['dispatch'], 'status' => $statusBag], ['id' => 'DESC']);
        if (!$data['bag']) {
            $data['bag'] = new Bags();
            $data['bag']->setNumberBag(count($data['dispatch']->getBags()) + 1)
                ->setWeight(0)
                ->setDispatch($data['dispatch'])
                ->setIsFinalBag(0)
                ->setIsCertified(0)
                ->setStatus($statusBag);

            $em->persist($data['bag']);
            $em->flush();
            $em->refresh($data['dispatch']);
        }

        $data['bags'] = $data['dispatch']->getBags()->toArray(); // Convertimos la colección a un array

        // Ordenamos los bags por su ID
        usort($data['bags'], function ($a, $b) {
            return $a->getId() <=> $b->getId(); // Orden ascendente
        });

        $data['active'] = 'dispatch';
        $data['title'] = 'Crear envases';

        return $this->render('secure/dispatch/new_bags.html.twig', $data);
    }

    #[Route('/{status_dispatch?}', name: 'app_secure_dispatch_index')]
    public function index($status_dispatch, DispatchRepository $dispatchRepository, StatusDispatchRepository $statusDispatchRepository): Response
    {
        if (!$status_dispatch) {
            $status_dispatch = "OPENED";
        }
        $data['status_dispatch'] = $status_dispatch;
        $data['active'] = 'dispatch';
        $statusDispatch = $statusDispatchRepository->findOneBy(['name' => $status_dispatch]);

        if (!$statusDispatch) {
            return $this->redirectToRoute('app_secure_dispatch_index', ['status_dispatch' => 'OPENED']);
        }

        $data['dispatches'] = $dispatchRepository->findBy(['statusDispatch' => $statusDispatch]);
        return $this->render('secure/dispatch/index.html.twig', $data);
    }
}

<?php

namespace App\Controller\Secure;

use App\Constants\ConstantsStatusDispatch;
use App\Entity\Dispatch;
use App\Entity\PostalServiceRange;
use App\Form\DispatchType;
use App\Repository\DispatchRepository;
use App\Repository\OfficesRepository;
use App\Repository\PostalServiceRangeRepository;
use App\Repository\RoutesRepository;
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
            $postalServiceRange =  $postalServiceRangeRepository->findOneBy(['id'=> $request->get('dispatch')['postalServiceRange']]);


            $data['dispatch']->setOriginOffice($originOffice)
            ->setDestinationOffice($destinationOffice)
            ->setRoute($route)
            ->setStatusDispatch($statusDispatch)
            ->setNumberDispatch($request->get('dispatch')['numberDispatch'])
            ->setItinerary($request->get('dispatch')['itinerary'])
            ->setPostalServiceRange($postalServiceRange)
            ->setDispatchCode($originOffice->getImpcCode().$destinationOffice->getImpcCode().'A'.$postalServiceRange->getPrincipalCharacter().$postalServiceRange->getSecondCharacterFrom().substr(date('Y'),-1).str_pad($request->get('dispatch')['numberDispatch'], 4, '0', STR_PAD_LEFT));
            $em->persist($data['dispatch']);
            $em->flush();
            return $this->redirectToRoute('app_secure_dispatch_index',['status_dispatch','OPENED']);
        }
        return $this->render('secure/dispatch/new_dispatch.html.twig', $data);
    }

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
            $postalServiceRange =  $postalServiceRangeRepository->findOneBy(['id'=> $request->get('dispatch')['postalServiceRange']]);

            $data['dispatch']->setOriginOffice($originOffice)
            ->setDestinationOffice($destinationOffice)
            ->setRoute($route)
            ->setStatusDispatch($statusDispatch)
            ->setNumberDispatch($request->get('dispatch')['numberDispatch'])
            ->setItinerary($request->get('dispatch')['itinerary'])
            ->setPostalServiceRange($postalServiceRange)
            ->setDispatchCode($originOffice->getImpcCode().$destinationOffice->getImpcCode().'A'.$postalServiceRange->getPrincipalCharacter().$postalServiceRange->getSecondCharacterFrom().substr(date('Y'),-1).str_pad($request->get('dispatch')['numberDispatch'], 4, '0', STR_PAD_LEFT));
            $em->persist($data['dispatch']);
            $em->flush();
            return $this->redirectToRoute('app_secure_dispatch_index',['status_dispatch','OPENED']);
        }
        return $this->render('secure/dispatch/new_dispatch.html.twig', $data);
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

<?php

namespace App\Controller\Secure;

use App\Entity\Flights;
use App\Form\FlightsType;
use App\Repository\FlightsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/flights')]
class FlightsController extends AbstractController
{
    #[Route('/', name: 'app_secure_flights')]
    public function index(FlightsRepository $flightsRepository): Response
    {
        $data['active'] = 'flights';
        $data['title'] = 'Vuelos';
        $data['flights'] = $flightsRepository->findAll();
        return $this->render('secure/flights/abm_flights.html.twig', $data);
    }

    #[Route('/new', name: 'app_secure_new_flight')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $data['active'] = 'flights';
        $data['title'] = 'Nuevo vuelo';
        $data['flight'] =  new Flights();
        $data['form'] = $this->createForm(FlightsType::class, $data['flight']);
        $data['form']->handleRequest($request);

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $em->persist($data['flight']);
            $em->flush();

            return $this->redirectToRoute('app_secure_flights');
        }
        return $this->render('secure/flights/form_flights.html.twig', $data)->setStatusCode(Response::HTTP_OK);;
    }

    #[Route('/edit/{id}', name: 'app_secure_edit_flight')]
    public function edit(Flights $flight, Request $request, EntityManagerInterface $em): Response
    {
        $data['flight'] = $flight;
        $data['active'] = 'flights';
        $data['title'] = 'Editar vuelo';
        $data['form'] = $this->createForm(FlightsType::class, $data['flight']);
        $data['form']->handleRequest($request);

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $em->persist($data['flight']);
            $em->flush();

            return $this->redirectToRoute('app_secure_flights');
        }
        return $this->render('secure/flights/form_flights.html.twig', $data)->setStatusCode(Response::HTTP_OK);
    }

    #[Route('/search', name: 'app_secure_search_flights', methods: ['POST'])]
    public function search(Request $request, FlightsRepository $flightsRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $originAirport = $data['originAirport'] ?? null;
        $arrivalAirport = $data['arrivalAirport'] ?? null;
        $idFlightsSelected = $data['idFlightsSelected'] ?? [];

        $today = new \DateTime();

        // Crear la consulta
        $qb = $flightsRepository->createQueryBuilder('f')
            ->where('f.originAirport = :originAirport')
            ->andWhere('f.arrivalAirport = :arrivalAirport')
            ->andWhere('f.effectiveDate <= :today')
            ->andWhere('f.discontinueDate >= :today')
            ->setParameter('originAirport', $originAirport)
            ->setParameter('arrivalAirport', $arrivalAirport)
            ->setParameter('today', $today->format('Y-m-d'));

        // Condicional para excluir los vuelos ya seleccionados
        if (!empty($idFlightsSelected)) {
            $qb->andWhere('f.id NOT IN (:idFlightsSelected)')
                ->setParameter('idFlightsSelected', $idFlightsSelected);
        }

        // Ejecutar la consulta
        $flights = $qb->getQuery()->getResult();

        $flightsArray = array_map(function ($flight) {
            return [
                'id' => $flight->getId(),
                'originAirport' => $flight->getOriginAirport(),
                'arrivalAirport' => $flight->getArrivalAirport(),
                'flightNumber' => $flight->getFlightNumber(),
                'flightFrequency' => $flight->getFlightFrequency(),
                'departureTime' => $flight->getDepartureTime(),
                'arrivalTime' => $flight->getArrivalTime(),
                'aircraftType' => $flight->getAircraftType(),
                'effectiveDate' => $flight->getEffectiveDate()->format('Y-m-d'),
                'discontinueDate' => $flight->getDiscontinueDate()->format('Y-m-d'),
            ];
        }, $flights);

        return $this->json($flightsArray);
    }
}

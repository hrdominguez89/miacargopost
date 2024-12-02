<?php

namespace App\Controller\Secure;

use App\Entity\Flights;
use App\Entity\Offices;
use App\Entity\PostalServiceRange;
use App\Entity\Routes;
use App\Entity\RouteServiceRange;
use App\Entity\Segments;
use App\Form\ABMRoutesType;
use App\Form\RoutesType;
use App\Repository\FlightsRepository;
use App\Repository\OfficesRepository;
use App\Repository\PostalServiceRangeRepository;
use App\Repository\RoutesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/routes')]
class RoutesController extends AbstractController
{
    #[Route('/', name: 'app_secure_routes')]
    public function index(OfficesRepository $officesRepository, PostalServiceRangeRepository $postalServiceRangeRepository, Request $request, RoutesRepository $routesRepository): Response
    {
        $data['active'] = 'routes';
        $data['title'] = 'Rutas';
        $data['form'] =  $this->createForm(ABMRoutesType::class);
        $data['routes'] = null;
        $data['form']->handleRequest($request);

        if ($data['form']->isSubmitted() && $data['form']->isValid()) {

            $originOffice = $officesRepository->findOneBy(['impcCode' => $request->get('abm_routes')['originOffice']]);
            $destinationOffice = $officesRepository->findOneBy(['impcCode' => $request->get('abm_routes')['destinationOffice']]);
            $postalServiceRange = $postalServiceRangeRepository->find($request->get('abm_routes')['serviceRange']);

            $data['routes'] = $routesRepository->findByCriteria($originOffice, $destinationOffice, $postalServiceRange);
            // dd($data['routes'][0]->getSegments()[0]->getFlight());
        }
        return $this->render('secure/routes/abm_routes.html.twig', $data)->setStatusCode(Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_secure_new_route')]
    public function new(EntityManagerInterface $em, Request $request, FlightsRepository $flightsRepository, OfficesRepository $officesRepository, PostalServiceRangeRepository $postalServiceRangeRepository): Response
    {
        $data['active'] = 'routes';
        $data['title'] = 'Nueva ruta';
        $data['route'] = new Routes;
        $data['form'] =  $this->createForm(RoutesType::class, $data['route']);

        $data['form']->handleRequest($request);
        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $originOffice = $officesRepository->findOneBy(['impcCode' => $request->get('routes')['originOffice']]);
            $destinationOffice = $officesRepository->findOneBy(['impcCode' => $request->get('routes')['destinationOffice']]);

            $data['route']->setOriginOffice($originOffice);
            $data['route']->setDestinationOffice($destinationOffice);

            foreach ($request->get('routes')['routeServiceRanges'] as $serviceRangeId) {
                $serviceRange =  $postalServiceRangeRepository->find($serviceRangeId);
                $routeServiceRange = new RouteServiceRange;
                $routeServiceRange->setRoutes($data['route']);
                $routeServiceRange->setServiceRange($serviceRange);
                $em->persist($routeServiceRange);
            }

            $segmentsData = json_decode($request->get('routes')['segments'], true);

            $validUntil = null;
            foreach ($segmentsData as $flightData) {
                $flight = $flightsRepository->find($flightData['id']);

                $validUntil = $validUntil ? min($validUntil, $flight->getDiscontinueDate()) : $flight->getDiscontinueDate();

                $segment = new Segments;
                $segment->setRoute($data['route']);
                $segment->setFlight($flight);
                $em->persist($segment);
            }
            $data['route']->setEffectiveFrom(new \DateTime('today'));
            $data['route']->setValidUntil($validUntil);

            $em->persist($data['route']);

            $em->flush();

            return $this->redirectToRoute('app_secure_routes');
        }
        return $this->render('secure/routes/form_routes.html.twig', $data)->setStatusCode(Response::HTTP_OK);
    }


    #[Route('/edit/{id}', name: 'app_secure_edit_route')]
    public function edit(
        $id,
        RoutesRepository $routesRepository,
        EntityManagerInterface $em,
        Request $request,
        FlightsRepository $flightsRepository,
        OfficesRepository $officesRepository,
        PostalServiceRangeRepository $postalServiceRangeRepository
    ): Response {
        $data['active'] = 'routes';
        $data['title'] = 'Editar ruta';
        $data['route'] = $routesRepository->find($id);

        // Crear el formulario
        $data['form'] = $this->createForm(RoutesType::class, $data['route']);

        // Inicializar valores para campos no mapeados
        $data['form']->get('originOffice')->setData($data['route']->getOriginOffice()->getImpcCode());
        $data['form']->get('destinationOffice')->setData($data['route']->getDestinationOffice()->getImpcCode());

        // Inicializar los rangos de servicio (IDs)
        $routeServiceRanges = [];
        foreach ($data['route']->getRouteServiceRanges() as $routeServiceRange) {
            $routeServiceRanges[] = $routeServiceRange->getServiceRange();
        }
        $data['form']->get('routeServiceRanges')->setData($routeServiceRanges);

        // Inicializar los segmentos (convertir a JSON)
        $segmentsData = [];
        foreach ($data['route']->getSegments() as $segment) {
            $flight = $segment->getFlight();
            $segmentsData[] = [
                'id' => $flight->getId(),
                'originAirport' => $flight->getOriginAirport(),
                'arrivalAirport' => $flight->getArrivalAirport(),
                'flightNumber' => $flight->getFlightNumber(),
                'flightFrequency' => $flight->getFlightFrequency(),
                'departureTime' => $flight->getDepartureTime()->format('H:i'),
                'arrivalTime' => $flight->getArrivalTime()->format('H:i'),
                'aircraftType' => $flight->getAircraftType(),
                'effectiveDate' => $flight->getEffectiveDate()->format('Y-m-d'),
                'discontinueDate' => $flight->getDiscontinueDate()->format('Y-m-d'),
            ];
        }
        $data['form']->get('segments')->setData(json_encode($segmentsData));

        // Manejar la solicitud
        $data['form']->handleRequest($request);
        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            $originOffice = $officesRepository->findOneBy(['impcCode' => $request->get('routes')['originOffice']]);
            $destinationOffice = $officesRepository->findOneBy(['impcCode' => $request->get('routes')['destinationOffice']]);

            $data['route']->setOriginOffice($originOffice);
            $data['route']->setDestinationOffice($destinationOffice);

            // Actualizar rangos de servicio
            foreach ($request->get('routes')['routeServiceRanges'] as $serviceRangeId) {
                $serviceRange = $postalServiceRangeRepository->find($serviceRangeId);
                $routeServiceRange = new RouteServiceRange;
                $routeServiceRange->setRoutes($data['route']);
                $routeServiceRange->setServiceRange($serviceRange);
                $em->persist($routeServiceRange);
            }

            // Actualizar segmentos
            $segmentsData = json_decode($request->get('routes')['segments'], true);
            foreach ($segmentsData as $flightData) {
                $flight = $flightsRepository->find($flightData['id']);
                $segment = new Segments;
                $segment->setRoute($data['route']);
                $segment->setFlight($flight);
                $em->persist($segment);
            }

            $em->flush();

            return $this->redirectToRoute('app_secure_routes');
        }

        return $this->render('secure/routes/form_routes.html.twig', $data);
    }
}

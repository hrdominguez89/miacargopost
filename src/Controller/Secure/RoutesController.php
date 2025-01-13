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
use App\Repository\DispatchRepository;
use App\Repository\FlightsRepository;
use App\Repository\OfficesRepository;
use App\Repository\PostalServiceRangeRepository;
use App\Repository\RoutesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $data['form']->handleRequest($request);

        //BORRAR DESDE ACA, SE PUSO A MODO DE EJEMPLO
        $data['routes'] = $routesRepository->findAll();
        //BORRAR HASTA ACA.

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
            $originOffice = $officesRepository->findOneBy(['id' => $request->get('routes')['originOffice']]);
            $destinationOffice = $officesRepository->findOneBy(['id' => $request->get('routes')['destinationOffice']]);

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

        $data['form']->get('originOffice')->setData($data['route']->getOriginOffice()->getId());
        $data['form']->get('destinationOffice')->setData($data['route']->getDestinationOffice()->getId());

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
            $originOffice = $officesRepository->findOneBy(['id' => $request->get('routes')['originOffice']]);
            $destinationOffice = $officesRepository->findOneBy(['id' => $request->get('routes')['destinationOffice']]);

            $data['route']->setOriginOffice($originOffice);
            $data['route']->setDestinationOffice($destinationOffice);

            // Actualizar rangos de servicio
            foreach ($data['route']->getRouteServiceRanges() as $routeServiceRange) {
                $em->remove($routeServiceRange);
            }
            $em->flush();
            foreach ($request->get('routes')['routeServiceRanges'] as $serviceRangeId) {
                $serviceRange = $postalServiceRangeRepository->find($serviceRangeId);
                $routeServiceRange = new RouteServiceRange;
                $routeServiceRange->setRoutes($data['route']);
                $routeServiceRange->setServiceRange($serviceRange);
                $em->persist($routeServiceRange);
            }

            // Actualizar segmentos
            $segmentsData = json_decode($request->get('routes')['segments'], true);
            //elimino todos los segmentos antes de insertar otros.
            foreach ($data['route']->getSegments() as $segment) {
                $em->remove($segment);
            }
            $em->flush();
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

    #[Route('/search', name: 'app_secure_search_routes', methods: ['POST'])]
    public function search(Request $request, RoutesRepository $routesRepository, DispatchRepository $dispatchRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $originOffice = $data['originOffice'] ?? null;
        $destinationOffice = $data['destinationOffice'] ?? null;
        $claseSubclase = $data['claseSubclase'] ?? null;

        $route = $routesRepository->findByCriteriaDate($originOffice, $destinationOffice, $claseSubclase);

        if (!$route) {
            return new JsonResponse([
                'status_code' => Response::HTTP_NOT_FOUND,
                'messages' => 'No existe ruta para este despacho.'
            ], Response::HTTP_NOT_FOUND);
        }

        $horaInicio = new DateTime(); // Hora actual
        $margenMinimo = 3;

        $flights = [];
        foreach ($route->getSegments() as $segment) {
            $flight = $segment->getFlight();

            $flights[] = [
                'flightNumber' => $flight->getFlightNumber(),
                'originAirport' => $flight->getOriginAirport(),
                'arrivalAirport' => $flight->getArrivalAirport(),
                'departureTime' => $flight->getDepartureTime()->format('H:i'),
                'arrivalTime' => $flight->getArrivalTime()->format('H:i'),
                'aircraftType' => $flight->getAircraftType(),
                'frecuency' => $flight->getFlightFrequency(),
            ];
        }

        // Convertir los vuelos al formato solicitado
        $firstFlight = '';
        $dateFirstFlight = '';
        $count = 0;
        $formattedFlights = [];
        foreach ($flights as $flight) {
            $proximoVuelo = $this->calcularProximoVuelo($horaInicio, [$flight], $margenMinimo);
            if ($proximoVuelo) {
                if ($count == 0) {
                    $firstFlight = str_replace(' ', '', $flight['flightNumber']);
                    $dateFirstFlight = date("D, d F Y, ", strtotime($proximoVuelo['fecha'])) . date("H:i", strtotime($proximoVuelo['horaSalida']));;
                    $count++;
                }
                $formattedFlights[] = sprintf('%s %s %s %s', date('d', strtotime($proximoVuelo['fecha'])), $flight['originAirport'], str_replace(' ', '', $flight['flightNumber']), $flight['arrivalAirport']);
                $horaInicio = new DateTime($proximoVuelo['horaDisponible']); // Actualizar hora de inicio para el próximo vuelo
            }
        }

        // Devolver los vuelos como cadena separada por comas
        $formattedFlightsString = implode(', ', $formattedFlights);

        return new JsonResponse([
            'status_code' => Response::HTTP_OK,
            'flights' => [
                'routeId' => $route->getId(), 
                'itinerary' => $formattedFlightsString,
                'firstFlight' => $firstFlight,
                'dateFirstFlight' => $dateFirstFlight,
                'numberDispatch' => $this->obtenerNumeroDespacho($dispatchRepository, $originOffice, $destinationOffice, $claseSubclase),
            ]
        ], Response::HTTP_OK);
    }

    private function calcularProximoVuelo($horaInicio, $vuelos, $margenMinimo)
    {
        // Mapa de días de la semana
        $mapaDias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];

        // Convertir hora de inicio en DateTime
        $horaActual = clone $horaInicio;

        foreach ($vuelos as $vuelo) {
            // Recorrer hasta encontrar el próximo vuelo disponible
            for ($i = 0; $i < 7; $i++) {
                $diaIterado = ($horaActual->format('N') + $i - 1) % 7 + 1; // Día iterado en ciclo semanal

                if (strpos($vuelo['frecuency'], (string)$diaIterado) !== false) {
                    // Crear DateTime para la salida y llegada
                    $salida = clone $horaActual;
                    $salida->modify("+$i days");
                    $salida->setTime(...explode(':', $vuelo['departureTime']));

                    $llegada = clone $salida;
                    $llegada->setTime(...explode(':', $vuelo['arrivalTime']));
                    if ($llegada < $salida) {
                        $llegada->modify('+1 day');
                    }

                    // Verificar si la salida cumple con el margen
                    if ($salida >= $horaActual->modify("+$margenMinimo hours")) {
                        return [
                            'vuelo' => $vuelo['flightNumber'],
                            'dia' => $mapaDias[$diaIterado],
                            'fecha' => $salida->format('Y-m-d'),
                            'horaSalida' => $salida->format('H:i'),
                            'horaLlegada' => $llegada->format('H:i'),
                            'horaDisponible' => $llegada->modify("+$margenMinimo hours")->format('Y-m-d H:i'),
                        ];
                    }
                }
            }
        }

        return null; // No se encontró un vuelo disponible
    }

    private function obtenerNumeroDespacho($dispatchRepository, $originOffice, $destinationOffice, $claseSubclase)
    {
        $currentYear = (new \DateTime())->format('Y');

        // Obtener el último despacho para la misma subclase, origen, destino y año
        $ultimoDespacho = $dispatchRepository->findOneBy(
            [
                'originOffice' => $originOffice,
                'destinationOffice' => $destinationOffice,
                'postalServiceRange' => $claseSubclase,
            ],
            ['createdAt' => 'DESC'] // Ordenar por fecha de creación descendente
        );

        // Verificar si pertenece al año actual
        if ($ultimoDespacho && $ultimoDespacho->getCreatedAt()->format('Y') === $currentYear) {
            return $ultimoDespacho->getNumberDispatch() + 1;
        }

        // Si no hay despachos o son de otro año, iniciar en 1
        return 1;
    }
}

<?php

namespace App\Controller\Secure;

use App\Entity\Flights;
use App\Entity\Routes;
use App\Entity\Segments;
use App\Form\ABMRoutesType;
use App\Form\RoutesType;
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
    public function index(RoutesRepository $routesRepository): Response
    {
        $data['active'] = 'routes';
        $data['title'] = 'Rutas';
        $data['form'] =  $this->createForm(ABMRoutesType::class);
        $data['routes'] = $routesRepository->findAll();
        return $this->render('secure/routes/abm_routes.html.twig', $data);
    }

    #[Route('/new', name: 'app_secure_new_route')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $data['active'] = 'routes';
        $data['title'] = 'Nueva ruta';
        $data['route'] = new Routes;
        $data['form'] =  $this->createForm(RoutesType::class, $data['route']);
        if ($data['form']->isSubmitted() && $data['form']->isValid()) {
            // Persistir la ruta en la base de datos
            $em->persist($data['route']);

            // Capturar los segmentos seleccionados desde el formulario o los datos adicionales
            $segmentsData = json_decode($request->request->get('segments'), true); // Esto debe coincidir con el campo oculto "segmentsInput"

            // Crear y persistir cada segmento
            foreach ($segmentsData as $segmentData) {
                $flight = $em->getRepository(Flights::class)->find($segmentData['id']);
                if ($flight) {
                    $segment = new Segments();
                    $segment->setRoute($data['route']);
                    $segment->setFlight($flight);

                    $em->persist($segment);
                }
            }

            // Guardar los cambios en la base de datos
            $em->flush();

            // Redirigir a la lista de rutas
            return $this->redirectToRoute('app_secure_routes');
        }
        return $this->render('secure/routes/form_routes.html.twig', $data);
    }
}

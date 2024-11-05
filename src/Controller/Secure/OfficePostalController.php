<?php

namespace App\Controller\Secure;

use App\Repository\OfficesRepository;
use App\Form\OfficeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/office-postal')]

class OfficePostalController extends AbstractController
{
    #[Route('/', name: 'app_secure_office_postal')]
    public function index(OfficesRepository $officesRepository): Response
    {
        
        $data['offices'] = $officesRepository->findAll();
        return $this->render('secure/office_postal/index.html.twig', $data);
    }
    #[Route('/add', name: 'app_secure_office_postal_form_add')]
    public function add(Request $request): Response
    {
        
        $form = $this->createForm(OfficeType::class);
        return $this->render('secure/office_postal/add.html.twig',
        ['officesForm' => $form->createView(),]);
    }
}

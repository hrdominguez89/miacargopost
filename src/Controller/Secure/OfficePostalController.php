<?php

namespace App\Controller\Secure;

use App\Entity\Offices;
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
        $office = new Offices();
        $form = $this->createForm(OfficeType::class, $office);
        
        $form->handleRequest($request);
        if (  $form->isSubmitted() && $form->isValid()){
            dd($request);
            /* $em->persist($office);
            $em->flush(); */
        }
        
        return $this->render('secure/office_postal/add.html.twig',
        ['officeForm' => $form->createView(),]);
        
    }
}

<?php

namespace App\Controller\Secure;

use App\Entity\Offices;
use App\Repository\OfficesRepository;
use App\Form\OfficeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/office-postal')]

class OfficePostalController extends AbstractController
{
    /** @required */ 
    public EntityManagerInterface $em;
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
        
        $form->handleRequest($request);
        if (  $form->isSubmitted() && $form->isValid()){

            $office = $form->getData();
            /* Category Inbound */
            $office->setCategoryAInbound($form->get('categoryAInbound')->getData()? 'A' : '');
            $office->setCategoryBInbound($form->get('categoryBInbound')->getData()? 'B' : '');
            $office->setCategoryCInbound($form->get('categoryCInbound')->getData()? 'C' : '');
            $office->setCategoryDInbound($form->get('categoryDInbound')->getData()? 'D' : '');
            /* Category Outbound */
            $office->setCategoryAOutbound($form->get('categoryAOutbound')->getData()? 'A' : '');
            $office->setCategoryBOutbound($form->get('categoryBOutbound')->getData()? 'B' : '');
            $office->setCategoryCOutbound($form->get('categoryCOutbound')->getData()? 'C' : '');
            $office->setCategoryDOutbound($form->get('categoryDOutbound')->getData()? 'D' : '');
            /* Mail Class Inbound*/
            $office->setMailClassUInbound($form->get('mailClassUInbound')->getData()? 'U' : '');
            $office->setMailClassCInbound($form->get('mailClassCInbound')->getData()? 'C' : '');
            $office->setMailClassEInbound($form->get('mailClassEInbound')->getData()? 'E' : '');
            $office->setMailClassTInbound($form->get('mailClassTInbound')->getData()? 'T' : '');
            /* Mail Class Outbound */
            $office->setMailClassUOutbound($form->get('mailClassUOutbound')->getData()? 'U' : '');
            $office->setMailClassCOutbound($form->get('mailClassCOutbound')->getData()? 'C' : '');
            $office->setMailClassEOutbound($form->get('mailClassEOutbound')->getData()? 'E' : '');
            $office->setMailClassTOutbound($form->get('mailClassTOutbound')->getData()? 'T' : '');
            

            /* dd($office); */
            $this->em->persist($office);
            $this->em->flush();

            return $this->redirectToRoute('app_secure_office_postal');
        }
        
        return $this->render('secure/office_postal/add.html.twig',
        ['officeForm' => $form->createView(),]);
        
    }
}

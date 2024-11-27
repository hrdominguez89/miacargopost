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
    #[Route('/local', name: 'app_secure_office_postal_local')]
    public function indexLocal(OfficesRepository $officesRepository): Response
    {
        
        $data['offices'] = $officesRepository->findAll();
        return $this->render('secure/office_postal/indexLocal.html.twig', $data);
    }
    #[Route('/add', name: 'app_secure_office_postal_form_add')]
    public function add(Request $request): Response
    {
        
        $form = $this->createForm(OfficeType::class);
        
        $form->handleRequest($request);
        if (  $form->isSubmitted() && $form->isValid()){

            $office = $form->getData();
            /* Mail */
            $office->setMailFlowInbound($form->get('mailFlowInbound')->getData()? 'I' : '');
            $office->setMailFlowOutbound($form->get('mailFlowOutbound')->getData()? 'E' : '');
            $office->setMailFlowClosedTransit($form->get('mailFlowClosedTransit')->getData()? 'T' : '');
            
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

            flash()->success('Oficina creada con exito');
            $this->addFlash('success', 'Oficina creada con éxito');

            return $this->redirectToRoute('app_secure_office_postal');
        }
        
        return $this->render('secure/office_postal/add.html.twig',
        ['officeForm' => $form->createView(),]);
        
    }
    #[Route('/edit/{id}', name: 'app_secure_office_postal_form_edit')]
    public function edit(Request $request, int $id): Response
    {
        $office = $this->em->getRepository(Offices::class)->find($id);

        if (!$office) {
            throw $this->createNotFoundException('Officina no existe.' . $id);
        }
         
        $form = $this->createForm(OfficeType::class);  

        
         
        $form->get('impcCode')->setData($office->getImpcCode());
        $form->get('impcShortName')->setData($office->getImpcShortName());
        $form->get('OrganisationShortName')->setData($office->getOrganisationShortName());
        $form->get('impcCodeFullName')->setData($office->getImpcCodeFullName());
        $form->get('organisationFullName')->setData($office->getOrganisationFullName());
        $form->get('impcOrganisationCode')->setData($office->getimpcOrganisationCode());
        $form->get('partyIdentifier')->setData($office->getpartyIdentifier());
        $form->get('function')->setData($office->getfunction());
        $form->get('validFrom')->setData($office->getValidFrom());
        $form->get('validTo')->setData($office->getValidTo());

        /* Mail */
        $form->get('mailFlowInbound')->setData($office->getMailFlowInbound() === 'I');
        $form->get('mailFlowOutbound')->setData($office->getMailFlowOutbound() === 'E');
        $form->get('mailFlowClosedTransit')->setData($office->getMailFlowClosedTransit() === 'T');
        
        /* Category Inbound */
        $form->get('categoryAInbound')->setData($office->getCategoryAInbound() === 'A');
        $form->get('categoryBInbound')->setData($office->getCategoryBInbound() === 'B');
        $form->get('categoryCInbound')->setData($office->getCategoryCInbound() === 'C');
        $form->get('categoryDInbound')->setData($office->getCategoryDInbound() === 'D');
        
        /* Category Outbound */
        $form->get('categoryAOutbound')->setData($office->getCategoryAOutbound() === 'A');
        $form->get('categoryBOutbound')->setData($office->getCategoryBOutbound() === 'B');
        $form->get('categoryCOutbound')->setData($office->getCategoryCOutbound() === 'C');
        $form->get('categoryDOutbound')->setData($office->getCategoryDOutbound() === 'D');

        /* Mail Class Inbound*/ 
        $form->get('mailClassUInbound')->setData($office->getMailClassUInbound() === 'U');
        $form->get('mailClassCInbound')->setData($office->getMailClassCInbound() === 'C');
        $form->get('mailClassEInbound')->setData($office->getMailClassEInbound() === 'E');
        $form->get('mailClassTInbound')->setData($office->getMailClassTInbound() === 'T');
        /* Mail Class Outbound */
        $form->get('mailClassUOutbound')->setData($office->getMailClassUOutbound() === 'U');
        $form->get('mailClassCOutbound')->setData($office->getMailClassCOutbound() === 'C');
        $form->get('mailClassEOutbound')->setData($office->getMailClassEOutbound() === 'E');
        $form->get('mailClassTOutbound')->setData($office->getMailClassTOutbound() === 'T');

        $form->get('specialType')->setData($office->getSpecialType()); 
        $form->get('bilateralAgreement')->setData($office->getBilateralAgreement()); 
        $form->get('specialRestrictions')->setData($office->getSpecialRestrictions()); 
        $form->get('isLocal')->setData($office->isIsLocal()); 



        $form->handleRequest($request);

        if (  $form->isSubmitted() && $form->isValid()){

            $office->setImpcCode($form->get('impcCode')->getData());
            $office->setImpcShortName($form->get('impcShortName')->getData());
            $office->setOrganisationShortName($form->get('OrganisationShortName')->getData());
            $office->setImpcCodeFullName($form->get('impcCodeFullName')->getData());
            $office->setOrganisationFullName($form->get('organisationFullName')->getData());
            $office->setImpcOrganisationCode($form->get('impcOrganisationCode')->getData());
            $office->setPartyIdentifier($form->get('partyIdentifier')->getData());
            $office->setFunction($form->get('function')->getData());
            $office->setValidFrom($form->get('validFrom')->getData());
            $office->setValidTo($form->get('validTo')->getData());
            
            /* Mail */
            $office->setMailFlowInbound($form->get('mailFlowInbound')->getData()? 'I' : '');
            $office->setMailFlowOutbound($form->get('mailFlowOutbound')->getData()? 'E' : '');
            $office->setMailFlowClosedTransit($form->get('mailFlowClosedTransit')->getData()? 'T' : '');
            
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
            $office->setSpecialType($form->get('specialType')->getData());
            $office->setBilateralAgreement($form->get('bilateralAgreement')->getData());
            $office->setSpecialRestrictions($form->get('specialRestrictions')->getData());
            $office->setIsLocal($form->get('isLocal')->getData());

            
            
            try{

                $this->em->flush();
                flash()->success('Oficina Editada con exito');
                $this->addFlash('success', 'Oficina Modificada con éxito');
                return $this->redirectToRoute('app_secure_office_postal');

            }catch(\Exception $e){
                return $this->redirectToRoute('app_secure_office_postal_form_edit', ['id' => $id]);
            }
            /* dd($office); */
            

            
        }else{

            return $this->render('secure/office_postal/edit.html.twig',
            ['officeForm' => $form->createView(),
                         'office' => $office,]);
        }
        
        
    }
    #[Route('/delete/{id}', name: 'app_secure_office_postal_form_delete')]
    public function delete(Request $request, int $id): Response
    {
        $office = $this->em->getRepository(Offices::class)->find($id);

        if (!$office) {
            throw $this->createNotFoundException('Officina no existe.' . $id);
        }
        $this->em->remove($office);
        $this->em->flush();
        flash()->success('Oficina Eliminada con exito');
        $this->addFlash('success', 'Oficina Borrada con éxito');
        return $this->redirectToRoute('app_secure_office_postal');
    }
}

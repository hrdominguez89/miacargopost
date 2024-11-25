<?php

namespace App\Controller\Secure;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ClientType;
use App\Repository\AddressRepository;
use App\Entity\Client;
use App\Entity\Address;

#[Route('/customer')]

class CustomerController extends AbstractController
{
    /** @required */ 
    public EntityManagerInterface $em;
    #[Route('/', name: 'app_secure_customer')]
    public function index(ClientRepository $clientRepository, AddressRepository $addressRepository): Response
    {
        $data['clients'] = $clientRepository->findAll();
        return $this->render('secure/customer/index.html.twig', 
            $data
        );
    }

    #[Route('/add', name: 'app_secure_customer_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(ClientType::class);
        
        $form->handleRequest($request);

        if (  $form->isSubmitted() && $form->isValid()){
            $client = $form->getData();
            $address = new Address();
            $address->setCountry($form->get('country')->getData());
            $address->setProvince($form->get('province')->getData());
            $address->setState($form->get('state')->getData());
            $address->setAddress($form->get('address')->getData());
            $address->setZipCode($form->get('postalCode')->getData());
            $address->setAdditionalInformation($form->get('aditionalInformation')->getData());
            
            $client->addClientAddress($address);
           
            $this->em->persist($client); 

            $this->em->flush();

            flash()->success('Cliente Agregado con éxito');

            return $this->redirectToRoute('app_secure_customer');
        }
        return $this->render('secure/customer/add.html.twig', 
        ['clientForm' => $form->createView(),]
        );
    }
}

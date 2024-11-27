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
use Symfony\Component\Form\FormError;

#[Route('/customer')]

class CustomerController extends AbstractController
{
    /** @required */
    public EntityManagerInterface $em;
    #[Route('/', name: 'app_secure_customer')]
    public function index(ClientRepository $clientRepository, AddressRepository $addressRepository): Response
    {
        $data['clients'] = $clientRepository->findAll();
        return $this->render(
            'secure/customer/index.html.twig',
            $data
        );
    }

    #[Route('/add', name: 'app_secure_customer_add')]
    public function add(Request $request): Response
    {
        $address = new Address();
        $client = new Client();
        $client->addClientAddress($address);
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            foreach ($client->getClientAddresses() as $clientAddress) {
                $this->em->persist($clientAddress);
            }
            /* $address = new Address();
            $address->setCountry($form->get('country')->getData());
            $address->setProvince($form->get('province')->getData());
            $address->setState($form->get('state')->getData());
            $address->setAddress($form->get('address')->getData());
            $address->setZipCode($form->get('postalCode')->getData());
            $address->setAdditionalInformation($form->get('aditionalInformation')->getData()); */

            /* $client->addClientAddress($address);  */
            if (count($client->getClientAddresses()) > 5) {
                $form->addError(new FormError('No puedes agregar más de 5 direcciones.'));
            }else{
                $this->em->persist($client);
                $this->addFlash('success', 'Cliente Agregado con éxito');
                flash()->success('Cliente Agregado con éxito');
                $this->em->flush();
                return $this->redirectToRoute('app_secure_customer');
            }
        }
        return $this->render(
            'secure/customer/add.html.twig',
            ['clientForm' => $form->createView(),]
        );
    }

    #[Route('/edit/{id}', name: 'app_secure_customer_edit')]
    public function edit(Request $request, int $id): Response
    {
        $client = $this->em->getRepository(Client::class)->find($id);

        if (!$client) {
            throw $this->createNotFoundException('Cliente no existe.' . $id);
        }

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            foreach ($client->getClientAddresses() as $clientAddress) {
                $this->em->persist($clientAddress);
            }
            $this->em->flush();
            flash()->success('Cliente Editado con éxito');
            $this->addFlash('success', 'Cliente Editado con éxito');
            return $this->redirectToRoute('app_secure_customer');
        }
        return $this->render(
            'secure/customer/edit.html.twig',
            ['clientForm' => $form->createView(), 'client' => $client]
        );
    }
    #[Route('/delete/{id}', name: 'app_secure_customer_delete')]
    public function delete(Request $request, int $id): Response
    {
        $client = $this->em->getRepository(Client::class)->find($id);

        if (!$client) {
            throw $this->createNotFoundException('Officina no existe.' . $id);
        }
        $this->em->remove($client);
        $this->em->flush();
        flash()->success('Cliente Eliminado con exito');
        $this->addFlash('success', 'Cliente Borrado con éxito');
        return $this->redirectToRoute('app_secure_customer');
    }
}

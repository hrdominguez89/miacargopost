<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;




class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombres',
                'required' => true,])
            ->add('typeDocument',TextType::class, [
                'label' => 'Tipo de documento',
                'required' => true,])
            ->add('document',TextType::class, [
                'label' => 'Documento',
                'required' => true,])
            ->add('email',EmailType::class, [
                'label' => 'email',
                'required' => true,])
            ->add('telephone',TextType::class, [
                'label' => 'Teléfono',
                'required' => true,])
            ->add('clientAddresses', CollectionType::class, [
                'entry_type' => AddressType::class, 
                'entry_options' => ['label' => false], 
                'allow_add' => true, 
                'allow_delete' => true, // Permitir eliminar pedidos
                'by_reference' => false, // Es importante para que los pedidos se gestionen correctamente
                'label' => ' ',
                'prototype' => true
            ])
            
            ->add('Guardar', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}

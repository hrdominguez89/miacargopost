<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('country', CountryType::class,[
            'label' => 'País',                       
           'required' => true,
        ])
        ->add('province', TextType::class , [
            'label' => 'Provincia', 
            'attr' => ['placeholder' => 'Escribe la provincia'],
            
           'required' => true,
           
        ])
        ->add('state', TextType::class , [
            'label' => 'Estado', 
            'attr' => ['placeholder' => 'Escribe el estado'],
            
           'required' => true,
           
        ])
        ->add('address', TextType::class , [
            'label' => 'Dirección', 
            'attr' => ['placeholder' => 'Escriba su dirección'],
            
           'required' => true,
           
        ])
        ->add('zipCode', TextType::class , [
            'label' => 'Código postal', 
            'attr' => ['placeholder' => 'Escriba su código postal'],
            
           'required' => true,
           
        ])
        ->add('additionalInformation', TextType::class , [
            'label' => 'Información adicional', 
            'attr' => ['placeholder' => 'edificio de color rojo, entre calles'],
            
           'required' => false,
           
        ])
            /* ->add('country')
            ->add('province')
            ->add('state')
            ->add('address')
            ->add('zipCode')
            ->add('additionalInformation')
            ->add('client') */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

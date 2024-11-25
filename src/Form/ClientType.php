<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('typeDocument')
            ->add('document')
            ->add('email')
            ->add('telephone')
            ->add('country', CountryType::class,[
                'label' => 'País', 
                'mapped' => false,               
               'required' => true,
            ])
            ->add('province', TextType::class , [
                'label' => 'Provincia', 
                'attr' => ['placeholder' => 'Escribe la provincia'],
                
               'required' => true,
               'mapped' => false,
            ])
            ->add('state', TextType::class , [
                'label' => 'Estado', 
                'attr' => ['placeholder' => 'Escribe el estado'],
                
               'required' => true,
               'mapped' => false,
            ])
            ->add('address', TextType::class , [
                'label' => 'Dirección', 
                'attr' => ['placeholder' => 'Escriba su dirección'],
                
               'required' => true,
               'mapped' => false,
            ])
            ->add('postalCode', TextType::class , [
                'label' => 'Código postal', 
                'attr' => ['placeholder' => 'Escriba su código postal'],
                
               'required' => true,
               'mapped' => false,
            ])
            ->add('aditionalInformation', TextType::class , [
                'label' => 'Información adicional', 
                'attr' => ['placeholder' => 'edificio de color rojo, entre calles'],
                
               'required' => false,
               'mapped' => false,
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

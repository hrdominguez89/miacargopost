<?php

namespace App\Form;

use App\Entity\Offices;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfficeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('impcCode')
            ->add('impcShortName')
            ->add('OrganisationShortName')
            ->add('impcCodeFullName')
            ->add('organisationFullName')
            ->add('impcOrganisationCode')
            ->add('partyIdentifier')
            ->add('function')
            ->add('validFrom', DateType::class,
        ['widget' => 'single_text', ])
            ->add('validTo', DateType::class,
            ['widget' => 'single_text', ])
            ->add('mailFlowInbound')
            ->add('mailFlowOutbound')
            ->add('mailFlowClosedTransit')
            ->add('categoryAInbound', ChoiceType::class, [
                'label' => ' ',
               'choices' => [
                'Category A Inbound' => 'A',               
                            
               ],
                'required' => false,
                'expanded' => true,  // Render as checkbox
                'multiple' => true, // Single checkbox
                'empty_data' => 'null', // Set to null if unchecked
                
               
               
            ])
            ->add('categoryBInbound')
            ->add('categoryCInbound')
            ->add('categoryDInbound')
            ->add('CategoryAOutbound')
            ->add('categoryBOutbound')
            ->add('categoryCOutbound')
            ->add('categoryDOutbound')
            ->add('mailClassUInbound')
            ->add('mailClassCInbound')
            ->add('mailClassEInbound')
            ->add('mailClassTInbound')
            ->add('mailClassUOutbound')
            ->add('mailClassCOutbound')
            ->add('mailClassEOutbound')
            ->add('mailClassTOutbound')
            ->add('specialType')
            ->add('bilateralAgreement')
            ->add('specialRestrictions')
            ->add('Crear', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offices::class,
        ]);
    }
}

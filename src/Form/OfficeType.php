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
            ->add('mailFlowInbound', CheckboxType::class, [
                'label' => 'Mail Flow Inbound',
                'required' => false,
            ])
            ->add('mailFlowOutbound', CheckboxType::class, [
                'label' => 'Mail Flow Outbound',
                'required' => false,
            ])
            ->add('mailFlowClosedTransit', CheckboxType::class, [
                'label' => 'Mail Flow Closed Transit',
                'required' => false,
            ])
            ->add('categoryAInbound', CheckboxType::class, [
                'label' => 'Category A Inbound',
                'required' => false,
            ])           
            ->add('categoryBInbound', CheckboxType::class, [
                'label' => 'Category B Inbound',
                'required' => false,
            ])
            ->add('categoryCInbound', CheckboxType::class, [
                'label' => 'Category C Inbound',
                'required' => false,
            ])
            ->add('categoryDInbound', CheckboxType::class, [
                'label' => 'Category D Inbound',
                'required' => false,
            ])
            ->add('categoryAOutbound', CheckboxType::class,[
                'label'=> 'Category A Outbound',
                'required'=> false
            ])
            ->add('categoryBOutbound', CheckboxType::class,[
                'label'=> 'Category B Outbound',
                'required'=> false
            ])
            ->add('categoryCOutbound', CheckboxType::class,[
                'label'=> 'Category C Outbound',
                'required'=> false
            ])
            ->add('categoryDOutbound', CheckboxType::class,[
                'label'=> 'Category D Outbound',
                'required'=> false
            ])
            ->add('mailClassUInbound', CheckboxType::class,[
                'label'=> 'Mail Class U Inbound',
                'required'=> false])
            ->add('mailClassCInbound', CheckboxType::class,[
                'label'=> 'Mail Class C Inbound',
                'required'=> false])
            ->add('mailClassEInbound', CheckboxType::class,[
                'label'=> 'Mail Class E Inbound',
                'required'=> false])
            ->add('mailClassTInbound', CheckboxType::class,[
                'label'=> 'Mail Class T Inbound',
                'required'=> false])
            ->add('mailClassUOutbound', CheckboxType::class,[
                'label'=> 'Mail class U Outbound',
                'required'=> false
            ])
            ->add('mailClassCOutbound', CheckboxType::class,[
                'label'=> 'Mail class C Outbound',
                'required'=> false
            ])
            ->add('mailClassEOutbound', CheckboxType::class,[
                'label'=> 'Mail class E Outbound',
                'required'=> false
            ])
            ->add('mailClassTOutbound', CheckboxType::class,[
                'label'=> 'Mail class T Outbound',
                'required'=> false
            ])
            ->add('specialType')
            ->add('bilateralAgreement')
            ->add('specialRestrictions')
            ->add('isLocal', CheckboxType::class,[
                'label'=> 'Is Local',
                'required'=> false
            ])
            ->add('Guardar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offices::class,
        ]);
    }
}

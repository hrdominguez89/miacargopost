<?php

namespace App\Form;

use App\Entity\Offices;
use Symfony\Component\Form\AbstractType;
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
            ->add('validFrom')
            ->add('validTo')
            ->add('mailFlowInbound')
            ->add('mailFlowOutbound')
            ->add('mailFlowClosedTransit')
            ->add('categoryAInbound')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offices::class,
        ]);
    }
}

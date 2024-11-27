<?php

namespace App\Form;

use App\Repository\OfficesRepository;
use App\Repository\PostalServiceRangeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ABMRoutesType extends AbstractType
{
    private OfficesRepository $officesRepository;
    private PostalServiceRangeRepository $postalServiceRangeRepository;

    public function __construct(OfficesRepository $officesRepository, PostalServiceRangeRepository $postalServiceRangeRepository)
    {
        $this->officesRepository = $officesRepository;
        $this->postalServiceRangeRepository = $postalServiceRangeRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('originOffice', ChoiceType::class, [
                'choices' => $this->officesRepository->getCountriesFromOfficesQueryBuilder('A'),
                'placeholder' => 'Seleccione una oficina de origen',
                'label' => 'Oficina de origen <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label']
            ])
            ->add('destinationOffice', ChoiceType::class, [
                'choices' => $this->officesRepository->getCountriesFromOfficesQueryBuilder('A'),
                'placeholder' => 'Seleccione una oficina de destino',
                'label' => 'Oficina de destino <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label']
            ])
            ->add('serviceRange', ChoiceType::class, [
                'choices' => $this->postalServiceRangeRepository->getPostalServiceRange(),
                'placeholder' => 'Seleccione una Clase/Subclase',
                'label' => 'Clase/Subclase <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

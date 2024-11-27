<?php

namespace App\Form;

use App\Entity\PostalServiceRange;
use App\Entity\Routes;
use App\Entity\RouteServiceRange;
use App\Repository\OfficesRepository;
use App\Repository\PostalServiceRangeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoutesType extends AbstractType
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
            ->add('routeServiceRanges', EntityType::class, [
                'class' => PostalServiceRange::class,
                'choice_label' => function (PostalServiceRange $range) {
                    return $range->getPostalService()->getPostalProduct()->getName() . '-' . $range->getPostalService()->getName() . ' (' . $range->getPrincipalCharacter() . $range->getSecondCharacterFrom() . '-' . $range->getPrincipalCharacter() . $range->getSecondCharacterTo() . ')';
                },
                'placeholder' => 'Seleccione una Clase/Subclase',
                'label' => 'Clase/Subclase <span class="text-danger">*</span>',
                'required' => false,
                'label_html' => true,
                'multiple' => true,
                'expanded' => false,
                'attr' => ['class' => 'choice_multiple_default']
            ])
            ->add('originOffice', ChoiceType::class, [
                'choices' => $this->officesRepository->getCountriesFromOfficesQueryBuilder('A'),
                'placeholder' => 'Seleccione una oficina de origen',
                'label' => 'Oficina de origen <span class="text-danger">*</span>',
                'required' => false,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label']
            ])
            ->add('destinationOffice', ChoiceType::class, [
                'choices' => $this->officesRepository->getCountriesFromOfficesQueryBuilder('A'),
                'placeholder' => 'Seleccione una oficina de destino',
                'label' => 'Oficina de destino <span class="text-danger">*</span>',
                'required' => false,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label']
            ])
            ->add('originAirport', ChoiceType::class, [
                'choices' => $this->officesRepository->findUniqueAirportsWithCountryName('A'),
                'placeholder' => 'Seleccione un aeropuerto',
                'label' => 'Aeropuerto de origen <span class="text-danger">*</span>',
                'required' => false,
                'label_html' => true,
                'mapped' => false,
                'attr' => ['class' => 'choices-single-default-label']
            ])
            ->add('arrivalAirport', ChoiceType::class, [
                'choices' => $this->officesRepository->findUniqueAirportsWithCountryName('A'),
                'placeholder' => 'Seleccione un aeropuerto',
                'label' => 'Aeropuerto de destino <span class="text-danger">*</span>',
                'required' => false,
                'label_html' => true,
                'mapped' => false,
                'attr' => ['class' => 'choices-single-default-label']
            ])
            ->add('segments', ChoiceType::class, [
                'mapped' => false, // No relacionado con la entidad
                'required' => false,
                'attr' => [
                    'type' => 'hidden', // Campo oculto
                    'id' => 'segmentsInput' // Será gestionado por JavaScript
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Routes::class,
        ]);
    }
}

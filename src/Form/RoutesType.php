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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RoutesType extends AbstractType
{
    private OfficesRepository $officesRepository;

    public function __construct(OfficesRepository $officesRepository)
    {
        $this->officesRepository = $officesRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('originOffice', ChoiceType::class, [
                'choices' => $this->officesRepository->getCountriesFromOfficesQueryBuilder('A'),
                'placeholder' => 'Seleccione una oficina de origen',
                'label' => 'Oficina de origen <span class="text-danger">*</span>',
                'mapped' => false,
                'required' => false,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label'],
                'constraints' => [
                    new NotNull(['message' => 'Debe seleccionar una oficina de origen.']),
                ]
            ])
            ->add('destinationOffice', ChoiceType::class, [
                'choices' => $this->officesRepository->getCountriesFromOfficesQueryBuilder('A'),
                'placeholder' => 'Seleccione una oficina de destino',
                'label' => 'Oficina de destino <span class="text-danger">*</span>',
                'required' => false,
                'mapped' => false,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label'],
                'constraints' => [
                    new NotNull(['message' => 'Debe seleccionar una oficina de destino.']),
                ]
            ])
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
                'mapped' => false,
                'attr' => ['class' => 'choice_multiple_default'],
                'constraints' => [
                    new Callback([
                        'callback' => function ($value, ExecutionContextInterface $context) {
                            if (empty($value) || count($value) === 0) {
                                $context
                                    ->buildViolation('Debe seleccionar al menos una Clase/Subclase.')
                                    ->addViolation();
                            }
                        },
                    ]),
                ],
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
            ->add('segments', HiddenType::class, [
                'mapped' => false, // No relacionado con la entidad
                'required' => false,
                'attr' => [
                    'id' => 'segmentsInput' // Será gestionado por JavaScript
                ],
                'constraints' => [
                    new NotNull(['message' => 'Debe ingresar al menos un vuelo.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Routes::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Dispatch;
use App\Entity\PostalServiceRange;
use App\Repository\OfficesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class DispatchType extends AbstractType
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
                'required' => true,
                'mapped' => false,
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
                'required' => true,
                'mapped' => false,
                'label_html' => true,
                'attr' => ['class' => 'choices-single-default-label'],
                'constraints' => [
                    new NotNull(['message' => 'Debe seleccionar una oficina de destino.']),
                ]
            ])
            ->add('postalServiceRange', EntityType::class, [
                'class' => PostalServiceRange::class,
                'choice_label' => function (PostalServiceRange $range) {
                    return $range->getPostalService()->getPostalProduct()->getName() . '-' . $range->getPostalService()->getName() . ' (' . $range->getPrincipalCharacter() . $range->getSecondCharacterFrom() . '-' . $range->getPrincipalCharacter() . $range->getSecondCharacterTo() . ')';
                },
                'placeholder' => 'Seleccione una Clase/Subclase',
                'label' => 'Clase/Subclase <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'multiple' => false,
                'expanded' => false,
                'mapped' => false,
                'attr' => ['class' => 'choices-single-default-label']
            ])
            ->add('numberDispatch', HiddenType::class, [
                'mapped' => true,
                'required' => true,
                'attr' => [
                    'class' => 'hiddenDispatch',
                ],
                'constraints' => [
                    new NotNull(['message' => 'Debe registrar el nro de despacho']),
                ],
            ])
            ->add('itinerary', HiddenType::class, [
                'mapped' => true,
                'required' => true,
                'attr' => [
                    'class' => 'hiddenDispatch',
                ],
                'constraints' => [
                    new NotNull(['message' => 'Debe registrar el itinerario']),
                ],
            ])
            ->add('routeId', HiddenType::class, [
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'class' => 'hiddenDispatch',
                ],
                'constraints' => [
                    new NotNull(['message' => 'Debe registrar el id de ruta']),
                ],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dispatch::class,
        ]);
    }
}

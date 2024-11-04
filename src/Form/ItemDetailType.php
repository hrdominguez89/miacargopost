<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\ItemDetail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class ItemDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('detailedContents', TextType::class, [
                'label' => 'Descripción del contenido  <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo descripción del contenido es obligatorio']),
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Cantidad  <span class="text-danger">*</span>',
                'label_html' => true,
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo cantidad es obligatorio']),
                ]
            ])
            ->add('netWeight', NumberType::class, [
                'label' => 'Peso neto  <span class="text-danger">*</span>',
                'label_html' => true,
                'scale' => 3, // Para definir hasta 3 decimales
                'constraints' => [
                    new NotBlank(['message' => 'El campo peso neto es obligatorio']),
                    new Range([
                        'min' => 0, // Si necesitas un valor mínimo
                        'max' => 9999999.999, // Define el rango si lo necesitas
                    ])
                ],
                'required' => true,
                'html5' => true, // Habilita el input HTML5
                'attr' => [
                    'step' => '0.001', // Permite valores de hasta 3 decimales
                ]
            ])
            ->add('value', MoneyType::class, [
                'label' => 'Valor  <span class="text-danger">*</span>',
                'label_html' => true,
                'currency' => 'USD',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'El campo valor es obligatorio']),
                ]

            ])
            ->add('hsTarifNumber', MoneyType::class, [
                'label' => 'Número tarifario del SA',
                'currency' => 'USD',
                'required' => false,
            ])
            ->add('countryOfOriginOfGoods', EntityType::class, [
                'placeholder' => 'Seleccione país de origen de las mercaderias',
                'label' => 'País de origen de las mercaderias',
                'class'  => Country::class,
                'choice_label' => 'name',
                'required' => false,
                'attr' => [
                    'class' => 'js-example-basic-single',
                    'data-choices' => null,
                    'data-choice' => 'active',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemDetail::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Flights;
use App\Repository\OfficesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class FlightsType extends AbstractType
{
    private OfficesRepository $officesRepository;

    public function __construct(OfficesRepository $officesRepository)
    {
        $this->officesRepository = $officesRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('originAirport', ChoiceType::class, [
                'choices' => $this->officesRepository->findUniqueAirportsWithCountryName('A'),
                'placeholder' => 'Seleccione un aeropuerto',
                'label' => 'Aeropuerto de origen <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'attr'=>['class'=>'choices-single-default-label']
            ])
            ->add('arrivalAirport', ChoiceType::class, [
                'choices' => $this->officesRepository->findUniqueAirportsWithCountryName('A'),
                'placeholder' => 'Seleccione un aeropuerto',
                'label' => 'Aeropuerto de destino <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'attr'=>['class'=>'choices-single-default-label']
            ])
            ->add('flightNumber', TextType::class, [
                'label' => 'Nro de vuelo <span class="text-danger">*</span>',
                'attr' => [
                    'maxlength' => 7,
                    'minlength' => 7,
                    'pattern' => '^[A-Z]{2} \d{4}$',
                    'placeholder' => 'AA 1234',
                    'title' => 'El formato es AA 1234 (dos letras en mayúsculas, un espacio, y cuatro números)',
                    'style' => 'text-transform: uppercase;',
                    'oninput' => 'this.value = this.value.toUpperCase()',
                ],
                'required' => true,
                'label_html' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo Nro de vuelo es obligatorio',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Z]{2} \d{4}$/',
                        'message' => 'El Nro de vuelo debe estar en el formato AA 1234 (dos letras en mayúsculas, un espacio, y cuatro números)',
                    ]),
                    new Length([
                        'min' => 7,
                        'max' => 7,
                        'exactMessage' => 'El Nro de vuelo debe tener exactamente {{ limit }} caracteres',
                    ]),
                ],
            ])
            ->add('flightFrequency', TextType::class, [
                'label' => 'Frecuencia de vuelo <span class="text-muted">( 1=LU, 2=MA, 3=MIE, 4=JU, 5=VI, 6=SA, 7=DO, .=NINGUNO )</span> <span class="text-danger">*</span> ',
                'attr' => [
                    'maxlength' => 7,
                    'minlength' => 7,
                    'pattern' => '^(1|\.)?(2|\.)?(3|\.)?(4|\.)?(5|\.)?(6|\.)?(7|\.)$',
                    'placeholder' => '1.3.5.7',
                    'title' => 'El formato es 1234567 ó 12....7 ó 1.3.5.7 (números o puntos en posiciones específicas)',
                ],
                'required' => true,
                'label_html' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'El campo Frecuencia de vuelo es obligatorio',
                    ]),
                    new Regex([
                        'pattern' => '/^(1|\.)(2|\.)(3|\.)(4|\.)(5|\.)(6|\.)(7|\.)$/',
                        'message' => 'La Frecuencia de vuelo debe estar en el formato 1234567 ó 12....7 ó 1.3.5.7 (números o puntos en posiciones específicas)',
                    ]),
                    new Length([
                        'min' => 7,
                        'max' => 7,
                        'exactMessage' => 'La Frecuencia de vuelo debe tener exactamente {{ limit }} caracteres',
                    ]),
                ],
            ])
            ->add('departureTime', TimeType::class, [
                'label' => 'Horario de partida <span class="text-danger">*</span>',
                'widget' => 'single_text',
                'required' => true,
                'label_html' => true,
            ])
            ->add('arrivalTime', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Horario de arribo <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
            ])
            ->add('aircraftType', TextType::class, [
                'label' => 'Tipo de aeronave <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'attr' => [
                    'maxlength' => 6,
                    'style' => 'text-transform: uppercase;',
                    'oninput' => 'this.value = this.value.toUpperCase()',
                ],

            ])
            ->add('effectiveDate', DateType::class, [
                'label' => 'Fecha de vigencia <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'widget' => 'single_text',
            ])
            ->add('discontinueDate', DateType::class, [
                'label' => 'Fecha de suspención <span class="text-danger">*</span>',
                'required' => true,
                'label_html' => true,
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Flights::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'label' => 'Rol',
                'attr' => ['class' => 'data-choices data-choices-groups data-choices-search-true'],
                'group_by' => function (?Role $entity) {

                    $name = $entity->getRoleKey() ?: '';

                    if (str_contains(strtolower($name), 'admin')) {
                        return 'ADMINISTRACION';
                    }

                    return "EMPLEADOS";

                },
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre',
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Correo',
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 100,
                    'autocomplete' => 'off',
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => $options['password_required'],
                'first_options' => [
                    'label' => 'Contraseña',
                    'attr' => [
                        'minlength' => 8,
                        'maxlength' => 15,
                    ],
                ],
                'second_options' => [
                    'label' => 'Repetir',
                    'attr' => [
                        'minlength' => 8,
                        'maxlength' => 15,
                    ],
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'password_required' => false,
        ]);
    }
}

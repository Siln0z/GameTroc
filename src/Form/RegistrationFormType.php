<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'uk-input'],
                'label' => 'Pseudo *',
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'uk-input'],
                'label' => 'Adresse Mail *',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "J'accepte la charte de GameTroc",
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter la charte du site',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les 2 mots de passe ne correspondent pas !',
                'first_options'  => [
                    'label' => 'Mot de passe *',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'uk-input'
                    ],
                ],
                'second_options' => [
                    'label' => 'Répétez le mot de passe *',
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'class' => 'uk-input'
                    ],
                ],
                'mapped' => false,
                // 'attr' => [
                //     'autocomplete' => 'new-password',
                //     'class' => 'uk-input'
                // ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ]
            ])
            ->add('avatar', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024K',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'taille max : 1Mo maximum en .jpg ou .png'
                    ])
                ]
            ]);
        // ->add('prenom', TextType::class, [
        //     'attr' => ['class' => 'uk-input'],
        //     'required' => false
        // ])
        // ->add('nom', TextType::class, [
        //     'attr' => ['class' => 'uk-input'],
        //     'required' => false
        // ])
        // ->add('adresse', TextType::class, [
        //     'attr' => ['class' => 'uk-input'],
        //     'required' => false
        // ])
        // ->add('cp', TextType::class, [
        //     'label_format' => 'Code postal',
        //     'attr' => ['class' => 'uk-input'],
        //     'required' => false
        // ])
        // ->add('ville', TextType::class, [
        //     'attr' => ['class' => 'uk-input'],
        //     'required' => false
        // ])

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

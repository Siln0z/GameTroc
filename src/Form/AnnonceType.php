<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label_format' => 'Titre *',
                'attr' => ['class' => 'uk-input']
            ])
            ->add('texte', TextareaType::class, [
                'label_format' => 'Contenu',
                'attr' => ['class' => 'mytextarea']
            ])
            ->add('photo', FileType::class, [
                'mapped' => false,
                'label' => 'Ajouter une photo à votre annonce',
                'attr' => ['class' => 'uk-flex uk-margin'],
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5000K',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'taille max : 5Mo en format .jpg ou .png'
                    ])
                ]
            ])
            ->add('valider', SubmitType::class, [
                'label_format' => 'Ajouter annonce',
                'attr' => ['class' => 'uk-button uk-button-secondary uk-margin-top']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}

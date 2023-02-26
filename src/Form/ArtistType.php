<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\EntityRepository;
use App\Repository\ArtistRepository;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $role="";
        if ( isset($options['role']) && $options['role'] != "" ) {
            $role = $options['role'];
        }

        if ( $role == "" ) {

            $builder
                ->add('nom')
                ->add('prenom')
                ->add('pseudo')
                ->add('description')
                ->add('email')
                ->add('url_yt')
                ->add('url_soundcloud')
                ->add('url_spotify')
                ->add('url_deezer')
                ->add('country')
                ->add('type')
                ->add('first_video')
                ->add('second_video')
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'attr' => [
                    'class' => 'vich-image'
                ]
                ])
            ;
        } elseif ( $role == 'admin' ) {
            $builder
                ->add('nom')
                ->add('prenom')
                ->add('pseudo')
                ->add('description')
                ->add('email')
                ->add('url_yt')
                ->add('url_soundcloud')
                ->add('url_spotify')
                ->add('url_deezer')
                ->add('country')
                ->add('type')
                ->add('first_video')
                ->add('second_video')
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'allow_delete' => false,
                    'download_uri' => false,
                    'attr' => [
                    'class' => 'vich-image'
                ]
                ])
                ->add('manager', EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'email',
                    'label' => 'Manager link',
                    'placeholder' => 'None',
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->getManagers();
                    },
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
            ;
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
            'role' => null
        ]);
    }
}

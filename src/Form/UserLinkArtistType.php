<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
//use ArtistRepository
use App\Repository\ArtistRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class UserLinkArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'pseudo',
                'label' => 'Artist link',
                'placeholder' => 'Not an artist',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['default']
        ]);
    }
}

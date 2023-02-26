<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use App\Repository\ArtistRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class UserLinkArtistManagerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        $managerArtist = $options['idArtist'];

        $builder
            ->add('id_artist', EntityType::class, [
            'class' => Artist::class,
            'choice_label' => 'pseudo',
            'label' => 'Artist link',
            'placeholder' => 'Not an artist',
            'required' => false,
            'query_builder' => function (EntityRepository $er) use ($managerArtist) {
                return $er->createQueryBuilder('a')
                    ->andWhere('a.id IN(:user)')
                    ->setParameter('user', $managerArtist)
                    ->orderBy('a.pseudo', 'ASC');
            },
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
            'idArtist' => null,
            'validation_groups' => ['default'],
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Media;
use App\Entity\MediasList;
use App\Entity\Event;
use App\Entity\Comment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      $idArtist = $options['idArtist'];
        $builder
            ->add('title')
            ->add('text_content')
            ->add('id_media', EntityType::class, [
              'class' => Media::class,
              'choice_label' => 'title',
              'placeholder' => 'No music',
              'required' => false,
              'query_builder' => function (EntityRepository $er) use ($idArtist) {
                return $er->createQueryBuilder('m')
                    ->innerJoin('m.artists', 'ma')
                    ->where('ma.id = :idArtist')
                    ->setParameter('idArtist', $idArtist)
                    ->orderBy('m.title', 'ASC');
              },

            ])
            ->add('id_mediaslist', EntityType::class, [
              'class' => MediasList::class,
              'choice_label' => 'title',
              'placeholder' => 'No album',
              'required' => false,
              'query_builder' => function (EntityRepository $er) use ($idArtist) {
                return $er->createQueryBuilder('ml')
                    ->innerJoin('ml.artists', 'mla')
                    ->where('mla.id = :idArtist')
                    ->setParameter('idArtist', $idArtist)
                    ->orderBy('ml.title', 'ASC');
              },
            ])
            ->add('id_event', EntityType::class, [
              'class' => Event::class,
              'choice_label' => 'title',
              'placeholder' => 'No event',
              'required' => false,
              'query_builder' => function (EntityRepository $er) use ($idArtist) {
                return $er->createQueryBuilder('e')
                    ->innerJoin('e.artists', 'ea')
                    ->where('ea.id = :idArtist')
                    ->setParameter('idArtist', $idArtist)
                    ->orderBy('e.title', 'ASC');
              },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'idArtist' => null,
        ]);
    }
}

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

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('text_content')
            ->add('id_media', EntityType::class, [
              'class' => Media::class,
              'choice_label' => 'title',
              'placeholder' => 'No music',
              'required' => false,
            ])
            ->add('id_mediaslist', EntityType::class, [
              'class' => MediasList::class,
              'choice_label' => 'title',
              'placeholder' => 'No album',
              'required' => false,
            ])
            ->add('id_event', EntityType::class, [
              'class' => Event::class,
              'choice_label' => 'title',
              'placeholder' => 'No event',
              'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}

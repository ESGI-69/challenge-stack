<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\MediasList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AddMediaType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      // TODO A REFACTO
      $builder
          ->add('medias', EntityType::class, [
              'class' => Media::class,
              'choice_label' => 'title',
          ])
      ;
  }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MediasList::class,
        ]);
    }
}

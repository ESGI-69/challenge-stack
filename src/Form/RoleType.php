<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          ->add('roles', ChoiceType::class, [
              'choices' => [
                  'Admin' => 'ROLE_ADMIN',
                  'Manager' => 'ROLE_MANAGER',
                  'Artist' => 'ROLE_ARTIST',
              ],
              'multiple' => true,
              'expanded' => true,
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

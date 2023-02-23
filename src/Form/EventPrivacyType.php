<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Concerthall;
use App\Entity\Artist;
use App\Repository\EventRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EventPrivacyType extends AbstractType
{

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // checkbox
            ->add('private', CheckboxType::class, [
                'label' => 'Is private?',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}

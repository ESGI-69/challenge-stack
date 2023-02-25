<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Concerthall;
use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{

    public function __construct(ArtistRepository $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // radio button
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'choices' => [
                    'Concert' => 'concert',
                    'Practice' => 'practice',
                ],
                'data' => 'concert',
            ])
            ->add('id_concerthall', EntityType::class, [
                'class' => Concerthall::class,
                'choice_label' => 'name',
                'label' => 'Concert hall',
            ])
            ->add('title', null, [
                'label' => 'Title',
                'required' => true,
            ])
            ->add('start_date', null, [
                'label' => 'Start date',
                'required' => false,
            ])
            ->add('end_date', null, [
                'label' => 'End date',
                'required' => false,
            ])
            ->add('ticketing_link', null, [
                'label' => 'Ticketing link',
                'required' => false,
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'attr' => [
                  'class' => 'vich-image'
                ],
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image (JPEG, PNG, GIF).',
                    ]),
                ],
            ])
            // Only the artist that are managed by the user can be selected
            // ->add('description')
            // ->add('date')
            // ->add('ticketing_link')
            // ->add('artists')
            // ->add('insterested_users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}

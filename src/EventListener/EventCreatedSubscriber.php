<?php

namespace App\EventListener;

use App\Entity\Event;
use App\Entity\Artist;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class EventCreatedSubscriber implements EventSubscriber
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postUpdate,
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        // only act on "Event" entities
        if (!$entity instanceof Event) {
            return;
        }

        // Check if the Event has been set to private = false and send emails to all followers
        if ($entity->isPrivate() == false) {
            $artist = $entity->getArtistAuthor();
            $followers = $artist->getFollowed()->toArray();

            $tab_already_sent = [];

            foreach ($followers as $follower) {

                $tab_already_sent[] = $follower->getId();

                // send email to each follower
                $email = (new TemplatedEmail())
                    ->from(new Address('noreply@'.$_ENV['DOMAIN_NAME'], 'BeatHub'))
                    ->to($follower->getEmail())
                    ->subject('New Event from your favorite artist !')
                    ->htmlTemplate('Front/email/event.html.twig')
                    ->context([
                        'event' => $entity,
                    ]);
                $this->mailer->send($email);
            }

            $concertHall = $entity->getIdConcerthall(); 
            $users = $concertHall->getUsers();

            if (count($users)>0) {
                foreach ($users as $user) {
                    if ( !in_array($user->getId(), $tab_already_sent) ) {
                        // send email to each follower
                        $email = (new TemplatedEmail())
                            ->from(new Address('noreply@'.$_ENV['DOMAIN_NAME'], 'BeatHub'))
                            ->to($user->getEmail())
                            ->subject('New Event in your favorite club !')
                            ->htmlTemplate('Front/email/club_event.html.twig')
                            ->context([
                                'event' => $entity,
                                'club' => $concertHall,
                            ])
                        ;
                        $this->mailer->send($email);
                    }
                }
            }
        }
    }
}

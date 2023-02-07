<?php

namespace App\EventListener;

use App\Entity\Post;
use App\Entity\Artist;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class PostCreatedSubscriber implements EventSubscriber
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
        // only act on "Post" entities
        if (!$entity instanceof Post) {
            return;
        }

        // Check if the post has been validated and send emails to all followers
        if ($entity->getValidatedAt() != null) {
            $artist = $entity->getIdArtist();
            $followers = $artist->getFollowed()->toArray();
            foreach ($followers as $follower) {
                // send email to each follower
                $email = (new TemplatedEmail())
                    ->from(new Address('noreply@'.$_ENV['DOMAIN_NAME'], 'BeatHub'))
                    ->to($follower->getEmail())
                    ->subject('New post from your favorite artist !')
                    ->htmlTemplate('Front/email/post.html.twig')
                    ->context([
                        'post' => $entity,
                    ]);
                $this->mailer->send($email);
            }
        }
    }
}

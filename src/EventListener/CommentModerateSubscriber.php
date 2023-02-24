<?php

namespace App\EventListener;

use App\Entity\Comment;
use App\Entity\Artist;
use Symfony\Component\Mailer\MailerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class CommentModerateSubscriber implements EventSubscriber
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
            Events::postRemove
        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        // only act on "Post" entities
        if (!$entity instanceof Comment) {
            return;
        }
        if ($entity->getValidatedAt() != null) {
            $mail = $entity->getIdUser()->getEmail();
            $email = (new TemplatedEmail())
                ->from(new Address('noreply@'.$_ENV['DOMAIN_NAME'], 'BeatHub'))
                ->to($mail)
                ->subject('Your comment as been approved !')
                ->htmlTemplate('Front/email/commentApproved.html.twig')
                ->context([
                    'comment' => $entity,
                ]);
            $this->mailer->send($email);
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        // only act on "Post" entities
        if (!$entity instanceof Comment) {
            return;
        }
        if ($entity->getValidatedAt() == null) {
            $mail = $entity->getIdUser()->getEmail();
            $email = (new TemplatedEmail())
                ->from(new Address('noreply@'.$_ENV['DOMAIN_NAME'], 'BeatHub'))
                ->to($mail)
                ->subject('Your comment as been rejected !')
                ->htmlTemplate('Front/email/commentRejected.html.twig')
                ->context([
                    'comment' => $entity,
                ]);
            $this->mailer->send($email);
        }
    }
    
}

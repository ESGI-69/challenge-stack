<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\MediasList;
use App\Entity\Media;
use App\Entity\ConcertHall;
use App\Entity\Event;
use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comment;
use Monolog\DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /* BLOC POUR ARTISTES */ 
        $artist = new Artist();

        $artist->setNom("Bauweraerts");
        $artist->setPrenom("Koen");
        $artist->setPseudo("Coone");
        $artist->setDescription("BOOM BOOM in the ears.");
        $artist->setEmail("jon@swag-mgmt.com");
        $artist->setUrlYt("https://www.youtube.com/channel/UC7alhTRNkawfATqvctiSZjA");
        $artist->setUrlSoundcloud("https://soundcloud.com/COONE");
        $artist->setUrlSpotify("https://open.spotify.com/artist/1Wt63OMKtv6v2ivHuQLm2C");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/199130");
        $artist->setCountry("Belgium");
        $artist->setType("solo");
        
        $manager->persist($artist);

        /* BLOC POUR ALBUM */
        $mediaslist = new MediasList();

        $mediaslist->setTitle("Legends Of The Elite");
        $mediaslist->setReleaseDate(new DateTimeImmutable('now'));
        $mediaslist->setDescription("THIS IS HOW WE BOOMBOOM.");
        $mediaslist->setPathCover("");
        $mediaslist->setType("album");

        $manager->persist($mediaslist);

        /* BLOC POUR MEDIAS */
        $media = new Media();

        $media->setTitle("Prelude");
        $media->setDescription("BOOM BOOM 1");
        $media->setPosition(1);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("Here To Stay");
        $media->setDescription("BOOM BOOM 2");
        $media->setPosition(2);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("Out Of The Shadows");
        $media->setDescription("BOOM BOOM 3");
        $media->setPosition(3);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("By The Sword");
        $media->setDescription("BOOM BOOM 4");
        $media->setPosition(4);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("Falling Angels");
        $media->setDescription("BOOM BOOM 5");
        $media->setPosition(5);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist);

        $manager->persist($media);

        /* BLOC CONCERT HALL */
        $concerthall = new ConcertHall();

        $concerthall->setName("Terminal 7");
        $concerthall->setAddress("1 Pl. de la Prte de Versailles");
        $concerthall->setCity("Paris");
        $concerthall->setCapacity(500);
        $concerthall->setSiteLink("https://paris-society-events.com/salles/terminal7/?utm_source=Yext&utm_medium=GMB&y_source=1_MjU3NzExODktNzE1LWxvY2F0aW9uLndlYnNpdGU%3D");
        
        $manager->persist($concerthall);

        /* BLOC EVENTS */
        $event = new Event();

        $event->setTitle("HARD BOOM LIVE");
        $event->setStartDate(new DateTimeImmutable('now'));
        $event->setEndDate(new DateTimeImmutable('now'));
        $event->setTicketingLink("https://shotgun.live/fr");
        $event->setIdConcertHall($concerthall);
        $event->addArtist($artist);
        $event->setPicturePath("");
        $event->setDuration(3);

        $manager->persist($event);

        /* BLOC USER */
        $user_admin = new User();

        $user_admin->setEmail("admin@mail.com");
        $user_admin->setPlainPassword("password");
        $user_admin->setProfilePicturePath("");
        $user_admin->setActive(true);
        $user_admin->setRoles(["ROLE_ADMIN"]);
        $user_admin->setActivationToken("fdp");
        $user_admin->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_admin);

        $user_manager = new User();

        $user_manager->setEmail("manager@mail.com");
        $user_manager->setPlainPassword("password");
        $user_manager->setProfilePicturePath("");
        $user_manager->setActive(true);
        $user_manager->setRoles(["ROLE_MANAGER"]);
        $user_manager->setActivationToken("fdp");
        $user_manager->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_manager);

        $user_artist = new User();

        $user_artist->setEmail("artist@mail.com");
        $user_artist->setPlainPassword("password");
        $user_artist->setProfilePicturePath("");
        $user_artist->setActive(true);
        $user_artist->setRoles(["ROLE_ARTIST"]);
        $user_artist->setIdArtist($artist);
        $user_artist->setActivationToken("fdp");
        $user_artist->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_artist);

        $user_default = new User();

        $user_default->setEmail("user@mail.com");
        $user_default->setPlainPassword("password");
        $user_default->setProfilePicturePath("");
        $user_default->setActive(true);
        $user_default->setActivationToken("fdp");
        $user_default->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_default);

        /* BLOC POUR POSTS */
        $post = new Post();

        $post->setTitle("RATIO");
        $post->setTextContent("ICI ON RATIO OU KOA LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL.");
        $post->setCreatedAt(new DateTimeImmutable('now'));
        $post->setUpdatedAt(new DateTimeImmutable('now'));
        $post->setValidated(true);
        $post->setIdUser($user_artist);

        $manager->persist($post);

        $post = new Post();

        $post->setTitle("CONCERT");
        $post->setTextContent("Regarde mon beau concert ololooloololo!");
        $post->setCreatedAt(new DateTimeImmutable('now'));
        $post->setUpdatedAt(new DateTimeImmutable('now'));
        $post->setValidated(true);
        $post->setIdEvent($event);
        $post->setIdUser($user_artist);

        $manager->persist($post);

        /* BLOC POUR COMMENT */
        $comment = new Comment();

        $comment->setText("OH TU ME RATIO PAS CONNARD DE NAZI");
        $comment->setValidated(true);
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post);

        $manager->persist($comment);

        $comment = new Comment();

        $comment->setText("Je suis un gros raciste");
        $comment->setValidated(false);
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post);

        $manager->persist($comment);

        $manager->flush();
    }
}

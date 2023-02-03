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
        $artist1 = new Artist();
        $artist1->setNom("Bauweraerts");
        $artist1->setPrenom("Koen");
        $artist1->setPseudo("Coone");
        $artist1->setDescription("BOOM BOOM in the ears.");
        $artist1->setEmail("jon@swag-mgmt.com");
        $artist1->setUrlYt("https://www.youtube.com/channel/UC7alhTRNkawfATqvctiSZjA");
        $artist1->setUrlSoundcloud("https://soundcloud.com/COONE");
        $artist1->setUrlSpotify("https://open.spotify.com/artist/1Wt63OMKtv6v2ivHuQLm2C");
        $artist1->setUrlDeezer("https://www.deezer.com/fr/artist/199130");
        $artist1->setCountry("Belgium");
        $artist1->setType("solo");
        $manager->persist($artist1);
        
        $artist2 = new Artist();
        $artist2->setNom("Camel");
        $artist2->setPrenom("Camel");
        $artist2->setPseudo("Camel");
        $artist2->setDescription("Rock Prog band from england.");
        $artist2->setEmail("support@cameeeel.com");
        $artist2->setUrlYt("https://www.youtube.com/@CamelBandOfficial");
        $artist2->setUrlSoundcloud("https://soundcloud.com/camelbandofficial");
        $artist2->setUrlDeezer("https://www.deezer.com/fr/artist/12826");
        $artist2->setCountry("United Kingdom");
        $artist2->setType("group");
        $manager->persist($artist2);

        $artist = new Artist();
        $artist->setNom("Pink Floyd");
        $artist->setPrenom("Pink Floyd");
        $artist->setPseudo("Pink Floyd");
        $artist->setDescription("Famous rock Prog band from england.");
        $artist->setEmail("support@pinkfloyd.com");
        $artist->setUrlYt("https://www.youtube.com/@PinkFloyd");
        $artist->setUrlSoundcloud("https://soundcloud.com/pinkfloyd");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/860");
        $artist->setCountry("United Kingdom");
        $artist->setType("group");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Chromatics");
        $artist->setPrenom("Chromatics");
        $artist->setPseudo("Chromatics");
        $artist->setDescription("Chromatics is an American synthpop band from Portland, Oregon, formed in 2001.");
        $artist->setEmail("support@itaaliansdoitbetter.com");
        $artist->setUrlYt("https://www.youtube.com/@Chromatics");
        $artist->setUrlSoundcloud("https://soundcloud.com/chromatics");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/17269");
        $artist->setCountry("United States");
        $artist->setType("group");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("");
        $artist->setPrenom("");
        $artist->setPseudo("Tame Impala");
        $artist->setDescription("Tame Impala is an Australian psychedelic rock band formed in Perth in 2007.");
        $artist->setEmail("support@tameimpalaaa.com");
        $artist->setUrlYt("https://www.youtube.com/@TameImpala");
        $artist->setUrlSoundcloud("https://soundcloud.com/tameimpala");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/134790");
        $artist->setCountry("Australia");
        $artist->setType("group");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Tozzi");
        $artist->setPrenom("Luigi");
        $artist->setPseudo("Luigi Tozzi");
        $artist->setDescription("Luigi Tozzi is an Italian singer-songwriter and musician.");
        $artist->setEmail("luigi@tozzzzzi.com");
        $artist->setUrlYt("https://www.youtube.com/@LuigiTozzi");
        $artist->setUrlSoundcloud("https://soundcloud.com/luigitozzi");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/8169420");
        $artist->setCountry("Italy");
        $artist->setType("solo");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Zimmer");
        $artist->setPrenom("Hans");
        $artist->setPseudo("Hans Zimmer");
        $artist->setDescription("Hans Florian Zimmer is a German composer and record producer.");
        $artist->setEmail("supoort@hansszimmer.com");
        $artist->setUrlYt("https://www.youtube.com/@HansZimmer");
        $artist->setUrlSoundcloud("https://soundcloud.com/hanszimmer");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/1935");
        $artist->setCountry("Germany");
        $artist->setType("solo");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("");
        $artist->setPrenom("");
        $artist->setPseudo("Stand High Patrol");
        $artist->setDescription("Stand High Patrol is a French dub band from Brest.");
        $artist->setEmail("supoort@standhighpatroldd.com");
        $artist->setUrlYt("https://www.youtube.com/@StandHighPatrol");
        $artist->setUrlSoundcloud("https://soundcloud.com/standhighpatrol");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/1562640");
        $artist->setCountry("France");
        $artist->setType("group");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Kendrick Lamar");
        $artist->setPrenom("Kendrick Lamar");
        $artist->setPseudo("Kendrick Lamar");
        $artist->setDescription("Kendrick Lamar Duckworth is an American rapper, songwriter, and record producer.");
        $artist->setEmail("supoort@kendricklaaamar.com");
        $artist->setUrlYt("https://www.youtube.com/@KendrickLamar");
        $artist->setUrlSoundcloud("https://soundcloud.com/kendricklamar");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("United States");
        $artist->setType("solo");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Kanye West");
        $artist->setPrenom("Kanye West");
        $artist->setPseudo("Kanye West");
        $artist->setDescription("Kanye Omari West is an American rapper, singer, songwriter, record producer, entrepreneur, and fashion designer.");
        $artist->setEmail("supoort@kannyee.com");
        $artist->setUrlYt("https://www.youtube.com/@KanyeWest");
        $artist->setUrlSoundcloud("https://soundcloud.com/kanyewest");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("United States");
        $artist->setType("solo");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Badalamenti");
        $artist->setPrenom("Angelo");
        $artist->setPseudo("Angelo Badalamenti");
        $artist->setDescription("Angelo Badalamenti is an American composer, conductor, and pianist.");
        $artist->setEmail("supoort@angelooobadalamenti.com");
        $artist->setUrlYt("https://www.youtube.com/@AngeloBadalamenti");
        $artist->setUrlSoundcloud("https://soundcloud.com/angelobadalamenti");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("United States");
        $artist->setType("solo");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("M83");
        $artist->setPrenom("M83");
        $artist->setPseudo("M83");
        $artist->setDescription("M83 is a French electronic music band formed in Paris in 2001.");
        $artist->setEmail("supoort@mmmmmm8888883333.com");
        $artist->setUrlYt("https://www.youtube.com/@M83");
        $artist->setUrlSoundcloud("https://soundcloud.com/m83");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("France");
        $artist->setType("group");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Seba");
        $artist->setPrenom("Jun");
        $artist->setPseudo("Nujabes");
        $artist->setDescription("Jun Seba, better known by his stage name Nujabes, was a Japanese record producer, rapper, and DJ.");
        $artist->setEmail("supporttt@nujabeeeees.com");
        $artist->setUrlYt("https://www.youtube.com/@Nujabes");
        $artist->setUrlSoundcloud("https://soundcloud.com/nujabes");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("Japan");
        $artist->setType("solo");
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Jarre");
        $artist->setPrenom("Jean-Michel");
        $artist->setPseudo("Jean-Michel Jarre");
        $artist->setDescription("Jean-Michel André Jarre is a French composer, performer, and record producer.");
        $artist->setEmail("jm.jarre@mail.com");
        $artist->setUrlYt("https://www.youtube.com/@JeanMichelJarre");
        $artist->setUrlSoundcloud("https://soundcloud.com/jeanmicheljarre");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setUrlSpotify("https://open.spotify.com/artist/0X2BH1fck6amBIoJhDVmmJ");
        $artist->setCountry("France");
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
        $media->addArtist($artist1);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("Here To Stay");
        $media->setDescription("BOOM BOOM 2");
        $media->setPosition(2);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist1);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("Out Of The Shadows");
        $media->setDescription("BOOM BOOM 3");
        $media->setPosition(3);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist1);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("By The Sword");
        $media->setDescription("BOOM BOOM 4");
        $media->setPosition(4);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist1);

        $manager->persist($media);

        $media = new Media();

        $media->setTitle("Falling Angels");
        $media->setDescription("BOOM BOOM 5");
        $media->setPosition(5);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist);
        $media->addArtist($artist1);

        $manager->persist($media);

        /* BLOC CONCERT HALL */
        $concerthall = new ConcertHall();

        $concerthall->setName("Terminal 7");
        $concerthall->setAddress("1 Pl. de la Prte de Versailles");
        $concerthall->setCity("Paris");
        $concerthall->setDescription("Située à Paris, la salle de concert Terminal 7 est un lieu de concerts et de spectacles de 500 places.");
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
        $event->addArtist($artist1);
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
        $user_admin->addArtistsFollowed($artist1);
        $user_admin->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_admin);

        $user_manager = new User();

        $user_manager->setEmail("manager@mail.com");
        $user_manager->setPlainPassword("password");
        $user_manager->setProfilePicturePath("");
        $user_manager->setActive(true);
        $user_manager->setRoles(["ROLE_MANAGER"]);
        $user_manager->setIdArtist($artist1);
        $user_manager->setActivationToken("fdp");
        $user_manager->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_manager);

        $user_manager = new User();

        $user_manager->setEmail("manager2@mail.com");
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
        $user_artist->setIdArtist($artist1);
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
        $post->setValidatedAt(new DateTimeImmutable('now'));
        $post->setIdUser($user_artist);
        $post->setIdArtist($artist1);

        $manager->persist($post);

        $post = new Post();

        $post->setTitle("CONCERT");
        $post->setTextContent("Regarde mon beau concert ololooloololo!");
        $post->setCreatedAt(new DateTimeImmutable('now'));
        $post->setUpdatedAt(new DateTimeImmutable('now'));
        $post->setValidatedAt(new DateTimeImmutable('now'));
        $post->setIdEvent($event);
        $post->setIdUser($user_artist);
        $post->setIdArtist($artist2);

        $manager->persist($post);

        $post = new Post();

        $post->setTitle("pas validé");
        $post->setTextContent("AYAYAYAYAYAYAYAYAYAY CACA");
        $post->setCreatedAt(new DateTimeImmutable('now'));
        $post->setUpdatedAt(new DateTimeImmutable('now'));
        $post->setValidatedAt(null);
        $post->setIdEvent($event);
        $post->setIdUser($user_artist);
        $post->setIdArtist($artist1);

        $manager->persist($post);

        /* BLOC POUR COMMENT */
        $comment = new Comment();

        $comment->setText("OH TU ME RATIO PAS CONNARD DE NAZI");
        $comment->setValidatedAt(new DateTimeImmutable('now'));
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post);

        $manager->persist($comment);

        $comment = new Comment();

        $comment->setText("Je suis un gros raciste");
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post);

        $manager->persist($comment);

        $manager->flush();
    }
}

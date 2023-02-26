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
use App\Entity\EventInvite;
use Monolog\DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

      $user_manager = new User();

      $user_manager->setEmail("manager@mail.com");
      $user_manager->setPlainPassword("password");
      $user_manager->setUsername("Lividly0518");
      $user_manager->setProfilePicturePath("");
      $user_manager->setActive(true);
      $user_manager->setRoles(["ROLE_MANAGER"]);
      // $user_manager->setIdArtist($artist1);
      $user_manager->setActivationToken("fdp");
      $user_manager->setActivationTokenExpiration(new DateTimeImmutable('now'));

      $manager->persist($user_manager);

      $user_manager2 = new User();

      $user_manager2->setEmail("manager2@mail.com");
      $user_manager2->setPlainPassword("password");
      $user_manager2->setUsername("Shredder2664");
      $user_manager2->setProfilePicturePath("");
      $user_manager2->setActive(true);
      $user_manager2->setRoles(["ROLE_MANAGER"]);
      // $user_manager2->setIdArtist($artist2);
      $user_manager2->setActivationToken("fdp");
      $user_manager2->setActivationTokenExpiration(new DateTimeImmutable('now'));

      $manager->persist($user_manager2);

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
        $artist1->setManager($user_manager);
        $manager->persist($artist1);
        
        $artist2 = new Artist();
        $artist2->setNom("Auberger");
        $artist2->setPrenom("Jacques");
        $artist2->setPseudo("Jacques");
        $artist2->setDescription("French electronic, transversal techno and bruitist composer.");
        $artist2->setEmail("jacques@mail.com");
        $artist2->setUrlYt("https://www.youtube.com/channel/UC05Om8nHItHP3xi4N8g1eMQ");
        $artist2->setUrlSoundcloud("https://soundcloud.com/jacquestransversal");
        $artist2->setUrlSpotify("https://open.spotify.com/artist/55i4AnS7E58y41UwE0vvQh");
        $artist2->setUrlDeezer("https://www.deezer.com/fr/artist/260397");
        $artist2->setCountry("France");
        $artist2->setType("solo");
        $artist2->setManager($user_manager2);
        $manager->persist($artist2);

        $artist3 = new Artist();
        $artist3->setNom("");
        $artist3->setPrenom("");
        $artist3->setPseudo("Camel");
        $artist3->setDescription("Rock Prog band from england.");
        $artist3->setEmail("support@cameeeel.com");
        $artist3->setUrlYt("https://www.youtube.com/@CamelBandOfficial");
        $artist3->setUrlSoundcloud("https://soundcloud.com/camelbandofficial");
        $artist3->setUrlDeezer("https://www.deezer.com/fr/artist/12826");
        $artist3->setCountry("United Kingdom");
        $artist3->setType("group");
        $artist3->setManager($user_manager);
        $manager->persist($artist3);

        $artist = new Artist();
        $artist->setNom("");
        $artist->setPrenom("");
        $artist->setPseudo("Pink Floyd");
        $artist->setDescription("Famous rock Prog band from england.");
        $artist->setEmail("support@pinkfloyd.com");
        $artist->setUrlYt("https://www.youtube.com/@PinkFloyd");
        $artist->setUrlSoundcloud("https://soundcloud.com/pinkfloyd");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/860");
        $artist->setCountry("United Kingdom");
        $artist->setType("group");
        $artist->setManager($user_manager);
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("");
        $artist->setPrenom("");
        $artist->setPseudo("Chromatics");
        $artist->setDescription("Chromatics is an American synthpop band from Portland, Oregon, formed in 2001.");
        $artist->setEmail("support@itaaliansdoitbetter.com");
        $artist->setUrlYt("https://www.youtube.com/@Chromatics");
        $artist->setUrlSoundcloud("https://soundcloud.com/chromatics");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/17269");
        $artist->setCountry("United States");
        $artist->setType("group");
        $artist->setManager($user_manager);
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
        $artist->setManager($user_manager);
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
        $artist->setManager($user_manager);
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
        $artist->setManager($user_manager);
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
        $artist->setManager($user_manager2);
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("Lamar");
        $artist->setPrenom("Kendrick");
        $artist->setPseudo("Kendrick Lamar");
        $artist->setDescription("Kendrick Lamar Duckworth is an American rapper, songwriter, and record producer.");
        $artist->setEmail("supoort@kendricklaaamar.com");
        $artist->setUrlYt("https://www.youtube.com/@KendrickLamar");
        $artist->setUrlSoundcloud("https://soundcloud.com/kendricklamar");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("United States");
        $artist->setType("solo");
        $artist->setManager($user_manager2);
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("West");
        $artist->setPrenom("Kanye");
        $artist->setPseudo("Kanye West");
        $artist->setDescription("Kanye Omari West is an American rapper, singer, songwriter, record producer, entrepreneur, and fashion designer.");
        $artist->setEmail("supoort@kannyee.com");
        $artist->setUrlYt("https://www.youtube.com/@KanyeWest");
        $artist->setUrlSoundcloud("https://soundcloud.com/kanyewest");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("United States");
        $artist->setType("solo");
        $artist->setManager($user_manager2);
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
        $artist->setManager($user_manager2);
        $manager->persist($artist);

        $artist = new Artist();
        $artist->setNom("");
        $artist->setPrenom("");
        $artist->setPseudo("M83");
        $artist->setDescription("M83 is a French electronic music band formed in Paris in 2001.");
        $artist->setEmail("supoort@mmmmmm8888883333.com");
        $artist->setUrlYt("https://www.youtube.com/@M83");
        $artist->setUrlSoundcloud("https://soundcloud.com/m83");
        $artist->setUrlDeezer("https://www.deezer.com/fr/artist/116");
        $artist->setCountry("France");
        $artist->setType("group");
        $artist->setManager($user_manager2);
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
        $artist->setManager($user_manager2);
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
        $artist->setManager($user_manager2);
        $manager->persist($artist);
        
        /* BLOC POUR ALBUM */
        $mediaslist = new MediasList();

        $mediaslist->setTitle("Legends Of The Elite");
        $mediaslist->setReleaseDate(new DateTimeImmutable('now'));
        $mediaslist->setDescription("THIS IS HOW WE BOOMBOOM.");
        $mediaslist->setPathCover("");
        $mediaslist->setType("album");
        $mediaslist->addArtist($artist1);

        $manager->persist($mediaslist);

        $mediaslist2 = new MediasList();

        $mediaslist2->setTitle("Album Test 2");
        $mediaslist2->setReleaseDate(new DateTimeImmutable('now'));
        $mediaslist2->setDescription("TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST ");
        $mediaslist2->setPathCover("");
        $mediaslist2->setType("album");
        $mediaslist2->addArtist($artist2);

        $manager->persist($mediaslist2);

        $mediaslist3 = new MediasList();

        $mediaslist3->setTitle("LIMPORTANCEDUVIDE");
        $mediaslist3->setReleaseDate(new DateTimeImmutable('2022-12-12 09:00:00'));
        $mediaslist3->setDescription("Nouvel album pop/bruitisme de Jacques, 2022, en tournée avec son nouveau groupe");
        $mediaslist3->setPathCover("");
        $mediaslist3->setType("album");
        $mediaslist3->addArtist($artist2);

        $manager->persist($mediaslist3);

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

        $media = new Media();

        $media->setTitle("Media Test");
        $media->setDescription("BOOM BOOM 5");
        $media->setPosition(5);
        $media->setDuree(222);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist2);
        $media->addArtist($artist1);

        $manager->persist($media);

        $media1 = new Media();

        $media1->setTitle("Porte s'ouvre");
        $media1->setDescription("Porte s'ouvre musique");
        $media1->setPosition(1);
        $media1->setDuree(101);
        $media1->setFilePath("");
        $media1->addMediaslist($mediaslist3);
        $media1->addArtist($artist2);
        $manager->persist($media1);

        $media = new Media();
        $media->setTitle("Arrivera");
        $media->setDescription("Arrivera musique");
        $media->setPosition(2);
        $media->setDuree(183);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Ca se voit");
        $media->setDescription("Ca se voit musique");
        $media->setPosition(3);
        $media->setDuree(153);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Avec les mots");
        $media->setDescription("Avec les mots musique");
        $media->setPosition(4);
        $media->setDuree(219);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("La vie de tout les jours");
        $media->setDescription("La vie de tout les jours musique");
        $media->setPosition(5);
        $media->setDuree(172);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Qu'en avez-vous fait?");
        $media->setDescription("Qu'en avez-vous fait? musique");
        $media->setPosition(6);
        $media->setDuree(184);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Pourquoi c'est comme ça?");
        $media->setDescription("Pourquoi c'est comme ça? musique");
        $media->setPosition(7);
        $media->setDuree(140);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Je ne te vois plus");
        $media->setDescription("Je ne te vois plus musique");
        $media->setPosition(8);
        $media->setDuree(216);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Kick ce soit");
        $media->setDescription("Kick ce soit musique");
        $media->setPosition(9);
        $media->setDuree(193);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Partout");
        $media->setDescription("Partout musique");
        $media->setPosition(10);
        $media->setDuree(206);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Qu'est-ce-que");
        $media->setDescription("Qu'est-ce-que musique");
        $media->setPosition(11);
        $media->setDuree(58);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("C'est");
        $media->setDescription("C'est musique");
        $media->setPosition(12);
        $media->setDuree(248);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
        $manager->persist($media);

        $media = new Media();
        $media->setTitle("Rien.");
        $media->setDescription("Rien. musique");
        $media->setPosition(13);
        $media->setDuree(190);
        $media->setFilePath("");
        $media->addMediaslist($mediaslist3);
        $media->addArtist($artist2);
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
        $event->setArtistAuthor($artist1);
        $event->setPicturePath("");
        $event->setPrivate(false);
        $event->setType("concert");
        $event->setDescription("HARD BOOM LIVE est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.");

        $manager->persist($event);

        $event2 = new Event();

        $event2->setTitle("Concert Album Release");
        $event2->setStartDate(new DateTimeImmutable('now'));
        $event2->setEndDate(new DateTimeImmutable('now'));
        $event2->setTicketingLink("https://shotgun.live/fr");
        $event2->setIdConcertHall($concerthall);
        $event2->addArtist($artist2);
        $event2->setArtistAuthor($artist2);
        $event2->setPicturePath("");
        $event2->setPrivate(false);
        $event2->setType("concert");
        $event2->setDescription("Nouvelle tournée pour Jacques et son groupe pour la sortie de leur nouvel album LIMPORTANCEDUVIDE.");

        $manager->persist($event2);

        $practice = new Event();

        $practice->setTitle("REPETITION HARD BOOM LIVE");
        $practice->setStartDate(new DateTimeImmutable('now'));
        $practice->setEndDate(new DateTimeImmutable('now'));
        $practice->setTicketingLink("https://shotgun.live/fr");
        $practice->setIdConcertHall($concerthall);
        $practice->addArtist($artist1);
        $practice->setArtistAuthor($artist1);
        $practice->setPicturePath("");
        $practice->setPrivate(true);
        $practice->setType("practice");
        $practice->setDescription("REPETITION HARD BOOM LIVE est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.");

        $manager->persist($practice);

        /* BLOC USER */
        $user_admin = new User();

        $user_admin->setEmail("admin@mail.com");
        $user_admin->setPlainPassword("password");
        $user_admin->setUsername("Huskiness2212");
        $user_admin->setProfilePicturePath("");
        $user_admin->setActive(true);
        $user_admin->setRoles(["ROLE_ADMIN"]);
        $user_admin->setActivationToken("fdp");
        $user_admin->addArtistsFollowed($artist1);
        $user_admin->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_admin);

        $user_moderator = new User();

        $user_moderator->setEmail("moderator@mail.com");
        $user_moderator->setPlainPassword("password");
        $user_moderator->setUsername("Decal7390");
        $user_moderator->setProfilePicturePath("");
        $user_moderator->setActive(true);
        $user_moderator->setRoles(["ROLE_MODERATOR"]);
        $user_moderator->setActivationToken("fdp");
        $user_moderator->addArtistsFollowed($artist1);
        $user_moderator->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_moderator);

        $user_artist2 = new User();

        $user_artist2->setEmail("artist2@mail.com");
        $user_artist2->setPlainPassword("password");
        $user_artist2->setUsername("Possibly3905");
        $user_artist2->setProfilePicturePath("");
        $user_artist2->setActive(true);
        $user_artist2->setRoles(["ROLE_ARTIST"]);
        $user_artist2->setIdArtist($artist2);
        $user_artist2->setActivationToken("fdp");
        $user_artist2->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_artist2);

        $user_artist = new User();

        $user_artist->setEmail("artist@mail.com");
        $user_artist->setPlainPassword("password");
        $user_artist->setUsername("Excavator0465");
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
        $user_default->setUsername("Unfocused9216");
        $user_default->setProfilePicturePath("");
        $user_default->setActive(true);
        $user_default->setActivationToken("fdp");
        $user_default->addArtistsFollowed($artist1);
        $user_default->setActivationTokenExpiration(new DateTimeImmutable('now'));

        $manager->persist($user_default);

        /* BLOC POUR EVENT INVITES */

        $eventInvite = new EventInvite();

        $eventInvite->setIdEvent($practice);
        $eventInvite->setIdArtist($artist2);
        $eventInvite->setCreatedAt(new DateTimeImmutable('now'));
        $eventInvite->setArtistAuthor($artist1);
        $eventInvite->setStatus('pending');

        $manager->persist($eventInvite);

        /* BLOC POUR POSTS */
        $post0 = new Post();

        $post0->setTitle("Nouveau concert de Jacques qui arrive bientôt");
        $post0->setTextContent("
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris aliquet libero iaculis, malesuada elit sit amet, scelerisque lacus. Nulla pellentesque, eros ac consectetur imperdiet, ligula nulla varius enim, at blandit sapien metus at dui. Donec et diam at dolor laoreet consequat. Cras pellentesque fringilla sapien, id bibendum odio malesuada vitae. Nulla rutrum leo tortor, a dictum mi volutpat at. Morbi convallis turpis velit, sed blandit mauris ullamcorper non. Praesent sed lorem consequat, eleifend quam nec, facilisis augue. Ut sollicitudin fringilla eleifend. In porttitor odio sed luctus aliquet. Vivamus semper sit amet est finibus ultrices. Phasellus nulla augue, viverra at lacus quis, elementum blandit ipsum. Nullam aliquet pretium nunc, ac vulputate nulla luctus sit amet. Pellentesque id quam id metus rhoncus bibendum. Vestibulum eu nibh vel sapien mollis porta. Donec vitae interdum odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla facilisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nam nibh lorem, faucibus tempus lacinia eget, mollis ut turpis. Mauris elementum tellus ut tellus elementum, vitae aliquet massa posuere. Suspendisse lacus mi, facilisis at quam at, tincidunt facilisis mauris. Praesent id tempus magna. Suspendisse sed volutpat ipsum. Nam vel euismod nunc. Suspendisse sagittis nibh vitae luctus efficitur. Donec sit amet cursus orci. In tristique nisl et dolor volutpat lobortis. Aenean non placerat velit. Nam porttitor est a maximus bibendum. Suspendisse ut efficitur lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras malesuada euismod maximus. Phasellus fermentum tempor velit, ut vehicula dolor feugiat et. Suspendisse quis hendrerit sapien, a malesuada mi. Praesent in molestie leo, non pretium erat. Integer quis tempor arcu. Ut sollicitudin molestie purus sed molestie. Maecenas quis lacus sed risus ullamcorper porttitor. Nullam ullamcorper a lectus semper ultricies. Nunc faucibus tortor id augue tincidunt, ac hendrerit est volutpat. Etiam hendrerit lectus augue, a venenatis nunc vestibulum elementum. Nunc laoreet facilisis massa. Pellentesque quis dui mollis, elementum justo at, efficitur orci. In rhoncus mollis magna, vitae facilisis risus rhoncus vel. Mauris faucibus molestie ipsum, sed euismod odio egestas a. Ut non orci volutpat, egestas justo bibendum, tristique odio. Phasellus quis massa tristique, accumsan nisl sit amet, ullamcorper urna. Donec in feugiat erat, nec auctor ex. Nunc sit amet fringilla nunc, non dapibus lacus. Curabitur libero arcu, varius vel hendrerit sed, gravida non ante. Morbi id odio augue. Donec varius eros imperdiet, ultrices metus et, suscipit enim. Nam sapien dui, fermentum a massa a, aliquam semper tortor. Cras eu posuere massa. Vestibulum rutrum auctor purus, eu accumsan nunc sagittis ut. Morbi nisi dolor, efficitur ac vulputate sit amet, vehicula non elit. Ut varius nisi viverra mauris molestie, vitae eleifend quam ultrices. Integer orci libero, ultrices quis feugiat id, porta vel nunc. Quisque a rutrum ipsum. Praesent ornare vel quam in varius. Nunc pulvinar lectus neque, ut imperdiet ipsum condimentum et. Pellentesque leo augue, hendrerit quis egestas ut, semper eu ante. Pellentesque sem ex, porttitor eu sapien vitae, blandit aliquam sapien. Morbi placerat ante vitae libero lobortis, et commodo urna pulvinar. Morbi elementum dolor in faucibus eleifend. Sed suscipit mattis nulla eu consequat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Proin venenatis orci eget mauris tempor, nec rutrum erat semper.
        ");
        $post0->setCreatedAt(new DateTimeImmutable('now'));
        $post0->setUpdatedAt(new DateTimeImmutable('now'));
        $post0->setValidatedAt(new DateTimeImmutable('now'));
        $post0->setIdEvent($event2);
        $post0->setIdUser($user_artist2);
        $post0->setIdArtist($artist2);
        $post0->setIdMediasList($mediaslist3);
        $post0->setIdMedia($media1);
        
        $manager->persist($post0);

        $post = new Post();

        $post->setTitle("RATIO");
        $post->setTextContent("ICI ON RATIO OU KOA LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL LOLOLOLOLOLOL.");
        $post->setCreatedAt(new DateTimeImmutable('now'));
        $post->setUpdatedAt(new DateTimeImmutable('now'));
        $post->setValidatedAt(null);
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
        $post->setTextContent("AYAYAYAYAYAYAYAYAYAY YAyatAYA");
        $post->setCreatedAt(new DateTimeImmutable('now'));
        $post->setUpdatedAt(new DateTimeImmutable('now'));
        $post->setValidatedAt(new DateTimeImmutable('now'));
        $post->setIdEvent($event);
        $post->setIdUser($user_artist);
        $post->setIdArtist($artist1);

        $manager->persist($post);

        /* BLOC POUR COMMENT */
        $comment = new Comment();

        $comment->setText("OH TU ME RATIO PAS !!!!!");
        $comment->setValidatedAt(new DateTimeImmutable('now'));
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post);

        $manager->persist($comment);

        $comment = new Comment();

        $comment->setText("Tu es un gros c*nnard hahhaahaha!");
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post);

        $manager->persist($comment);

        $comment = new Comment();

        $comment->setText("Super ton concert Jacques !!!!");
        $comment->setValidatedAt(new DateTimeImmutable('now'));
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post0);

        $manager->persist($comment);

        $comment = new Comment();

        $comment->setText("Tu es un gros c*nnard hahhaahaha!");
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setIdUser($user_default);
        $comment->setIdPost($post0);

        $manager->persist($comment);

        $manager->flush();
    }
}

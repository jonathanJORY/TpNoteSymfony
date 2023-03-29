<?php

namespace App\DataFixtures;


use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Track;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
{
    // Créer une session Spotify
    $session = new Session(
        'ea11311d67e048869c710972a24e46be',
        '358d7f3fdc2e4353b8b4e9e0af646faf',
        'localhost:3000'
    );

    // Obtenir un jeton d'accès
    $session->requestCredentialsToken();
    $accessToken = $session->getAccessToken();

    // Créer une instance de l'API Spotify
    $api = new SpotifyWebAPI();
    $api->setAccessToken($accessToken);

    //$artists = $api->getArtists([
    //    'ids' => ['6eUKZXaKkcviH0Ku9w2n3V', '6l3HvQ5sa6mXTsMTB19rO5'] // Exemple avec Ed Sheeran et Coldplay
    //])->artists;

    //$artists = $api->search('artist', 'artist:"Ed Sheeran"', ['limit' => 20])->artists->items;

    //
    $artists = $api->getArtists(['6eUKZXaKkcviH0Ku9w2n3V', '6l3HvQ5sa6mXTsMTB19rO5', '1HY2Jd0NmPuamShAr6KMms', '1dfeR4HaWDbWqFHLkxsg1d'])->artists;
    dump($artists);
    foreach ($artists as $artistData) {
        // Créer un nouvel artiste
        $artist = new Artist();
        $artist->setName($artistData->name);
        foreach ($artistData->genres as $genreData) {
            dump($genreData);
            //dump("test");
            // Vérifier si le genre existe déjà dans la base de données
            $genre = $manager->getRepository(Genre::class)->findOneBy(['name' => $genreData]);

            // S'il n'existe pas, le créer
            if (!$genre) {
                $genre = new Genre();
                $genre->setName($genreData);
                $manager->persist($genre);
            }

            $artist->addGenre($genre);

        }
        $manager->persist($artist);
        $manager->flush();

        // Ajouter les albums de l'artiste
        $albums = $api->getArtistAlbums($artistData->id);
        foreach ($albums->items as $albumData) {
            //$album = $manager->getRepository(Album::class)->findOneBy(['name' => $albumData->name]);

            $album = $manager->getRepository(Album::class)->createQueryBuilder('a')
                ->where('LOWER(a.name) = LOWER(:name)')
                ->setParameter('name', $albumData->name)
                ->getQuery()
                ->getOneOrNullResult();


            if(!$album){
                $album = new Album();
                $album->setName($albumData->name);
                $album->setReleaseDate($albumData->release_date);
                $album->setImage($albumData->images[0]->url);
            }
            // Créer un nouvel album
            
            $artist->addAlbum($album);
            
            // Ajouter les genres de l'album
            // Ajouter les genres de l'album
            


            // Ajouter les pistes de l'album
            $tracks = $api->getAlbumTracks($albumData->id);
            foreach ($tracks->items as $trackData) {
                $track = new Track();
                $track->setName($trackData->name);
                $track->setImage($albumData->images[0]->url);

                $album->addTrack($track);

                $manager->persist($track);
            }

            $manager->persist($album);
            $manager->flush();


        
        }
        $manager->persist($artist);
        $manager->flush();

    }

    $manager->flush();
}
}


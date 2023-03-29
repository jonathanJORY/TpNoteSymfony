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

    $artists = $api->getArtists([
        'ids' => ['6eUKZXaKkcviH0Ku9w2n3V', '6l3HvQ5sa6mXTsMTB19rO5'] // Exemple avec Ed Sheeran et Coldplay
    ])->artists;

    // Parcourir les artistes
    foreach ($artists as $artistData) {
        // Créer un nouvel artiste
        $artist = new Artist();
        $artist->setName($artistData->name);

        // Ajouter les albums de l'artiste
        $albums = $api->getArtistAlbums($artistData->id, ['album_type' => 'album']);
        foreach ($albums->items as $albumData) {
            // Créer un nouvel album
            $album = new Album();
            $album->setName($albumData->name);
            $album->setReleaseDate($albumData->release_date);
            $album->setImage($albumData->images[0]->url);

            $album->addArtist($artist);

            // Ajouter les genres de l'album
            if (property_exists($albumData, 'genres')) {
                foreach ($albumData->genres as $genreData) {
                    // Vérifier si le genre existe déjà dans la base de données
                    $genre = $manager->getRepository(Genre::class)->findOneBy(['name' => $genreData]);

                    // S'il n'existe pas, le créer
                    if (!$genre) {
                        $genre = new Genre();
                        $genre->setName($genreData);
                        $manager->persist($genre);
                    }

                    $album->addGenre($genre);
                }
            }

            // Ajouter les pistes de l'album
            $tracks = $api->getAlbumTracks($albumData->id);
            foreach ($tracks->items as $trackData) {
                $track = new Track();
                $track->setName($trackData->name);
                $track->setDuration($trackData->duration_ms);
                $track->setPreviewUrl($trackData->preview_url);
                $track->setAlbum($album);

                $manager->persist($track);
            }

            $manager->persist($album);
        }

        $manager->persist($artist);
    }

    $manager->flush();
}
}


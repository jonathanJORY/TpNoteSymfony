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
        
        // Récupérer les albums de l'artiste "Ed Sheeran"
        $albums = $api->getArtistAlbums('6eUKZXaKkcviH0Ku9w2n3V', ['album_type' => 'album']);
        
        // Parcourir les albums
        foreach ($albums->items as $albumData) {
            // Créer un nouvel album
            $album = new Album();
            $album->setName($albumData->name);
            $album->setReleaseDate($albumData->release_date);
            $album->setImage($albumData->images[0]->url);
            
            // Ajouter les artistes de l'album
            foreach ($albumData->artists as $artistData) {
                // Vérifier si l'artiste existe déjà dans la base de données
                $artist = $manager->getRepository(Artist::class)->findOneBy(['name' => $artistData->name]);
                
                // S'il n'existe pas, le créer
                if (!$artist) {
                    $artist = new Artist();
                    $artist->setName($artistData->name);
                    $manager->persist($artist);
                }
                
                $album->addArtist($artist);
            }
            
            // Ajouter les genres de l'album
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
                $track->setImage($albumData->images[0]->url);
                $track->setAlbum($album);
                
                $manager->persist($track);
            }
            
            $manager->persist($album);
        }
        
        $manager->flush();
    }
}


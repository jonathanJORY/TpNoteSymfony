<?php
/*
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

    // Set up CURL request to get access token
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://accounts.spotify.com/api/token',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'grant_type' => 'client_credentials',
        'client_id' => 'ea11311d67e048869c710972a24e46be',
        'client_secret' => '358d7f3fdc2e4353b8b4e9e0af646faf',
    ]),
    CURLOPT_RETURNTRANSFER => true,
]);
$response = curl_exec($ch);
curl_close($ch);

// Decode the response JSON
$data = json_decode($response, true);

// Get the access token from the response
$accessToken = $data['access_token'];

    // Set up CURL request to get a list of 20 random artists


$api = new SpotifyWebAPI();
$api->setAccessToken($accessToken);


<?php
*/
namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Track;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use GuzzleHttp\Client;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer les clés d'API depuis les variables d'environnement
        $clientId = "ea11311d67e048869c710972a24e46be";
        $clientSecret = "358d7f3fdc2e4353b8b4e9e0af646faf";


// Créer le contexte de la requête pour obtenir le jeton d'accès
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]),
    ],
]);

// Envoyer la requête et obtenir le jeton d'accès
$response = file_get_contents('https://accounts.spotify.com/api/token', false, $context);
$data = json_decode($response, true);
$accessToken = $data['access_token'];

// Créer le contexte de la requête pour obtenir la liste des artistes
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "Authorization: Bearer " . $accessToken . "\r\n" .
                    "Content-Type: application/json\r\n",
    ],
]);

// Envoyer la requête et obtenir la liste des artistes
/*
$response = file_get_contents('https://api.spotify.com/v1/search?q=year:2022&type=artist&limit=20&offset=' . rand(0, 1000), false, $context);
*/
$response = file_get_contents('https://api.spotify.com/v1/search?' . http_build_query([
    'q' => 'year:2022',
    'type' => 'artist',
    'limit' => 20,
    'offset' => rand(0, 1000),
]), false, $context);

$data = json_decode($response, true);
$artists = $data['artists']['items'];

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);
// Loop through the artists and create entities
foreach ($artists as $artistData) {
    // Create a new artist entity
    $artist = new Artist();
    $artist->setName($artistData['name']);
    $artist->setImage($artistData['images'][0]['url']);

    // Add the artist to the manager and flush
    $manager->persist($artist);
    $manager->flush();

    // Get the artist's albums
    $artistAlbums = $api->getArtistAlbums($artistData['id']);

    // Loop through the artist's albums and create entities
    foreach ($artistAlbums->items as $albumData) {
        // Create a new album entity
        $album = new Album();
        $album->setName($albumData->name);
        $album->setReleaseDate($albumData->release_date);
        $album->setImage($albumData->images[0]->url);

        // Add the album to the artist and the manager
        $artist->addAlbum($album);
        $manager->persist($album);

        // Get the album's tracks
        $albumTracks = $api->getAlbumTracks($albumData->id);

        // Loop through the album's tracks and create entities
        foreach ($albumTracks->items as $trackData) {
            // Create a new track entity
            $track = new Track();
            $track->setName($trackData->name);
            $track->setDuration($trackData->duration_ms);

            // Add the track to the album and the manager
            $album->addTrack($track);
            $manager->persist($track);
        }
    }
}

// Flush all changes to the database
$manager->flush();

        // ... (le reste du code reste inchangé)


}
}


<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/album' => [[['_route' => 'app_album_index', '_controller' => 'App\\Controller\\AlbumController::index'], null, ['GET' => 0], null, true, false, null]],
        '/album/new' => [[['_route' => 'app_album_new', '_controller' => 'App\\Controller\\AlbumController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/artist' => [[['_route' => 'app_artist_index', '_controller' => 'App\\Controller\\ArtistController::index'], null, ['GET' => 0], null, true, false, null]],
        '/artist/new' => [[['_route' => 'app_artist_new', '_controller' => 'App\\Controller\\ArtistController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/genre' => [[['_route' => 'app_genre_index', '_controller' => 'App\\Controller\\GenreController::index'], null, ['GET' => 0], null, true, false, null]],
        '/genre/new' => [[['_route' => 'app_genre_new', '_controller' => 'App\\Controller\\GenreController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/track' => [[['_route' => 'app_track_index', '_controller' => 'App\\Controller\\TrackController::index'], null, ['GET' => 0], null, true, false, null]],
        '/track/new' => [[['_route' => 'app_track_new', '_controller' => 'App\\Controller\\TrackController::new'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/a(?'
                    .'|lbum/([^/]++)(?'
                        .'|(*:63)'
                        .'|/edit(*:75)'
                        .'|(*:82)'
                    .')'
                    .'|rtist/([^/]++)(?'
                        .'|(*:107)'
                        .'|/edit(*:120)'
                        .'|(*:128)'
                    .')'
                .')'
                .'|/genre/([^/]++)(?'
                    .'|(*:156)'
                    .'|/edit(*:169)'
                    .'|(*:177)'
                .')'
                .'|/track/([^/]++)(?'
                    .'|(*:204)'
                    .'|/edit(*:217)'
                    .'|(*:225)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        63 => [[['_route' => 'app_album_show', '_controller' => 'App\\Controller\\AlbumController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        75 => [[['_route' => 'app_album_edit', '_controller' => 'App\\Controller\\AlbumController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        82 => [[['_route' => 'app_album_delete', '_controller' => 'App\\Controller\\AlbumController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        107 => [[['_route' => 'app_artist_show', '_controller' => 'App\\Controller\\ArtistController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        120 => [[['_route' => 'app_artist_edit', '_controller' => 'App\\Controller\\ArtistController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        128 => [[['_route' => 'app_artist_delete', '_controller' => 'App\\Controller\\ArtistController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        156 => [[['_route' => 'app_genre_show', '_controller' => 'App\\Controller\\GenreController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        169 => [[['_route' => 'app_genre_edit', '_controller' => 'App\\Controller\\GenreController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        177 => [[['_route' => 'app_genre_delete', '_controller' => 'App\\Controller\\GenreController::delete'], ['id'], ['POST' => 0], null, false, true, null]],
        204 => [[['_route' => 'app_track_show', '_controller' => 'App\\Controller\\TrackController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        217 => [[['_route' => 'app_track_edit', '_controller' => 'App\\Controller\\TrackController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        225 => [
            [['_route' => 'app_track_delete', '_controller' => 'App\\Controller\\TrackController::delete'], ['id'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];

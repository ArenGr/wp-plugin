<?php
/**
 * The base configuration file for Flexity Podcast plugin
 **/
namespace Config;

class Config
{
    /* Spotify Premium Credentials */
    const SPOTIFY_CLIENT_ID_PREM = '08653904078544d1be585cf796bc1eb9';
    const SPOTIFY_CLIENT_SECRET_PREM = '95630090b3bb4573bb8507ddf1228f7d';
    const SPOTIFY_REDIRECT_URI = 'http://wp.loc/wp-admin/?page=spotify-login';
    const SPOTIFY_API_GET_TOKEN_ENDPOINT = 'https://accounts.spotify.com/api/token';
    const SPOTIFY_API_GET_TRACK_ENDPOINT = 'https://api.spotify.com/v1/tracks/';

    const SITE_DOMAIN = 'wp.loc';

    /* Custom Tables */
    const TABLE_WP_FX_PODCASTS = 'wp_fx_podcasts';
    const TABLE_WP_FX_TOKENS = 'wp_fx_tokens';

    /*Podcasts Images DIRECTORY*/
    const FX_PODCAST_IMAGES_DIR = 'assets/images/podcasts/';
    const FX_PODCAST_IMAGES_DIR_BIG = 'assets/images/podcasts/640x640/';
    const FX_PODCAST_IMAGES_DIR_MEDIUM = 'assets/images/podcasts/300x300/';
    const FX_PODCAST_IMAGES_DIR_SMALL = 'assets/images/podcasts/64x64/';

    /* Mailgun Credentials */
    const FX_MAILGUN_ENDPOINT = 'https://api.mailgun.net/v3/mail.amhphoto.com';
    const FX_MAILGUN_API_KEY = 'key-26c19c544bc9c1e13deab81e0172c1c1';
    const FX_MAILGUN_DOMAIN = 'mail.amhphoto.com';
    const FX_MAILGUN_FROM_ADDR = 'flexity@mail.amhphoto.com';
}


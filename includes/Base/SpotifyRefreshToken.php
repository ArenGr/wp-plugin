<?php
/*
 * @package Flexity
 */

use Config\Config;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

$plugin_root = dirname(__DIR__,2);
$project_root = dirname(__DIR__,5);

require_once($project_root.'/wp-load.php');
require_once($plugin_root.'/vendor/jwilsson/spotify-web-api-php/src/Session.php');
require_once($plugin_root.'/vendor/jwilsson/spotify-web-api-php/src/SpotifyWebAPI.php');
require_once($plugin_root.'/config/Config.php');

$session = new Session(
    Config::SPOTIFY_CLIENT_ID_PREM,
    Config::SPOTIFY_CLIENT_SECRET_PREM,
);
global $wpdb;
$table_tokens = 'wp_fx_tokens';
$tokens = $wpdb->get_results("SELECT access_token, refresh_token FROM `$table_tokens` LIMIT 1;");
$refreshToken = $tokens[0]->refresh_token;
$session->refreshAccessToken($refreshToken);
$options = [
    'auto_refresh' => true,
];
$api = new SpotifyWebAPI($options, $session);
$api->setSession($session);
$api->me();
$newAccessToken = $session->getAccessToken();
$newRefreshToken = $session->getRefreshToken();
$data = array(
    'access_token' => $newAccessToken,
    'refresh_token' => $newRefreshToken,
);
$format = array('%d', '%s', '%s', '%d');
$wpdb->query("TRUNCATE TABLE `$table_tokens`");
$result = $wpdb->insert($table_tokens, $data);
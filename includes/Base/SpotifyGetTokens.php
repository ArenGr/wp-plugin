<?php
/**
 * @package Flexity
 */
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

if (!empty($_POST['hidden-value'])) {
    require_once(dirname(__DIR__, 2) . '/vendor/autoload.php');

    $session = new Session(
        Config\Config::SPOTIFY_CLIENT_ID_PREM,
        Config\Config::SPOTIFY_CLIENT_SECRET_PREM,
        Config\Config::SPOTIFY_REDIRECT_URI
    );
    $api = new SpotifyWebAPI();
    if (isset($_GET['code'])) {
        $session->requestAccessToken($_GET['code']);
        $api->setAccessToken($session->getAccessToken());
        $_GET['access_data'] = $session->getAccessToken();
    } else {
        $options = [
            'scope' => [
                'user-read-email',
                'streaming',
                'user-modify-playback-state',
                'user-read-private'
            ],
            "show_dialog" => "false"
        ];

        header('Location: ' . $session->getAuthorizeUrl($options));
        die();
    }
}else{?>
<?php }
<div class="st-admin-form-title">
    <h3>Activate Spotify Account</h3>
</div>
<div class="st-admin-form-get-track">
    <form method="post" action="<?php echo plugin_dir_url( dirname( __FILE__, 2 ) )."includes/Base/SpotifyGetTokens.php"?>">
        <input type="hidden" name="hidden-value" value="Activate">
        <input type="submit" class="button button-success" value="Activate">
    </form>
</div>
<?php
use SpotifyWebAPI\Session;

if (!empty($_GET['code'])) {
    try {
        require_once(dirname(__DIR__, 2) . '/vendor/autoload.php');

        $session = new Session(
            Config\Config::SPOTIFY_CLIENT_ID_PREM,
            Config\Config::SPOTIFY_CLIENT_SECRET_PREM,
            Config\Config::SPOTIFY_REDIRECT_URI
        );

        $session->requestAccessToken($_GET['code']);
        $access_token = $session->getAccessToken();
        $refresh_token = $session->getRefreshToken();
        $data = array(
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
        );
        $format = array('%d', '%s', '%s', '%d');
        global $wpdb;
        $table = \Config\Config::TABLE_WP_FX_TOKENS;
        $wpdb->query("TRUNCATE TABLE `$table`");
        $result = $wpdb->insert($table, $data);
    }catch (Exception $e){
        echo $e;
    }
}


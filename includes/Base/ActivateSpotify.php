<?php

namespace Inc\Base;

class ActivateSpotify extends BaseController
{
    public function register () {
        add_action('admin_menu', array($this, 'addMenuPage'));
    }

    public function addMenuPage(){
        add_menu_page('Spotify Login', 'Spotify Login', 'manage_options', 'spotify-login', array($this, 'spotifyLogin'), 'dashicons-spotify', 110);
    }

    public function spotifyLogin () {
        require_once ( $this->plugin_path.'templates/admin/spotify-login.php');
    }
}
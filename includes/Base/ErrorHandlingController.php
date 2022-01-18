<?php

namespace Inc\Base;

class ErrorHandlingController
{
    public function register()
    {
        if (!function_exists('the_field')) {
            add_action('admin_notices', array($this, 'acf_notice'));
        }
    }

    public function acf_notice()
    {
        ?>
        <div class="update-nag notice row alert alert-danger">
            <?php _e('Please install Advanced Custom Fields, it is required for this plugin to work properly!', 'flexity_textdomain'); ?>
        </div>
        <?php
    }
}
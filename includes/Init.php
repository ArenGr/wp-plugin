<?php
/**
 * @package Flexity
 */
namespace Inc;
use Inc\Base\Enqueue;
use Inc\Base\DatabaseController;
use Inc\Base\CPTController;
use Inc\Base\PageController;
use Inc\Base\TemplateController;
use Inc\Base\PodcastController;
use Inc\Base\ActivateSpotify;

final class Init
{
    public static function get_services() {
        return [
            DatabaseController::class,
            CPTController::class,
            PageController::class,
            TemplateController::class,
            PodcastController::class,
            ActivateSpotify::class,
            Enqueue::class,
        ];
    }

    public static function register_services() {
        foreach ( self::get_services() as $class ) {
            $service = self::instantiate( $class );
            if ( method_exists( $service, 'register' ) ) {
                $service->register();
            }
        }
    }

    private static function instantiate( $class ) {
        $service = new $class();
        return $service;
    }
}
<?php
/**
 * @package  Flexity
 */
namespace Inc\Base;

class ACFController
{
    public static function addFields()
    {
        if (function_exists('acf_add_local_field_group')) {
            acf_add_local_field_group(array(
                'key' => 'group_1',
                'title' => 'Single podcast',
                'fields' => array(
                    array(
                        'key' => 'field_1',
                        'label' => 'Overview title',
                        'name' => 'overview_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_2',
                        'label' => 'Overview description',
                        'name' => 'overview_description',
                        'type' => 'text',

                    ),
                    array(
                        'key' => 'field_3',
                        'label' => 'Overview image',
                        'name' => 'overview_image',
                        'type' => 'image',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'podcast',
                        ),
                    ),
                ),
            ));
        }
    }
}
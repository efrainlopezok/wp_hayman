<?php
if( function_exists('acf_add_local_field_group') ):
    
    acf_add_local_field_group(array (
        'key' => 'group_5a16dc91e6cf9',
        'title' => 'Options',
        'fields' => array (
            array (
                'key' => 'field_5a16dca44b6ac',
                'label' => 'Images',
                'name' => 'gallery_images',
                'type' => 'gallery',
                'value' => NULL,
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'min' => '',
                'max' => '',
                'insert' => 'append',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'gallery',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    

        
        acf_add_local_field_group(array (
            'key' => 'group_5a16dd68b3e24',
            'title' => 'Gallery Options',
            'fields' => array (
                array (
                    'key' => 'field_5a16dd7eff232',
                    'label' => 'List of Galleries',
                    'name' => 'list_of_galleries',
                    'type' => 'post_object',
                    'value' => NULL,
                    'instructions' => 'Please select one gallery for show on bottom section.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'post_type' => array (
                        0 => 'gallery',
                    ),
                    'taxonomy' => array (
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'return_format' => 'id',
                    'ui' => 1,
                ),
            ),
            'location' => array (
                array (
                    array (
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ),
                ),
            ),
            'menu_order' => 124,
            'position' => 'side',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => 1,
            'description' => '',
        ));
        


    endif;
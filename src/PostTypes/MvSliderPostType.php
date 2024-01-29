<?php

namespace Merchant\MvSlider\PostTypes;

if(!class_exists(MvSliderPostType::class))
{
    class MvSliderPostType
    {
        public function __construct()
        {
            add_action('init', [$this, 'create_post_type']);
            add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
            add_action('save_post', [$this, 'save_post'], 10, 2);
        }

        /**
         * Create a custom post type
         * 
         */
        public function create_post_type(): void
        {
            register_post_type( 'mv-slider', [
                'label' => 'Slider',
                'description' => 'Sliders',
                'labels' => [
                    'name' => 'Sliders',
                    'singular_name' => 'Slider'
                ],
                'public' => true,
                'supports' => ['title', 'editor', 'thumbnail'],
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 5,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => false,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-images-alt2',
                //'register_meta_box_cb' => [$this, 'add_meta_boxes'] 
            ]); 
        }

        public function add_meta_boxes(): void
        {
            add_meta_box(
                'mv_slider_meta_box',
                'Link Options',
                [$this, 'add_inner_meta_boxes'],
                'mv-slider',
                'normal',
                'high',
            );
        }

        public function add_inner_meta_boxes($post)
        {   
            require_once(__DIR__ . '/../Views/mv-slider_metabox.php');
        }

        public function save_post($post_id)
        {

            if(isset($_POST['mv_slider_nonce']))
            {
                if(!wp_verify_nonce($_POST['mv_slider_nonce'], 'mv_slider_nonce'))
                {
                    return;
                }
            }

            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            {
                return;
            }

            if(isset($_POST['post_type']) && $_POST['post_type'] === 'mv-slider')
            {
                if(!current_user_can('edit_page', $post_id))
                {
                    return;
                }
                elseif(!current_user_can('edit_post', $post_id))
                {
                    return;
                }
            }

            if(isset($_POST['action']) && $_POST['action'] == 'editpost')
            {
                $old_link_text = get_post_meta($post_id, 'mv_slider_link_text', true);
                $new_link_text = $_POST['mv_slider_link_text'];
                $old_link_url = get_post_meta($post_id, 'mv_slider_link_url', true);
                $new_link_url = $_POST['mv_slider_link_url'];

                if(empty($new_link_text))
                {
                    update_post_meta($post_id, 'mv_slider_link_text', 'Adde some text');
                }
                else
                {
                    update_post_meta($post_id, 'mv_slider_link_text', sanitize_text_field($new_link_text), $old_link_text);
                    
                }

                if(empty($new_link_url))
                {
                    update_post_meta($post_id, 'mv_slider_link_url', '#');
                }
                else
                {
                    update_post_meta($post_id, 'mv_slider_link_url', sanitize_text_field($new_link_url), $old_link_url);
                }
            }
        }
    }
}
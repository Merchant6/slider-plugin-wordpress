<?php
namespace Merchant\MvSlider\Main;
use Merchant\MvSlider\PostTypes\MvSliderPostType;

if(!class_exists(MvSlider::class))
{
    class MvSlider
    {
        public function __construct()
        {
            $this->define_constants();
            
            $mv_slider_post_type = new MvSliderPostType();
        }

        /**
         * Define Constants
         *
         * @return void
         */
        public function define_constants():void
        {
            define('MV_SLIDER_PATH', plugin_dir_path(__FILE__));
            define('MV_SLIDER_URL', plugin_dir_path(plugin_dir_url(__FILE__)));
            define('MV_SLIDER_VERSION', '1.0.0');
        }

        /**
         * Performs something on plugin activation
         * 
         * @return void
         */
        public static function activate():void
        {
            update_option('rewrite_rules', '');
        }

        /**
         * Performs something on plugin deactivation
         *
         * @return void
         */
        public static function deactivate():void
        {
            flush_rewrite_rules();
            unregister_post_type('mv-slider');
        }

        /**
         * Performs something on plugin uninstallation
         *
         * @return void
         */
        public static function uninstall():void
        {

        }
    }
}


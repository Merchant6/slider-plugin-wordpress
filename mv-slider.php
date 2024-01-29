<?php
use Merchant\MvSlider\Main\MvSlider;
/**
 * Plugin Name: MV Slider
 * Plugin URI: https://www.wordpress.org/mv-slider
 * Description: Plugin Description
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Saboor Merchant
 * Author URI: https://www.example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/licenses/gpl-2.0.html
 * Text Domain: mv-slider
 * Domain Path: /langauges
 */


require_once __DIR__ . '/vendor/autoload.php';

if(!defined('ABSPATH'))
{
    exit;
}

// define('WP_DEBUG', true);

include_once __DIR__ . '/src/Main/MvSlider.php';

$fqcn = MvSlider::class;

if(class_exists($fqcn))
{   
    register_activation_hook(__FILE__, [$fqcn, 'activate']);
    register_deactivation_hook(__FILE__, [$fqcn, 'deactivate']);
    register_uninstall_hook(__FILE__, [$fqcn, 'uninstall']);       
    
    $mv_slider = new $fqcn(); 
}

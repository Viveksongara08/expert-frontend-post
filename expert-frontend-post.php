<?php 

/**
 * Expert Frontend Post for use for frontend users post submission
 * Take this as a base plugin and modify as per your need.
 *
 * @package Expert Frontend Post
 * @author vivek songara
 * @license GPL-2.0+
 * @link http://expertwebinfotech.com
 * @copyright 2022 Vivek songara, LLC. All rights reserved.
 *
 *            @wordpress-plugin
 *            Plugin Name: Expert Frontend Post
 *            Plugin URI: http://expertwebinfotech.com
 *            Description: Expert Frontend Post for frontend users post submission
 *            Version: 1.1
 *            Author: Vivek Songara
 *            Author URI: 
 *            Text Domain: Expert Frontend Post
 *            Contributors: Vivek Songara
 *            License: GPL-2.0+
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
 
 
if ( ! defined( 'ABSPATH' ) ) exit;
//************************************//

define( 'EXPERT_FRONTEND_POST_VERSION', '0.1' );
define( 'METADATA_VERSION', '0.1' );

define('RNR_FUNCTIONS', plugin_dir_path(__FILE__)  . '/includes');
define('RNR_PATH', plugins_url('',__FILE__) );

include_once(RNR_FUNCTIONS.'/post_expert_posts.php');
include_once(RNR_FUNCTIONS.'/expert_frontend_post_framwork.php');
include_once(RNR_FUNCTIONS.'/expert_frontend_post_shortcode.php');






?>


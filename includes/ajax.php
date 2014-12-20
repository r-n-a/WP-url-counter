<?php
// include() or require() any necessary files here...
include_once('db.php');
include_once('inc.php');

define( 'SHORTINIT', true );
 
// Build the wp-load.php path from a plugin/theme
//$wp_root_path = dirname( dirname( dirname( __FILE__ ) ) );
// Require the wp-load.php file (which loads wp-config.php and bootstraps WordPress)
require('../../../../wp-load.php');
 
// Include the now instantiated global $wpdb Class for use
global $wpdb;

if(isset($_REQUEST['s'])) {
	$url = $_REQUEST['s'];
	$count = db::ajaxDb($url, $tabname);
	echo $count;
}

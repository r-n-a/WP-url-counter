<?php
/*------------------------------------------------------------------------------
Plugin Name: WP url counter
Plugin URI: 
Description: This plugin makes counting the number of clicks on the link marked by special tags. 
Author: r-n-a
Version: 0.1
Author URI: 
------------------------------------------------------------------------------*/ 
// include() or require() any necessary files here...
include_once('includes/db.php');
include_once('includes/tegs.php');
include_once('includes/inc.php');

$search_handler_url = plugins_url('/url-counter/includes/ajax.php', dirname( __FILE__));

// Settings and/or Configuration Details go here...
define ('DIGGTHIS_JS', 
	"<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js'></script>
	<script type='text/javascript'>
			function ajaxcount(idd) {
			var id='#'+idd;
			var url=idd+'count';
			var href = document.getElementById(url).getAttribute('href');
			//alert(id);
			$(id).load('".$search_handler_url."','s='+href);
		} 
	</script>"
	);
	
// Tie into WordPress Hooks and any functions that should run on load.

db::createTable($tabname);
add_filter('the_content', 'counts');
add_action('wp_head','add_js_to_doc_head');

function counts($content) {	
	global $tabname;
	$tegs = tegs::findTegs($content);
	if(count($tegs)>0) {
		for($i=0; $i<count($tegs); $i++) {
			$id = 'url'.(string)rand(5, 50000);
			$idCount = $id.'count';
			preg_match("/href=\"(.*)\"/siU", $tegs[$i], $urlToDb);
			$pattern = '[count_'.$tegs[$i].'_count]';
			$urlCount = db::setToDb($urlToDb[1],$tabname);
			$patternUrl = '<a href';
			$replacemenUrl = "<a id=".$idCount." onClick=ajaxcount('".$id."') target='_blank' href";
			$tegs[$i] = str_replace($patternUrl, $replacemenUrl, $tegs[$i]);
			$replacemen = $tegs[$i].' ( <url id='.$id.'>'.$urlCount.'</url> downloads)';
			$content = str_replace($pattern, $replacemen, $content);
		}
	}
	return $content;
}

function add_js_to_doc_head() {
	print DIGGTHIS_JS;
}
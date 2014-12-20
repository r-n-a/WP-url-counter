<?php

class db {
	
	public static function createTable($tabname) {
		global $wpdb;
		$table_name = $wpdb->prefix.$tabname;
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$sql = "CREATE TABLE " . $table_name . "
            (
            id int unsigned auto_increment,
            content varchar(250),
            counts int,
            primary key (id)
            );";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		}
    }

    public static function setToDb($teg, $tabname) {
		global $wpdb;
		$query = "SELECT * FROM  $tabname WHERE content='".$teg."'";
		$result = $wpdb->get_row($query, ARRAY_A)or die(mysql_error());
		 if($result) {
			$arg = $result['counts'];
		} else {  
		$wpdb->query("INSERT INTO $tabname (counts, content) VALUES (0, '".$teg."')") or die(mysql_error());
		$arg = 0; 
		}
		return $arg;	
    }
	
	public static function ajaxDb($url, $tabname) {
		global $wpdb;
		$wpdb->query("UPDATE $tabname SET counts=counts+1 WHERE content='".$url."'") or die(mysql_error());
		$query = $wpdb->get_row("SELECT * FROM $tabname WHERE content='".$url."'", ARRAY_A) or die(mysql_error());
		$arg = $query['counts'];
		return $arg;
	}

}
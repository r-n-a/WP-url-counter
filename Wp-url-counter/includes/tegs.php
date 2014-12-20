<?php
/**
 * Created by PhpStorm.
 * User: r-n-a
 * Date: 17.10.14
 * Time: 20:30
 */

class tegs {

    static public function findTegs($text) {
        preg_match_all("/\[count_(.*)_count\]/siU", $text, $urls);
		return $urls[1];
    }

} 
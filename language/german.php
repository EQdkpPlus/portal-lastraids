<?php
/******************************
 * EQDKP PLUS
 * (c) 2008 by EQDKP Plus Dev Team
 * http://www.eqdkp-plus.com
 * ------------------
 * $Id$
 ******************************/

if ( !defined('EQDKP_INC') ){
    header('HTTP/1.0 404 Not Found');exit;
}

$plang = array_merge($plang, array(
  'lastraids'                 => 'Letzte Raids',
  'pk_last_raids_limit'       => 'Anzeige Limit der letzten Raids',
  'pk_set_lastraids_showloot' => 'Loot zu den letzten Raids nicht anzeigen?',
  'pk_lastraids_lootLimit'    => 'Anzeige Limit der Items unter den letzten Raids',
));
?>

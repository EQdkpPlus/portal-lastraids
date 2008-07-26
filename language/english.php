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
  'lastraids'                 => 'Last Raids',
  'pk_last_raids_limit'       => 'Last Raids Limit',
  'pk_set_lastraids_showloot' => 'Don´t Show Items below the Last Raids?',
  'pk_lastraids_lootLimit'    => 'Limit the Items',
));
?>

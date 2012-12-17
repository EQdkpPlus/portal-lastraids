<?php
/*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2008
 * Date:        $Date: 2008-07-29 00:30:30 +0200 (Di, 29. Jul 2008) $
 * -----------------------------------------------------------------------
 * @author      $Author: osr-corgan $
 * @copyright   2006-2008 Corgan - Stefan Knaak | Wallenium & the EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * @version     $Rev: 2450 $
 * 
 * $Id: english.php 2450 2008-07-28 22:30:30Z osr-corgan $
 */

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

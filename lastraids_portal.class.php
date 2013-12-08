<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2012-11-10 11:52:49 +0100 (Sa, 10. Nov 2012) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 12416 $
 * 
 * $Id: lastraids_portal.class.php 12416 2012-11-10 10:52:49Z godmod $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class lastraids_portal extends portal_generic {

	protected static $path		= 'lastraids';
	protected static $data		= array(
		'name'			=> 'LastRaids Module',
		'version'		=> '2.0.0',
		'author'		=> 'Corgan',
		'icon'			=> 'fa-trophy',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Information on last raids',
		'lang_prefix'	=> 'lastraids_'
	);
	protected static $positions = array('left1', 'left2', 'right');
	protected $settings	= array(
		'limit'	=> array(
			'type'		=> 'text',
			'size'		=> '2',
		),
		'showloot'	=> array(
			'type'		=> 'radio',
		),
		'lootLimit'	=> array(
			'type'		=> 'text',
			'size'		=> '2',
		),
	);
	protected static $install	= array(
		'autoenable'		=> '1',
		'defaultposition'	=> 'right',
		'defaultnumber'		=> '3',
	);
	
	protected $reset_pdh_hooks = array(
			'adjustment_update',
			'event_update',
			'item_update',
			'member_update',
			'raid_update'
	);

	public function output() {
		infotooltip_js();
		$output = $this->pdc->get('portal.modul.lastraids',false,true);
		if (!$output) {
			$output = '<table width="100%" class="colorswitch">';
			$limit = ($this->config('limit') > 0) ? $this->config('limit') : 5;
			$lastraids = $this->pdh->maget('raid', array('event', 'date', 'note', 'value'), 0, array($this->pdh->sort($this->pdh->get('raid', 'id_list'), 'raid', 'date', 'desc')));
			$lastraids = array_slice($lastraids, 0, $limit, true);
			if (!is_array($lastraids) || count($lastraids) < 1) {
				return $this->user->lang('lastraids_no_raids');
			}
			
			foreach ($lastraids as $raid_id => &$raid) {
				//Items
				$raid['items'] = '';
				if (!$this->config('showloot')) {
					$loot_limit = ($this->config('lootLimit') > 0) ? $this->config('lootLimit') : 7 ;
					$raid_items = $this->pdh->get('item', 'itemsofraid', array($raid_id));
					if (is_array($raid_items)) {
						$num = 0;
						foreach($raid_items as $item_id) {
							if($num > $loot_limit) break;
							$raid['items'] .= $this->pdh->get('item', 'link_itt', array($item_id, $this->routing->simpleBuild('item'), '', false, 0, 16, false, 'icon', true)).' ';
							$num++;
						}
					}
				}
				$img = $this->game->decorate('events', array($raid['event'], 40));
				$link = $this->pdh->get('raid', 'raidlink', array($raid_id, $this->routing->simpleBuild('raid'), '', true));
				$html_link = $this->pdh->geth('raid', 'raidlink', array($raid_id, $this->routing->simpleBuild('raid'), '', true));
				$raid['note'] = (strlen($raid['note']) > 40) ? substr($raid['note'], 0, 37).'...' : $raid['note'];
				$output .= '<tr><td width="42"><a href="'.$link.'">'.$img.'</a></td>';
				$output .= '<td>'.$html_link.'<br />'.$this->time->user_date($raid['date']).'<br />'.$raid['note'].'<br />'.$raid['items'].'</td></tr>';
			}
			$output .= '</table>';
			$this->pdc->put('portal.modul.lastraids',$output,86400,false,true);
		}
		return $output;
	}
}
?>
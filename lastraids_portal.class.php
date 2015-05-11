<?php
/*	Project:	EQdkp-Plus
 *	Package:	Last raids Portal Module
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class lastraids_portal extends portal_generic {

	protected static $path		= 'lastraids';
	protected static $data		= array(
		'name'			=> 'LastRaids Module',
		'version'		=> '3.0.2',
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
	public $template_file = 'last_raids_portal.html';
	
	protected static $apiLevel = 20;

	public function output(){
		infotooltip_js();
		
		$limit		= ($this->config('limit') > 0)? $this->config('limit') : 5;
		$show_loot	= $this->config('showloot');
		$loot_limit = ($this->config('lootLimit') > 0)? $this->config('lootLimit') : 7 ;
		
		$lastraids	= $this->pdh->maget('raid', array('event', 'date', 'note', 'value'), 0, array($this->pdh->sort($this->pdh->get('raid', 'id_list'), 'raid', 'date', 'desc')));
		$lastraids	= array_slice($lastraids, 0, $limit, true);
		
		foreach($lastraids as $raid_id => $raid){
			$raid_items = $this->pdh->get('item', 'itemsofraid', array($raid_id));
			$raid_items = array_slice($raid_items, 0, $loot_limit, true);
			
			$this->tpl->assign_block_vars('pm_lr_event',array(
				'ID'	=> $raid['event'],
				'NAME'	=> $this->pdh->get('raid', 'event_name', array($raid_id)),
				'DATE'	=> $this->time->user_date($raid['date']),
				'NOTE'	=> (strlen($raid['note']) > 40) ? substr($raid['note'], 0, 37).'...' : $raid['note'],
				'VALUE'	=> $raid['value'],
				'ICON'	=> $this->game->decorate('events', $raid['event'], array(), 40),
				'LINK'	=> $this->pdh->get('raid', 'raidlink', array($raid_id, $this->routing->simpleBuild('raids'), '', true)),
			));
			
			foreach($raid_items as $item_id){
				$this->tpl->assign_block_vars('pm_lr_event.item',array(
					'ICON'	=> $this->pdh->get('item', 'link_itt', array($item_id, $this->routing->simpleBuild('items'), '', false, 0, 16, false, 'icon', true)).' ',
				));
			}
		}
		
		$this->tpl->assign_vars(array(
			'PM_LR_CNF_LIMIT'		=> $limit,
			'PM_LR_CNF_SHOWLOOT'	=> $show_loot,
			'PM_LR_CNF_LOOT_LIMIT'	=> $loot_limit,
			'PM_LR_RAIDS'			=> count($lastraids),
		));
		
		
		return 'Error: Template file is empty.';
	}
	
}
?>

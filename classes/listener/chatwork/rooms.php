<?php
/**
 * ChatWork rooms listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Listener_Chatwork_Rooms extends Listener
{
	protected function things()
	{
		throw new \RuntimeException(
			get_class($this).' expects an array argument when created instance');
	}

	public function talkable()
	{
		$filter = function($element) {
			return
				in_array($element['type'], array('group', 'my')) and
				in_array($element['role'], array('admin', 'member'));
		};

		$this->things = array_filter($this->things, $filter);
		return $this;
	}
}

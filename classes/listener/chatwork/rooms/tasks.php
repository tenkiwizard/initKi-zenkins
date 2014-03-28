<?php
/**
 * ChatWork rooms tasks listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Listener_Chatwork_Rooms_Tasks extends Listener
{
	protected function things()
	{
		throw new \RuntimeException(
			get_class($this).' expects an array argument when created instance');
	}

	public function expired($timestamp = null)
	{
		if (is_null($timestamp)) $timestamp = time();
		$filter = function ($task) use ($timestamp) {
			$limit_time = \Arr::get($task, 'limit_time');
			return $limit_time > 0 and $limit_time < $timestamp;
		};

		$this->things = array_filter($this->things, $filter);
		return $this;
	}

	public function no_limited()
	{
		$filter = function ($task) {
			$limit_time = \Arr::get($task, 'limit_time');
			return $limit_time == 0;
		};

		$this->things = array_filter($this->things, $filter);
		return $this;
	}
}

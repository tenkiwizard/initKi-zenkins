<?php
/**
 * 
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Controller_Test extends Controller
{
	public function get_rooms($api_key = null)
	{
		//$id = $this->override('id', $id);
		$api_key = $this->override('api_key', $api_key);

		$rooms = Talker_Chatwork_Rooms::forge($api_key)->talk();
		$talkable_rooms = Listener_Chatwork_Rooms::forge($rooms)
			->talkable()->listen('room_id');

		if ( ! is_array($talkable_rooms)) $talkable_rooms = array(); // 0件ケース

		$tasks = array();
		foreach ($talkable_rooms as $room)
		{
			$task = Talker_Chatwork_Rooms_Tasks::forge()
				->talk(array(
					'room_id' => $room,
					'status' => 'open',
					));
			$task and $tasks[$room] = $task;
		}

		\Debug::dump($tasks);
		exit;

		foreach ($tasks as $room_id => $tasks)
		{
			\Debug::dump($tasks);
		}

		exit;

	}
}

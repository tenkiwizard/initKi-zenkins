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
		$rooms = Talker_Chatwork_Rooms::forge($api_key)->talk();
		$talkable_rooms = Listener_Chatwork_Rooms::forge($rooms)
			->talkable()->listen('room_id');

		if ( ! is_array($talkable_rooms)) $talkable_rooms = array(); // 0件ケース

		$tasks = array();
		foreach ($talkable_rooms as $room)
		{
			$tasks_per_room = Talker_ChatWork_Rooms_Tasks::forge()
				->talk(array(
					'room_id' => $room,
					'status' => 'open',
					));
			$expired = Listener_Chatwork_Rooms_Tasks::forge($tasks_per_room)
				->expired()->listen();
			if ($expired) $tasks[$room] = $expired;
		}

		foreach ($tasks as $room_id => $expireds)
		{
			foreach ($expireds as $task)
			{
                \Debug::dump(\Arr::flatten($task, '.'));
				$body = __('chatwork.tasks.matter', \Arr::flatten($task, '.'));
				\Log::debug('ZENKINS_SAYS => '.$body, __METHOD__);
				Talker_Chatwork_Rooms_Messages::forge($api_key)
					->talk(array(
						'room_id' => 17137894, //$room_id,
						'body' => $body,
						));
			}
		}
	}
}

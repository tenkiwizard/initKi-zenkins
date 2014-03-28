<?php

/**
 * Init task
 *
 * Run this task to set default write permissions and environment stuff
 * for hituzi.
 *
 * @category initKi
 * @package zenkins
 * @subpackage tasks
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Fuel\Tasks;

class Chatwork
{
	public static function notify_tasks($api_key = null)
	{
		$rooms = \Zenkins\Talker_Chatwork_Rooms::forge($api_key)->talk();
		$talkable_rooms = \Zenkins\Listener_Chatwork_Rooms::forge($rooms)
			->talkable()->listen('room_id');

		if ( ! is_array($talkable_rooms)) $talkable_rooms = array();

		$expired_tasks = array();
		$no_limited_tasks = array();
		foreach ($talkable_rooms as $room)
		{
			$tasks_per_room = \Zenkins\Talker_ChatWork_Rooms_Tasks::forge()
				->talk(array(
					'room_id' => $room,
					'status' => 'open',
					));
			$expired =
				\Zenkins\Listener_Chatwork_Rooms_Tasks::forge($tasks_per_room)
					->expired()->listen();
			if ($expired) $expired_tasks[$room] = $expired;
			$no_limited =
				\Zenkins\Listener_Chatwork_Rooms_Tasks::forge($tasks_per_room)
					->no_limited()->listen();
			if ($no_limited) $no_limited_tasks[$room] = $no_limited;
		}

		\Lang::load('zenkins::vocabulary');
		foreach ($expired_tasks as $room_id => $expireds)
		{
			foreach ($expireds as $task)
			{
				$body = __('chatwork.tasks.expired', \Arr::flatten($task, '.'));
				\Log::debug('ZENKINS_SAYS => '.$body, __METHOD__);
				\Zenkins\Talker_Chatwork_Rooms_Messages::forge($api_key)
					->talk(array(
						'room_id' => $room_id,
						'body' => $body,
						));
			}
		}

		foreach ($no_limited_tasks as $room_id => $no_limiteds)
		{
			foreach ($no_limiteds as $task)
			{
				$body = __('chatwork.tasks.no_limiteds', \Arr::flatten($task, '.'));
				\Log::debug('ZENKINS_SAYS => '.$body, __METHOD__);
				\Zenkins\Talker_Chatwork_Rooms_Messages::forge($api_key)
					->talk(array(
						'room_id' => $room_id,
						'body' => $body,
						));
			}
		}
	}
}

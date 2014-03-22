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

class Controller_Talksto_Chatwork_About_Gitlab extends Controller
{
	private function behave(array $params, Listener_Gitlab $listener)
	{
		foreach ($params as $key => $val)
		{
			${$key} = $this->override($key, $val);
		}

		$things = $listener->listen();
		if (empty($things)) return;
		preg_match('/[^_]+$/', get_class($listener), $matches);
		$kind = strtolower($matches[0]);
		$body = __('gitlab.'.$kind.'.matter', \Arr::flatten($things, '.'));
		\Log::debug('ZENKINS_SAYS => '.$body, __METHOD__);
		Talker_Chatwork_Rooms_Messages::forge($api_key)
			->talk(array(
				'room_id' => $room_id,
				'body' => $body,
				));
	}

	public function post_push($room_id = null, $api_key = null)
	{
		$this->behave(
			array('room_id' => $room_id, 'api_key' => $api_key),
			Listener_Gitlab_Push::forge()
			);
	}

	public function post_mergerequest($room_id = null, $api_key = null)
	{
		$this->behave(
			array('room_id' => $room_id, 'api_key' => $api_key),
			Listener_Gitlab_Mergerequest::forge()
			);
	}
}

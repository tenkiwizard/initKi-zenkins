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
	public function post_push($room_id = null, $api_key = null)
	{
		$room_id = $this->override('room_id', $room_id, 'required');
		$api_key = $this->override('api_key', $api_key);

		$things = Listener_Gitlab_Push::forge()->listen();
		$body = __('gitlab.push.matter', \Arr::flatten($things, '.'));
		\Log::debug('ZENKINS_SAYS => '.$body, __METHOD__);
		Talker_Chatwork::forge($api_key)
			->talk(array(
				'room_id' => $room_id,
				'body' => $body,
				));
	}

	public function post_mergerequest($room_id = null, $api_key = null)
	{
		$room_id = $this->override('room_id', $room_id, 'required');
		$api_key = $this->override('api_key', $api_key);

		$things = Listener_Gitlab_Mergerequest::forge()->listen();
		if (Model_Gitlab_Mergerequest::forge()->assumes_same($things))
		{
			\Log::debug('ZENKINS_SAYS => I ASSUME SAME', __METHOD__);
			return;
		}

		$body = __('gitlab.mergerequest.matter', \Arr::flatten($things, '.'));
		\Log::debug('ZENKINS_SAYS => '.$body, __METHOD__);
		Talker_Chatwork::forge($api_key)
			->talk(array(
				'room_id' => $room_id,
				'body' => $body,
				));
	}
}

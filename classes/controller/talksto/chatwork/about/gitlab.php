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
		if ($this->assume_same($things))
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

	private static $collections = array(
		'id',
		'assignee_id',
		'state',
		'merge_status',
		'description',
		);

	private function assume_same(array $things)
	{
		if (\Arr::get($things, 'merge_status') == 'unchecked' or
			\Arr::get($things, 'state') == 'locked')
		{
			return true;
		}

		$path = __DIR__.'/../../../../../data/';
		$file = 'gitlab.merge_request';
		! file_exists($path.$file) and \File::create($path, $file);
		try
		{
			$csv = \File::read($path.$file, true);
		}
		catch (\Exception $e)
		{
			return false;
		}

		$merge_requests = \Format::forge($csv, 'csv')->to_array();
		$ids = array();
		if (array_key_exists('id', \Arr::get($merge_requests, 0, array())))
		{
			$ids = \Arr::pluck($merge_requests, 'id');
		}

		$id = \Arr::get($things, 'id');
		$index = array_search($id, $ids);
		$last = array();
		if ($index !== false)
		{
			$fields = \Arr::get($merge_requests, $index);
			$last = \Arr::subset($fields, static::$collections);
		}

		$now = \Arr::subset($things, static::$collections);
		if ($last == $now) return true;
		if (\Arr::get($now, 'state') == 'reopened')
		{
			\Arr::delete($merge_requests, $index);
		}
		else
		{
			if ($index !== false)
			{
				$merge_requests[$index] = $now;
			}
			else
			{
				$merge_requests[] = $now;
			}
		}

		if (empty($merge_requests))
		{
			\File::delete($path.$file);
		}
		else
		{
			\File::update($path, $file, \Format::forge($merge_requests)->to_csv());
		}

		return false;
	}
}

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
	const ASSUME_SAME = 1000; // milli socond

	public function post_push($room_id = null, $api_key = null)
	{
		$room_id = $this->override('room_id', $room_id, 'required');
		$api_key = $this->override('api_key', $api_key);

		$things = Listener_Gitlab_Push::forge()->listen();
		$body = __('gitlab.push', \Arr::flatten($things, '.'));

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
		$body = __('gitlab.mergerequest', \Arr::flatten($things, '.'));

		\Log::debug('ZENKINS_SAYS => '.$body, __METHOD__);

		if ($this->assume_same($things)) return;

		Talker_Chatwork::forge($api_key)
			->talk(array(
				'room_id' => $room_id,
				'body' => $body,
				));
	}

	private function assume_same(array $things)
	{
		if (\Arr::get($things, 'merge_status') == 'unchecked') return true;
		$last = $this->last($things);
		$now = $this->now($things);
		if ($last['id'] == $now['id'] and
			($now['updated_at'] - $last['updated_at']) < static::ASSUME_SAME)
		{
			return true;
		}

		return false;
	}

	private function last(array $things)
	{
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

		$last = \Format::forge($csv, 'csv')->to_array()[0];
		\File::update(
			$path, $file, \Format::forge($this->now($things))->to_csv());
		return $last;
	}

	private function now(array $things)
	{
		$id = \Arr::get($things, 'id');
		$updated_at = \Arr::get($things, 'updated_at');
		return array(
			'id' => $id,
			'updated_at' => preg_replace('/[^0-9]/', '', $updated_at),
			);
	}
}

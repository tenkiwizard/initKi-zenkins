<?php
/**
 * GitLab mergerequest model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Gitlab_Mergerequest
{
	private static $path = 'data/';
	private static $file = 'gitlab.merge_request';
	private static $merge_requests = array();
	private static $_properties = array(
		'id',
		'assignee_id',
		'state',
		'merge_status',
		'description',
		);

	public static function forge($path = null, $file = null)
	{
		return new static($path, $file);
	}

	public function __construct($path = null, $file = null)
	{
		$file and static::$file = $file;
		if ($path)
		{
			static::$path = $path;
		}
		else
		{
			static::$path = __DIR__.'/../../../'.static::$path;
		}

		static::$merge_requests = static::load();
	}

	public static function assumes_same(array $things)
	{
		if (static::ignores($things)) return true;
		$ids = array();
		if (array_key_exists('id', \Arr::get(static::$merge_requests, 0, array())))
		{
			$ids = \Arr::pluck(static::$merge_requests, 'id');
		}

		$id = \Arr::get($things, 'id');
		$index = array_search($id, $ids);
		$last = $index !== false
			? \Arr::get(static::$merge_requests, $index)
			: array();
		$now = \Arr::subset($things, static::$_properties);
		if ($last == $now) return true;
		if (static::assumes_merged($now))
		{
			\Arr::delete(static::$merge_requests, $index);
		}
		else
		{
			if ($index !== false)
			{
				static::$merge_requests[$index] = $now;
			}
			else
			{
				static::$merge_requests[] = $now;
			}
		}

		static::save();
		return false;
	}

	private static function assumes_merged(array $things)
	{
		if (\Arr::get($things, 'state') == 'merged') return true;
		return false;
	}

	private static function ignores(array $things)
	{
		if (\Arr::get($things, 'merge_status') == 'unchecked') return true;
		if (\Arr::get($things, 'state') == 'locked') return true;
		return false;
	}

	private static function load()
	{
		if (! file_exists(static::$path.static::$file))
		{
			\File::create(static::$path, static::$file);
		}

		$csv = \File::read(static::$path.static::$file, true);
		return \Format::forge($csv, 'csv')->to_array();
	}

	private static function save()
	{
		if (empty(static::$merge_requests))
		{
			\File::delete(static::$path.static::$file);
		}
		else
		{
			\File::update(
				static::$path, static::$file,
				\Format::forge(static::$merge_requests)->to_csv());
		}
	}
}

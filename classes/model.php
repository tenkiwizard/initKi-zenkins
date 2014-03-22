<?php
/**
 * Model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

abstract class Model extends \Query\Model_Api
{
	const CONFIG_SECTION = '';
	const CONFIG_API_KEY = 'api_key';
	const TABLEIZE_PATTERN = '';

	/**
	 * @var $base_url
	 *
	 * \Initki::Api::$base_urlがスタティックなプロパティのため、
	 * 1プロセス内で複数Web APIにリクエストするzenkinsでは活用しづらい
	 */
	// protected static $base_url = '';

	public function __construct()
	{
		\Config::load('zenkins::resource', 'resource');
		$api_key = \Config::get(
			'resource.'.static::CONFIG_SECTION.'.'.static::CONFIG_API_KEY);
		$api_key and static::$query[static::CONFIG_API_KEY] = $api_key;
		static::$base_url = \Config::get(
			'resource.'.static::CONFIG_SECTION.'.host');
		parent::__construct();
	}

	public function api_key($api_key = null)
	{
		$api_key and static::$query[static::CONFIG_API_KEY] = $api_key;
		return $this;
	}

	public static function table()
	{
		if ($pattern = static::TABLEIZE_PATTERN)
		{
			return preg_replace($pattern, '', parent::table());
		}

		return parent::table();
	}

	protected static function proc_table_name(array $params)
	{
		static::$_table_name = '';
		$table_segments = explode('_', static::table());
		$uri_segments = array();
		foreach ($table_segments as $segment)
		{
			$uri_segments[] = $segment;
			$param = array_shift($params);
			if ($param) $uri_segments[] = $param;
		}

		return implode('/', $uri_segments);
	}
}

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

	/**
	 * @var $base_url
	 *
	 * \Initki::Api::$base_urlがスタティックなプロパティのため、
	 * 1プロセス内で複数Web APIにリクエストするzenkinsでは使用しづらい
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
}

<?php
/**
 * ChatWork rooms messages model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Chatwork_Rooms_Messages extends Model_Chatwork
{
	public function build_query(array $params = array())
	{
		static::$_table_name = static::proc_table_name($params);
		\Arr::delete($params, 'room_id');
		return parent::build_query($params);
	}

	private static function proc_table_name(array $params)
	{
		$table_segments = explode('_', static::table(), 2);
		return \Arr::get($table_segments, 0).'/'.\Arr::get($params, 'room_id').
			'/'.\Arr::get($table_segments, 1, '');
	}
}

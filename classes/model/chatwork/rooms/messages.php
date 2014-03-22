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
		static::$_table_name = static::proc_table_name(
			array(\Arr::get($params, 'room_id')));
		\Arr::delete($params, 'room_id');
		return parent::build_query($params);
	}
}

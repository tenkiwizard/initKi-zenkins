<?php
/**
 * ChatWork rooms model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Chatwork_Rooms extends Model_Chatwork
{
	public function build_query(array $params = array())
	{
		static::$_table_name = static::proc_table_name($params);
		\Arr::delete($params, 'room_id');
		return parent::build_query($params);
	}
}

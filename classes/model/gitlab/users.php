<?php
/**
 * Gitlab users model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Gitlab_Users extends Model_Gitlab
{
	public function build_query(array $params = array())
	{
		static::$_table_name = static::proc_table_name(
			array(\Arr::get($params, 'id')));
		\Arr::delete($params, 'id');
		return parent::build_query($params);
	}
}

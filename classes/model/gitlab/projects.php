<?php
/**
 * Gitlab projects model
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Model_Gitlab_Projects extends Model_Gitlab
{
	protected static $original_table_name = 'projects';

	public function build_query(array $params = array())
	{
		static::$_table_name = static::$original_table_name;
		if ($id = \Arr::get($params, 'id'))
		{
			static::$_table_name .= '/'.$id;
			\Arr::delete($params, 'id');
		}

		return parent::build_query($params);
	}
}

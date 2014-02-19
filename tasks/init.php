<?php

/**
 * Init task
 *
 * Run this task to set default write permissions and environment stuff
 * for hituzi.
 *
 * @category initKi
 * @package hituzi
 * @subpackage tasks
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Fuel\Tasks;

class Init
{
	public static function run()
	{
		$writable_paths = array(APPPATH.'modules/hituzi/data');

		foreach ($writable_paths as $path)
		{
			if (@chmod($path, 0777))
			{
				\Cli::write("\t".'Made writable: '.$path, 'green');
			}
			else
			{
				\Cli::write("\t".'Failed to make writable: '.$path, 'red');
			}
		}
	}
}


<?php
/**
 * GitLab pushes listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

abstract class Listener_Gitlab extends Listener
{
	protected function things()
	{
		return \Input::json();
	}
}

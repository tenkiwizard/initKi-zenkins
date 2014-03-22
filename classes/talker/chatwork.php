<?php
/**
 * Gitlab talker about users
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Talker_Chatwork extends Talker
{
	protected static $model = 'Zenkins\Model_Chatwork_Rooms';
	protected static $method = 'post';
}

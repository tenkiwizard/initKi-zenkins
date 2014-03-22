<?php
/**
 * ChatWork rooms messages talker
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Talker_Chatwork_Rooms_Messages extends Talker
{
	protected static $model = 'Zenkins\Model_Chatwork_Rooms_Messages';
	protected static $method = 'post';
}

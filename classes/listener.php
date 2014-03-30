<?php
/**
 * Listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

abstract class Listener
{
	protected $things = array();

	public static function forge($things = null)
	{
		return new static($things);
	}

	public function __construct($things = null)
	{
		$this->things = is_null($things) ? (array) $this->things() : $things;
		\Log::debug($this, __METHOD__);
	}

	abstract protected function things();

	public function __toString()
	{
		return \Format::forge($this->things)->to_json();
	}

	public function listen($field = null)
	{
		if ( ! is_null($field) and ! \Arr::is_assoc($this->things))
		{
			try
			{
				return \Arr::pluck($this->things, $field) ?: null;
			}
			catch (\PhpErrorException $e)
			{
				// $field is undefined index
				return null;
			}
		}

		return ! is_null($field)
			? \Arr::get($this->things, $field)
			: $this->things;
	}
}

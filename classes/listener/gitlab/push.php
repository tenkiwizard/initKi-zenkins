<?php
/**
 * GitLab push listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Listener_Gitlab_Push extends Listener_Gitlab
{
	public function __construct()
	{
		parent::__construct();
		$this->things = $this->paraphrase($this->things);
	}

	private function paraphrase(array $things)
	{
		$diff_url = \Arr::get($things, 'repository.homepage');
		if ((int) \Arr::get($things, 'before'))
		{
			$diff_url .=
				'/compare/'.\Arr::get($things, 'before').
				'...'.\Arr::get($things, 'after');
		}
		else
		{
			$diff_url .= '/commit/'.\Arr::get($things, 'after');
		}

		$things['diff_url'] = $diff_url;
		return $things;
	}
}

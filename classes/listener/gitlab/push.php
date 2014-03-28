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
		$null_hash = '0000000000000000000000000000000000000000';
		$diff_url = \Arr::get($things, 'repository.homepage');
		if (\Arr::get($things, 'before') === $null_hash)
		{
			$diff_url .= '/commit/'.\Arr::get($things, 'after');
		}
		elseif (\Arr::get($things, 'after') === $null_hash)
		{
			$diff_url = substr(\Arr::get($things, 'ref'), 11).
				__('gitlab.push.deleted');
		}
		else
		{
			$diff_url .= '/compare/'.\Arr::get($things, 'before').'...'.
				\Arr::get($things, 'after');
		}

		$things['diff_url'] = $diff_url;
		return $things;
	}
}

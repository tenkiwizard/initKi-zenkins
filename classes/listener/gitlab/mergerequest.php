<?php
/**
 * GitLab mergerequest listener
 *
 * @package app
 * @subpackage zenkins
 * @author kawamura.hryk
 * @license MIT License
 * @copyright Small Social Coding
 */

namespace Zenkins;

class Listener_Gitlab_Mergerequest extends Listener_Gitlab
{
	public function __construct()
	{
		parent::__construct();
		$this->things = \Arr::get($this->things, 'object_attributes', array());
		if (Model_Gitlab_Mergerequest::forge()->assumes_same($this->things))
		{
			\Log::debug('ZENKINS_SAYS => I ASSUME SAME', __METHOD__);
			$this->things = array();
			return;
		}

		$this->things = $this->call($this->things);
		$this->things = $this->paraphrase($this->things);
	}

	private function call(array $things)
	{
		if (empty($things)) return $things;
		$users = Talker_Gitlab_Users::forge();
		$things['author'] = \Arr::get($users->talk(array(
			'id' => \Arr::get($things, 'author_id'))), 'name');
		$things['assignee'] = \Arr::get($users->talk(array(
			'id' => \Arr::get($things, 'assignee_id'))), 'name');
		$projects = Talker_Gitlab_Projects::forge();
		$things['source_project'] = \Arr::get(
			$projects->talk(
				array('id' => \Arr::get($things, 'source_project_id'))),
			'name_with_namespace');
		$things['target_project'] = \Arr::get(
			$projects->talk(
				array('id' => \Arr::get($things, 'target_project_id'))),
			'name_with_namespace');
		$things['web_url'] = \Arr::get(
			$projects->talk(
				array('id' => \Arr::get($things, 'target_project_id'))),
			'web_url');
		return $things;
	}

	private function paraphrase(array $things)
	{
		$state = __('gitlab.mergerequest.state.'.\Arr::get($things, 'state'));
		$things['state'] = $state ?: \Arr::get($things, 'state');
		$merge_status = __('gitlab.mergerequest.merge_status.'.\Arr::get($things, 'merge_status'));
		$things['merge_status'] = $merge_status ?: \Arr::get($things, 'merge_status');
		return $things;
	}
}

<?php
namespace Zenkins;

class Listener_Gitlab_Mr extends Listener_Gitlab_Mergerequest
{
	public static $data = array(
		'object_kind' => 'merge_request',
		'object_attributes' => array(
			'id' => 99,
			'target_branch' => 'master',
			'source_branch' => 'ms-viewport',
			'source_project_id' => 3,
			'author_id' => 2,
			'assignee_id' => 3,
			'title' => 'MS-Viewport',
			'created_at' => '2013-12-03T17:23:34Z',
			'updated_at' => '2013-12-03T17:23:35Z',
			//'st_commits' => null,
			//'st_diffs' => null,
			//'milestone_id' => null,
			'state' => 'opened',
			'merge_status' => 'can_be_merged',
			'target_project_id' => 3,
			'iid' => 1,
			'description' => 'plz!'
			));

	protected function things()
	{
		return static::$data;
	}
}

class Listener_Gitlab_Mr_Nulldata extends Listener_Gitlab_Mr
{
	public static $data = null;
}

/**
 * Listener_Gitlab_Mergerequest class Tests
 *
 * @group Modules
 */

class Test_Listener_Gitlab_Mergerequest extends \TestCase
{
    /*
	public function test_listen()
	{
		$stub_users = $this->getMock('Listener_Gitlab_Users', array('talk'));
		$stub_users->expects($this->any())
			 ->method('talk')
			 ->will($this->returnValueMap(array(
				 array(array('id' => 1), array('name' => 'aaa')),
				 array(array('id' => 2), array('name' => 'bbb')),
				 )));
		$stub_projects = $this->getMock('Listener_Gitlab_Projects', array('talk'));
		$stub_projects->expects($this->any())
			 ->method('talk')
			 ->will($this->returnValueMap(array(
				 array(array('id' => 101), array('source_project_id' => 'zzz')),
				 array(array('id' => 102), array('target_project_id' => 'yyy')),
				 array(array('id' => 103), array('web_url' => 'http://xxx.example.com')),
				 )));

		$expected = Listener_Gitlab_Mr::$data['object_attributes'];
		$actual = Listener_Gitlab_Mr::forge()->listen();
		$this->assertEquals($expected, $actual);
	}
    */

	public function test_listen_nulldata()
	{
		$actual = Listener_Gitlab_Mr_Nulldata::forge()->listen();
		$this->assertEquals($actual, array());

		$actual = Listener_Gitlab_Mr_Nulldata::forge()->listen('fugahoge');
		$this->assertNull($actual);
	}
}

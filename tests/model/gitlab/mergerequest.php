<?php
namespace Zenkins;

/**
 * Model_Gitlab_Mergerequest class Tests
 *
 * @group Modules
 */

class Test_Gitlab_Mergerequest extends \TestCase
{
	private static $path = '/tmp/';
	private static $file = 'fugahoge.txt';
	private static $things = array(
			'id' => 111,
			'assignee_id' => 22,
			'state' => 'opened',
			'merge_status' => 'can_be_merged',
			'description' => 'hogehoge',
			);

	public function test_file_created()
	{
		if (file_exists(static::$path.static::$file))
		{
			\File::delete(static::$path.static::$file);
		}

		$this->assertFalse(file_exists(static::$path.static::$file));
		Model_Gitlab_Mergerequest::forge(static::$path, static::$file);
		$this->assertTrue(file_exists(static::$path.static::$file));
	}

	public function test_assumes_same()
	{
		$model = Model_Gitlab_Mergerequest::forge(static::$path, static::$file);
		$this->assertFalse($model->assumes_same(static::$things));
		$this->assertTrue($model->assumes_same(static::$things));
		$things = static::$things;
		$things['id'] = 112;
		$this->assertFalse($model->assumes_same($things));
	}

	public function test_ignores()
	{
		$model = Model_Gitlab_Mergerequest::forge(static::$path, static::$file);
		$things = static::$things;
		$things['merge_status'] = 'unchecked';
		$this->assertTrue($model->assumes_same($things));

		$things = static::$things;
		$things['state'] = 'locked';
		$this->assertTrue($model->assumes_same($things));
	}

	public function test_file_deleted()
	{
		$model = Model_Gitlab_Mergerequest::forge(static::$path, static::$file);
		$things = static::$things;
		$things['state'] = 'merged';
		$this->assertFalse($model->assumes_same($things));
		$this->assertTrue(file_exists(static::$path.static::$file));

		$model = Model_Gitlab_Mergerequest::forge(static::$path, static::$file);
		$things['id'] = 112;
		$this->assertFalse($model->assumes_same($things));
		$this->assertFalse(file_exists(static::$path.static::$file));
	}
}

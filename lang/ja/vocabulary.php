<?php

return array(
	'gitlab' => array(
		'push' => array(
			'matter' =>
				"[info]".
				"[title]Pushが発生しました[/title]\n".
				"した人：:user_name\n".
				"対象リポジトリ：:repository.name\n".
				"差分を見る：:diff_url".
				"[/info]",
			'deleted' => 'ブランチは削除された模様です。',
			),
		'mergerequest' => array(
			'matter' =>
				"[info]".
				"[title]Merge Request【!:iid :title】が :state[/title]\n".
				"URL: :web_url/merge_requests/:iid\n".
				"・:author → :assignee\n".
				"・:source_project :source_branch → :target_project :target_branch\n".
				"【:merge_status】\n".
				"[hr]:description[hr]".
				"[/info]",
			'state' => array(
				'opened' => 'オープンされました',
				'merged' => 'マージされました',
				),
			'merge_status' => array(
				'can_be_merged' => '自動マージ可',
				'cannot_be_merged' => '自動マージ不可',
				),
			),
		),
	'chatwork' => array(
		'tasks' => array(
			'expired' =>
				"[To::account.account_id] :account.nameさん".
				"[info]".
				"[title]期限を過ぎたタスクがあります[/title]".
				"[task aid=:account.account_id st=:status lt=:limit_time]:body[/task]".
				"[/info]",
			'no_limiteds' =>
				"[To::assigned_by_account.account_id] :assigned_by_account.nameさん".
				"[info]".
				"[title]このタスクには期限が設定されてません[/title]".
				"[task aid=:account.account_id st=:status lt=:limit_time]:body[/task]".
				"[/info]",
			),
		),
	);

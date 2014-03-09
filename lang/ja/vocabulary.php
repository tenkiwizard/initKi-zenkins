<?php

return array(
	'gitlab' => array(
		'push' => array(
			'matter' =>
				"[info]".
				"[title]Pushが発生しました[/title]\n".
				"した人：:user_name\n".
				"対象リポジトリ：:repository.name\n".
				"差分を見る：:repository.homepage/compare/:before...:after".
				"[/info]",
			),
		'mergerequest' => array(
			'matter' =>
				"[info]".
				"[title]Merge Request【!:iid :title】が :state になりました[/title]\n".
				"URL: :web_url/merge_requests/:iid\n".
				"・:author → :assignee\n".
				"・:source_project :source_branch → :target_project :target_branch\n".
				"【:merge_status】\n".
				"[hr]:description[hr]".
				"[/info]",
			),
		),
	);

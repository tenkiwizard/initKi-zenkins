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
				"した人：:author\n".
				"された人：:assignee\n".
				":source_project :source_branch → :target_project :target_branch\n".
				"マージステータス（って何？）は :merge_status です。\n".
				"差分を見る：未実装\n".
				"コメント：\n".
				"[hr]:description[hr]".
				"[/info]",
			),
		),
	);

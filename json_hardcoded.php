<?php 

$game = [
			['name' => 'Level_01', 
			'items' => [['name' => 'Banc', 'note' => 'blabla', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'state' => 'pending', 'filetype' => 'image'],
						['name' => 'Banc', 'note' => 'blabla', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'state' => 'pending', 'filetype' => 'image']]],

		
			['name' => 'Level_02', 
			'items' => ['name' => 'Banc', 'note' => 'blabla', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'state' => 'pending', 'filetype' => 'image']]
		];

$json = 
			['name' => 'Level_01', 
			'items' => [['name' => 'Banc', 'note' => 'blabla', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'filetype' => 'image', 'extension' => ''],
						['name' => 'Banc', 'note' => 'blabla', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'filetype' => 'image', 'extension' => '']]];

echo '<pre>';
echo (json_encode($json));
echo '</pre>';
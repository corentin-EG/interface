<?php

require 'functionsLoader.php';

if (isset($_POST['json']) && isset($_POST['name']))
{

	echo '<pre>';
	print_r(json_decode($jsontest, true));
	echo '</pre>';

	$donnees['json'] = json_decode($_POST['json'], true);
	$donnees['name'] = $_POST['name'];

	$gameManager = new GameManager($db);
	$game = new Game($donnees);
	$gameManager->add($game);
	$levelManager = new LevelManager($db);
	$assetManager = new AssetManager($db);


	foreach ($donnees['json']['allLevels'] as $value)
    {
    	$level = new Level([
			'name' => $value['name'],
			'assetsTotal' => count($value['items']),
			'idGame' => $game->id()
		]);
		$levelManager->generate($level);
		if ($value['items'])
		{
			foreach ($value['items'] as $iKey => $iValue)
			{
				$asset = new Asset([
		 			'name' => $iValue['name'],
		 			'note' => $iValue['note'],
		 			'location' => $iValue['location'],
		 			'author' => $iValue['author'],
		 			'filetype' => $iValue['filetype'],
		 			'idLevel' => $level->id(),
		 			'idGame' => $game->id(),
		 			'extension' => $iValue['extension']
				]);
				$assetManager->generate($asset);
				echo 'Le projet '.$game->name().' a été correctement ajouté (id='.$game->id().').<br/>';
				echo '<a href="../index.php?id='.$game->id().'">Acceder au projet '.$game->name().'</a>';
			}
		}	
    }
}
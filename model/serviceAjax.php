<?php

require 'functionsLoader.php';

if (isset($_POST['service']) && isset($_POST['id']))
{
	$service = $_POST['service'];
	$id = $_POST['id'];

	switch ($service)
	{
		case 'asset':
			$assetManager = new AssetManager($db);
			$asset = $assetManager->get($id);
			$asset->buildUrl();
			$assetInfo = $asset->info();
			echo json_encode($assetInfo);
			break;

		default:
			echo FALSE;
			break;
	}
}


<?php 

$title = 'Games Brand Runner';
require 'model/functionsLoader.php';

include 'header.php';
include 'menu.php';

$projectManager = new ProjectManager($db);
$objectManager = new ObjectManager($db);
$assetManager = new AssetManager($db);

try {
	$id = htmlspecialchars($_GET['id']);

	if (!$project = $projectManager->get($_GET['id']))
		throw new Exception("Aucun projet ne correspond à cet id");

	$objectList = $objectManager->getAllFromProject($id);


} catch (Exception $e) {
	echo $e->getMessage();
}
?>
<div id="container">
	<div id="heading">
		<h1><?php echo $project->name() ?></h1>
		<h3>Project / <?php echo $project->name() ?></h3>
	</div>
	<div id="content">
		<div id="global-view">
			<h2>Global View</h2>
			<div class="back_loading_bar"><div class="loading_bar"></div></div>

			<div id="global-view-detail">
				<nav>
					<ul>
						<li><a href="" class="active">Complete</a></li>
						<li><a href="">Pending</a></li>
						<li><a href="">Error</a></li>
					</ul>
				</nav>
				<input type="text" class="search" name="search" placeholder="Search">
				<ul id="objectList">
				<?php 
					foreach ($objectList as $object) {
						echo '<li class="object" id="'.$object->id().'">'.$object->name().'<ul>';
						$assetList = $assetManager->getAllFromObject($object->id());
						foreach ($assetList as $asset)
							echo '<li class="asset" id="'.$asset->id().'">'.$asset->name().'</li>';
						echo '</ul></li>';
					}
				?>
				</ul>
			</div>
		</div>
		<div id="structure">
			<h2>Structure</h2>
			<hr>
			<div class="structure-detail">
			
			</div>
		</div>
	</div>
	<div id="popup-bg"></div>
	<div id="popup-item-detail">
		<h1></h1>
		<div id="original">
			<h2>Original</h2>
			<img src="" alt="" />
			<p class="filename"></p>
		</div>
		<div id="uploaded">
			<h2>Uploaded</h2>
			<img src="" alt="" />
			<p class="filename"></p>
		</div>
		<div class="setClear"></div>
		<h3>Notes :</h3>
		<p></p>
		<p id="author"></p>
	</div>
</div>


<?php 

include 'footer.php';

?>
<script src="js/three.js"></script>


<?php 
// Inclusion du fichier des fonctions principales
include 'inc/inc.functions.php'; 
?>
<!DOCTYPE HTML>
<!--
	Story by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Story by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<?php 
		// Inclusion des styles css
		include 'inc/inc.css.php'; ?>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper" class="divided">
				<?php 
				// Chargement du template de la page demandée
					getPageTemplate(
						array_key_exists('page', $_GET) ? $_GET['page'] : null
					); 
				?>
				<?php
				// Inclusion du pied de la page
				 include 'inc/tpl-footer.php'; ?>
			</div>

		<?php 
		// Inclusion des scripts JS
		include 'inc/inc.js.php'; ?>

	</body>
</html>
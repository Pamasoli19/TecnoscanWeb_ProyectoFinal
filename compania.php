<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		include_once ("Code/Head_Items.php");
		?>
	</head>

	<body class="container" role="document">

		<!-- Header -->
		<?php
		include_once 'Code/Header_Menu.php';
		?>
		<ol class="breadcrumb">
			<li>
				<a href="index.php">Inicio</a>
			</li>
			<li id="page_title" class="active">
				Qui&eacute;nes Somos
			</li>
		</ol>
		<hr class="deco_cat" />
		<div class="row bgmenu">
			<div class="col-md-3">
				<?php
				include_once ("Code/Product_Menu.php");
				?>
			</div>
			<div class="col-md-9">
				<div class="row contenedor-general contenedor-compania">
					<h3 class="titulo-app">Qui&eacute;nes Somos</h3>
					<hr class="no-margin"/>
					<div>

				<?php

				if (!($result4 = $mysqli->query("SELECT Texto FROM empresa LIMIT 1;")))
				die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);

				while ($row4 = mysqli_fetch_array($result4, MYSQL_ASSOC)) {
					echo($row4["Texto"]);
				}
				
				mysqli_free_result($result4);
				$mysqli->next_result();
					
				?>
						
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<?php
		include_once ("Code/Footer.php");
		?>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<script src="Resources/js/bootstrap-hover-dropdown.min.js"></script>
	</body>
</html>
<?php include_once("Code/Db_Disconnect.php")
?>
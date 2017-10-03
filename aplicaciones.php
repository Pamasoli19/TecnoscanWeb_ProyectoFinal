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
		  <li><a href="index.php">Inicio</a></li>
		  <li id="page_title" class="active">Aplicaciones</li>
		</ol>
		<div class="row bgmenu">
			<div class="col-md-3">
				<?php
				include_once ("Code/Product_Menu.php");
				?>
			</div>
			<div class="col-md-9">
				<div class="row contenedor-general contenedor-aplicaciones">
				<?php
				$page_title = "Aplicaciones";
				$qstring = $_SERVER['QUERY_STRING'];
				parse_str($qstring);
				 
				if (!($result2 = $mysqli->query("SELECT  mercado_nombre,  mercado_descripcion,  imagen FROM  mercado WHERE  id =  '" . $id . "' LIMIT 1")))
				die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);
							
				while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
				?>
				<h3 class="titulo-app"><?php echo $row2["mercado_nombre"]; ?></h3>
					<hr class="no-margin"/>
				<?php 
					echo $row2["mercado_descripcion"];
					$page_title = $row2["mercado_nombre"];
				}
				mysqli_free_result($result2);
				?>
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
		<script type="text/javascript">
					
					$(function() {
					    $("#page_title").text('<?php echo($page_title);?>');
					});
					
		</script>
	</body>
</html>
<?php include_once("Code/Db_Disconnect.php")
?>
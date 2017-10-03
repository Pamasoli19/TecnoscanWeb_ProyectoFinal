<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		include_once ("Code/Head_Items.php");
		
		$cat = 0;
		$colorPadre = "";
		
		$qstring = $_SERVER['QUERY_STRING'];
		parse_str($qstring);
		
		$catmenu = $cat;
		?>
		<style>
		<?php 
		if (!($result2 = $mysqli->query("SELECT categoria_color FROM categoria WHERE id = (SELECT categoria_padre FROM categoria WHERE id=".$cat.") LIMIT 1 ")))
		die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);
		
		
		while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
?>
hr.deco_cat {
				border-top-color: <?php echo($row2["categoria_color"]); ?>;
			}
<?php 
		}
		
		mysqli_free_result($result2);
?>
			
		</style>
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
			<li ><a href='catalogo.php'>Productos</a></li>
			<?php 
					if(isset($cat)){
						$mysqli->query("SET @cat = " . $cat . ";");
						if (!($resultCat = $mysqli->query("CALL path_categoria(@cat);")))
						die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);
						
						$parentCat = false;
								
						while ($rowCat = mysqli_fetch_array($resultCat, MYSQL_ASSOC)) {
							if(!$parentCat){
								$catmenu = $rowCat["id_cat"];
								$parentCat = true;
							}
							if($cat != $rowCat["id_cat"]){
					?>
				
						<li><a href='catalogo.php?cat=<?php echo $rowCat["id_cat"];?>'><?php echo $rowCat["nombre_cat"];?></a></li>
					<?php 
							}
							else{
						?>
						<li><a href='catalogo.php?cat=<?php echo $rowCat["id_cat"];?>'><?php echo $rowCat["nombre_cat"];?></a></li>
						<?php
							}
						}
						
						mysqli_free_result($resultCat);
						$mysqli->next_result();
					}
					?>
					<li class="active" id="page_title">Producto</li>
		</ol>
		<hr class="deco_cat" />
		<div class="row bgmenu">
			<div class="col-md-3">
				<?php
				include_once ("Code/Product_Menu.php");
				?>
			</div>
			<div class="col-md-9">
				<div class="row contenedor-general contenedor-noticia-detalle">
					
					<?php 
 
  				$page_title = "Producto";
				$qstring = $_SERVER['QUERY_STRING'];
				parse_str($qstring);
				 
				if (!($result2 = $mysqli->query("SELECT producto_nombre, producto_detalle, imagen FROM producto WHERE id = '" . $id . "' LIMIT 1")))
				die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);
							
				while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
					
				$img_path = $path_imagenes.$row2["imagen"];
				?>
					<h3 class="titulo-app"><?php echo $row2["producto_nombre"]; ?><br/></h3>
					<hr class='no-margin' />
					<a href="javascript:void(0);" onclick="ShowImage();">
						<img src="<?php echo $img_path;?>" class="img-thumbnail img-prod" alt="Compa&ntilde;&iacute;a" />
					</a>
					<?php 
						echo $row2["producto_detalle"];
						$page_title = $row2["producto_nombre"];
						echo $row2["noticia_detalle"];
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
					
					function ShowImage(){
						$('#myModal').modal('show');
					}
		</script>
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <br/>
		      </div>
		      <div class="modal-body">
		        	<img src="<?php echo $img_path;?>" class="img-thumbnail center-block" alt="Compa&ntilde;&iacute;a" />
		      </div>
		    </div>
		  </div>
		</div>
	</body>
</html>
<?php include_once("Code/Db_Disconnect.php")
?>
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
		
		<!-- Carousel -->
		<div id="carousel-tecnoscan" class="carousel slide center-block" data-ride="carousel">

			<!-- Wrapper for slides -->
			<div class="carousel-inner">

				<?php
			
				$mysqli->query("SET @row_num  = 0;");
				if (!($result2 = $mysqli->query(" SELECT @row_num := @row_num + 1 as rownumber,  carrousel_enlace,  imagen, objetivo  FROM  carrousel ")))
				die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);

				$enlace = "";
				$imagen = "";
				$objetivo = "";
				$rnum = 0;

				while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {

				$rnum = $row2["rownumber"];
				$enlace = (isset($row2["carrousel_enlace"])?$row2["carrousel_enlace"]:"");
				$imagen = $path_imagenes.$row2["imagen"];
				$objetivo = (isset($row2["objetivo"])?$row2["objetivo"]:"");

				?>

				<div class="item <?php if ($rnum == 1) { echo "active";}?>">
					<?php if(!empty($enlace)){ ?>
					<a href="<?php echo $enlace; ?>" target="<?php echo $objetivo; ?>"><img  src="<?php echo $imagen; ?>" alt="Tecnoscan - Instrumentaci&oacute;n" /></a>
					<?php } else { ?><img  src="<?php echo $imagen; ?>" alt="Tecnoscan - Instrumentaci&oacute;n" /><?php } ?>
				</div>
				<?php
				}
				mysqli_free_result($result2);
				?>
			</div>

			<!-- Controls -->
			<a class="left carousel-control" href="#carousel-tecnoscan" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a>
			<a  class="right carousel-control" href="#carousel-tecnoscan" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a>

		</div>
		<!-- Noticias -->
		<div class="row noticias bgmenu">
			<div class="col-md-3">
				<?php
				include_once ("Code/Product_Menu.php");
				?>
			</div>
			<div class="col-md-9">
				<div class="row contenedor-general contenedor-categorias">
				<?php
				
				$catId = 0;
				$itemCounter = 0;
				
				if (!($result4 = $mysqli->query("SELECT Imagen, Enlace, Descripcion FROM enlace_grafico;")))
				die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);

				while ($row4 = mysqli_fetch_array($result4, MYSQL_ASSOC)) {
					
					if($itemCounter == 3){
						echo ("<div class='col-md-12' ><hr /></div>");
						$itemCounter = 0;
					}	
					
					?>
					
					<div class="col-md-4 ">
						<a href="<?php echo $row4["Enlace"]; ?>" >
							<img src="<?php echo $path_imagenes.$row4["Imagen"]; ?>" alt="<?php echo $row4["Descripcion"]; ?>"  />
						</a>
					</div>
				
					<?php
					$itemCounter++;
				}
				
				mysqli_free_result($result4);
				$mysqli->next_result();
					
				?>
				</div>
				<div class="row contenedor-general contenedor-noticias">
					<table class="table table-striped">
						<tbody>
							<tr><td style="background: #f0f0f0;">
							<h4>Noticias Recientes<a href="noticias.php" role="button" class="btn btn-primary pull-right">Ver todas las noticias</a></h4>
							</td></tr>
							<?php

							if (!($result2 = $mysqli -> query("SELECT  id, noticia_fecha, noticia_titulo, imagen, noticia_resumen FROM  noticia ORDER BY noticia_fecha DESC LIMIT 3")))
								die("Fetch failed: (" . $mysqli -> errno . ") " . $mysqli -> error);

							$filter = " <tr>
											<td><h5>%1\$s <br /><small>publicado: %2\$s</small></h5><hr class='no-margin' />
												%4\$s<p class='text-justify'>%3\$s</p>
												<a href='noticia.php?id=%5\$s'  class='pull-right'>[Leer m&aacute;s]</button>
											</td>
											</tr>";

							$image_placeholder = "";

							while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
								if ($row2["imagen"]) {
									$image_placeholder = sprintf("<img src=\"%1\$s\" style=\"float: left; margin:0 15px 0px 0;max-width:200px; \" class=\"img-rounded\"/>", $path_imagenes . $row2["imagen"]);
								}
								echo(sprintf($filter, $row2["noticia_titulo"], $row2["noticia_fecha"], $row2["noticia_resumen"], $image_placeholder, $row2["id"]));
							}

							mysqli_free_result($result2);
							?>
						</tbody>
					</table>
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
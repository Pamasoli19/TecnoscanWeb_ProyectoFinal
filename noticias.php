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
				Noticias
			</li>
		</ol>
		<hr class="deco_cat" />
		<!-- Noticias -->
		<div class="row noticias bgmenu">
			<div class="col-md-3">
				<?php
				include_once ("Code/Product_Menu.php");
				?>
			</div>
			<div class="col-md-9">
				<?php

				$page = 1;
				$size = 5;

				$total = 0;
				$pages = 1;

				$qstring = $_SERVER['QUERY_STRING'];
				parse_str($qstring);

				$mysqli -> query("SET @size = " . $size . ";");
				$mysqli -> query("SET @page = " . $page . ";");

				if (!($result2 = $mysqli -> query("CALL noticias_listar(@page, @size);")))
					die("Fetch failed: (" . $mysqli -> errno . ") " . $mysqli -> error);

				while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
					$total = $row2["total"];
					$pages = $row2["cantpag"];
				}
				?>
				<div class="row contenedor-general contenedor-noticias">
					<h3 class="titulo-app">Noticias</h3>
					<hr class="no-margin"/>
					<!--div class="col-md-6">
						<ul class="pagination pagination-sm">
							<span class="pull-left pagina" >p&aacute;gina:&nbsp;</span>
							<?php
							
							$setsize = "";
							
							if($size != 5){
								$setsize = "&size=".$size;
							}
							for ($x = 1; $x <= $pages; $x++) {
								if ($x == $page) {
									echo("<li class='active'>");
								} else {
									echo("<li>");
								}
					
								echo "<a href='noticias.php?page=$x$setsize'>$x</a></li>";
							}
							?>
						</ul>
					</div>
					<div class="col-md-6">
						<!--ul class="nav nav-pills nav-size pull-right">
							<li <?php if($size == 5){ echo "class='active'"; }?>><a href="noticias.php?page=1&size=5">5</a></li>
							<li <?php if($size == 9){ echo "class='active'"; }?>><a href="noticias.php?page=1&size=9">9</a></li>
							<li <?php if($size == 12){ echo "class='active'"; }?>><a href="noticias.php?page=1&size=12">12</a></li>
						</ul>
						<span class="pull-right porpagina">Noticias por p&aacute;gina:&nbsp;</span>
					</div>
					<div class="col-md-12">
						<hr class="no-margin" />
					</div-->
	
					<table class="table table-striped">
						<tbody>
							<?php

							mysqli_free_result($result2);
							$mysqli -> next_result();
							$result2 = $mysqli -> store_result();

							$filter = " <tr>
										<td><h5>%1\$s <br /><small>publicado: %2\$s</small></h5><hr  />
										%4\$s<p class='text-justify'>%3\$s</p>
										<a href='noticia.php?id=%5\$s' class='pull-right'>[Leer m&aacute;s]</button>
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
					<div class="col-md-12">
						<hr class="no-margin" />
					</div>
					<div class="col-md-6">
						<ul class="pagination pagination-sm">
							<span class="pull-left pagina" >p&aacute;gina:&nbsp;</span>
							<?php
							
							$setsize = "";
							
							if($size != 5){
								$setsize = "&size=".$size;
							}
							for ($x = 1; $x <= $pages; $x++) {
								if ($x == $page) {
									echo("<li class='active'>");
								} else {
									echo("<li>");
								}
					
								echo "<a href='noticias.php?page=$x$setsize'>$x</a></li>";
							}
							?>
						</ul>
					</div>
					<div class="col-md-6">
						<ul class="nav nav-pills nav-size pull-right">
							<li <?php if($size == 5){ echo "class='active'"; }?>><a href="noticias.php?page=1&size=5">5</a></li>
							<li <?php if($size == 9){ echo "class='active'"; }?>><a href="noticias.php?page=1&size=9">9</a></li>
							<li <?php if($size == 12){ echo "class='active'"; }?>><a href="noticias.php?page=1&size=12">12</a></li>
						</ul>
						<span class="pull-right porpagina">Noticias por p&aacute;gina:&nbsp;</span>
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
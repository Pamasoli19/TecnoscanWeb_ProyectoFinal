<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		include_once ("Code/Head_Items.php");
		
		$cat = 0;
		
		$qstring = $_SERVER['QUERY_STRING'];
		parse_str($qstring);
		
		
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
			<li ><a href='catalogo.php'>Productos</a></li>
			<li class="active" >Resultados de b&uacute;squeda</a></li>
		</ol>
		<hr class="deco_cat" />
		<div class="row bgmenu">
			<div class="col-md-3">
				<?php
				include_once ("Code/Product_Menu.php");
				?>
			</div>
			<div class="col-md-9">
				<?php

				$page = 1;
				$size = 12;

				$total = 0;
				$pages = 1;

				$qstring = $_SERVER['QUERY_STRING'];
				parse_str($qstring);
				?>
				<div class="row contenedor-general">
					<?php
					$mysqli->query("SET @cat = " . $cat . ";");
							if (!($resultCat = $mysqli->query("CALL categoria_consulta(@cat);")))
							die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);
										
							while ($rowCat = mysqli_fetch_array($resultCat, MYSQL_ASSOC)) {
							?>
							<h3 class="titulo-app"><?php echo $rowCat["categoria_nombre"];?></h3>
							<hr class="no-margin"/>
							<div class="contenedor-categoria_desc">
								<img src="<?php echo $path_imagenes."thumbnail_".$rowCat["imagen"];?>" class="imgCatalogo" />
								<?php echo $rowCat["categoria_descripcion"];?>
							</div>
							<div class="col-md-12" >
							<hr style="margin: 10px -15px"/>
							</div>
							<?php 
							$colorPadre = $rowCat["categoria_color"];
							}
							
							mysqli_free_result($resultCat);
							$mysqli->next_result();
							
							$mysqli -> query("SET @size = " . $size . ";");
				$mysqli -> query("SET @page = " . $page . ";");
				$mysqli -> query("SET @criterio = '" . $buscando . "';");

				if (!($result2 = $mysqli -> query("CALL busqueda_productos(@criterio, @page, @size);")))
					die("Fetch failed: (" . $mysqli -> errno . ") " . $mysqli -> error);
				
				$total = 0;
				while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
					$total = $row2["total"];
					$pages = $row2["cantpag"];
				}
				
				if($total>0){
					
					?>
					<!--div class="col-md-6">
						<span class="pull-left pagina" >p&aacute;gina:&nbsp;</span>
						<ul class="pagination pagination-sm">
							<?php
							
							$setsize = "";
							
							if($size != 12){
								$setsize = "&size=".$size;
							}
							for ($x = 1; $x <= $pages; $x++) {
								if ($x == $page) {
									echo("<li class='active'>");
								} else {
									echo("<li>");
								}
					
								echo "<a href='productos.php?cat=$cat&page=$x$setsize'>$x</a></li>";
							}
							?>
						</ul>
					</div>
					<div class="col-md-6">
						<ul class="nav nav-pills nav-size pull-right">
							<li <?php if($size == 12){ echo "class='active'"; }?>><a href="productos.php?cat=<?php echo($cat);?>&page=1&size=12">12</a></li>
							<li <?php if($size == 20){ echo "class='active'"; }?>><a href="productos.php?cat=<?php echo($cat);?>&page=1&size=20">20</a></li>
							<li <?php if($size == 32){ echo "class='active'"; }?>><a href="productos.php?cat=<?php echo($cat);?>&page=1&size=32">32</a></li>
						</ul>
						<span class="pull-right porpagina">Productos por p&aacute;gina:&nbsp;</span>
					</div>
					<div class="col-md-12">
						<hr class="no-margin" />
					</div-->
				
							<?php

							mysqli_free_result($result2);
							$mysqli -> next_result();
							$result2 = $mysqli -> store_result();

							$itemCounter = 0;
							$image_placeholder = "";

							while ($row2 = mysqli_fetch_array($result2, MYSQL_ASSOC)) {
								
								if($itemCounter == 3){
									echo ("<div class='col-md-12' ><hr /></div>");
									$itemCounter = 0;
								}	
								
								?>
					<div class="col-md-4">
						<div class="panel-producto">
							<div class="panel-categoria-imagen">
								<span class="helper"></span>
								<a href="producto.php?id=<?php echo $row2["id"]; ?>&cat=<?php echo $cat;?>" >		
									<img class="img-thumbnail" src="<?php echo $path_imagenes . "thumbnail_" . $row2["imagen"]; ?>"/>
								</a>
							</div>
							<div class="panel-categoria-titulo">
								<a class="tituloCat tituloProd" href="producto.php?id=<?php echo $row2["id"]; ?>&cat=<?php echo $cat;?>" ><?php echo $row2["producto_nombre"]; ?></a>
							</div>
						</div>
					</div>
								<?php
								$itemCounter++;
							}

							mysqli_free_result($result2);
							?>
					<div class="col-md-12">
						<hr  />
					</div>
					<div class="col-md-6">
						<span class="pull-left pagina" >p&aacute;gina:&nbsp;</span>
						<ul class="pagination pagination-sm">
							<?php
							
							$setsize = "";
							
							if($size != 12){
								$setsize = "&size=".$size;
							}
							for ($x = 1; $x <= $pages; $x++) {
								if ($x == $page) {
									echo("<li class='active'>");
								} else {
									echo("<li>");
								}
					
								echo "<a href='productos.php?cat=$cat&page=$x$setsize'>$x</a></li>";
							}
							?>
						</ul>
					</div>
					<div class="col-md-6">
						<ul class="nav nav-pills nav-size pull-right">
							<li <?php if($size == 12){ echo "class='active'"; }?>><a href="productos.php?cat=<?php echo($cat);?>&page=1&size=12">12</a></li>
							<li <?php if($size == 20){ echo "class='active'"; }?>><a href="productos.php?cat=<?php echo($cat);?>&page=1&size=20">20</a></li>
							<li <?php if($size == 32){ echo "class='active'"; }?>><a href="productos.phpcat=<?php echo($cat);?>&?page=1&size=32">32</a></li>
						</ul>
						<span class="pull-right porpagina">Productos por p&aacute;gina:&nbsp;</span>
					</div>
					<?php 
					}
					else{
					?>
					<div class="row contenedor-general">
						<ul class="list-group">
	  						<li class="list-group-item list-group-item-warning">No hay elementos que coincidan con el criterio de b&uacute;squeda.</li>
						</ul>
					</div>
					<?php }?>
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
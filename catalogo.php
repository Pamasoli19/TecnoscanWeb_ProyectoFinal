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
		if (!($result2 = $mysqli->query("SELECT categoria_color FROM categoria WHERE id = ". $catmenu ." LIMIT 1 ")))
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
			<?php
			if($cat == 0){
				echo "<li class='active'>Productos</li>";
			}
			else{
				echo "<li ><a href='catalogo.php'>Productos</a></li>";
			}
			?>
			
			<?php 
					if(isset($cat)){
						$mysqli->query("SET @cat = " . $cat . ";");
						if (!($resultCat = $mysqli->query("CALL path_categoria(@cat);")))
						die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);
								
						while ($rowCat = mysqli_fetch_array($resultCat, MYSQL_ASSOC)) {
					?>
						<li class="active"><?php echo $rowCat["nombre_cat"];?></li>
					<?php 
						}
						
						mysqli_free_result($resultCat);
						$mysqli->next_result();
					}
					?>
		</ol>
		<hr class="deco_cat" />
		<div class="row bgmenu">
			<div class="col-md-3">
				<?php
				include_once ("Code/Product_Menu.php");
				?>
			</div>
			<div class="col-md-9">
				<div class="row contenedor-general ">
					<?php 
					if($cat == 0){
					?>
					<h3 class="titulo-app">Productos</h3>
					<hr class="no-margin"/>
					<?php 
					}else{

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
							?>
							
					
					<?php
					}
				$itemCounter = 0;
				
				$mysqli->query("SET @cat = " . $cat . ";");
				if (!($result4 = $mysqli->query("Call categorias_listar(@cat);")))
				die("Fetch failed: (" . $mysqli->errno . ") " . $mysqli->error);

				$gotoPage = "catalogo";
				if($cat!=0){
					$gotoPage = "productos";
				}
				
				while ($row4 = mysqli_fetch_array($result4, MYSQL_ASSOC)) {
					
					if($itemCounter == 3){
						echo ("<div class='col-md-12' ><hr /></div>");
						$itemCounter = 0;
					}	
					
					if($cat ==0){
						$colorPadre = $row4["categoria_color"];
					}
					
					?>
					
					<div class="col-md-4 ">
						<div class="panel-categoria">
							<div class="panel-categoria-titulo">
								<a class="tituloCat" href="<?php echo($gotoPage);?>.php?cat=<?php echo $row4["id"]; ?>" ><?php echo $row4["categoria_nombre"]; ?></a>
								<hr />
							</div>
							<div class="panel-categoria-imagen">
								<span class="helper"></span>
								<a href="<?php echo($gotoPage);?>.php?cat=<?php echo $row4["id"]; ?>" >
									<img src="<?php echo $path_imagenes . "thumbnail_" . $row4["imagen"]; ?>"/>
								</a>
							</div>
						</div>
					</div>
				
					<?php
					$itemCounter++;
				}
				
				mysqli_free_result($result4);
				$mysqli->next_result();
					
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
	</body>
</html>
<?php include_once("Code/Db_Disconnect.php")
?>
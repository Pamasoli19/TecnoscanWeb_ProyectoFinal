<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
		include_once ("Code/Head_Items.php");
		?>
		<?php
		require_once ('Code/recaptchalib.php');

		$postback_nombre = "";
		$postback_email = "";
		$postback_asunto = "";
		$postback_mensaje = "";
		$postback_checked = "";
		$errorMessage = "";
		$success = false;

		if (!empty($_POST['btnSubmit'])) {
			if (!empty($_POST["recaptcha_challenge_field"])) {
				$privatekey = "6LcFZuMSAAAAANpYP-SixfpBOcYk6x0mwRltdoiC";
				$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

				if (!$resp -> is_valid) {
					// What happens when the CAPTCHA was entered incorrectly
					$errorMessage .= "<li class='list-group-item list-group-item-warning'>El reCAPTCHA no es correcto. Intentelo de nuevo." . "(reCAPTCHA : " . $resp -> error . ") </li>";
				}

				if (empty($_POST['nombre'])) {
					$errorMessage .= "<li class='list-group-item list-group-item-warning'>Digite su nombre</li>";
				}
				if (empty($_POST['email'])) {
					$errorMessage .= "<li class='list-group-item list-group-item-warning'>Digite su e-mail</li>";
				}
				if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					$errorMessage .= "<li class='list-group-item list-group-item-warning'>Digite un e-mail v&aacute;lido</li>";
				}
				if (empty($_POST['asunto'])) {
					$errorMessage .= "<li class='list-group-item list-group-item-warning'>Digite un asunto</li>";
				}
				if (empty($_POST['mensaje'])) {
					$errorMessage .= "<li class='list-group-item list-group-item-warning'>Digite su mensaje</li>";
				}

				if (!empty($errorMessage)) {
					$postback_nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
					$postback_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
					$postback_asunto = filter_var($_POST['asunto'], FILTER_SANITIZE_STRING);
					$postback_mensaje = filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING);
					if (isset($_POST['chkMyEmail'])) {
						$postback_checked = "checked='checked'";
					} else {
						$postback_checked = "";
					}
				} else {
					$to = "";
					if (isset($_POST['chkMyEmail'])) {
						$to = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
					}

					$subject = filter_var($_POST['asunto'], FILTER_SANITIZE_STRING);

					// To send HTML mail, the Content-type header must be set
					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					// Additional headers
					$headers .= 'From: Tecnoscan Contacto <info@tecnoscanco.com>' . "\r\n";
					$headers .= 'Bcc: info@tecnoscanco.com' . "\r\n";

					//.......

					$msg = '
						<html>
						<head>
						  <title></title>
						</head>
						<body>
						  <p>Mensaje enviado por: ' . filter_var($_POST['nombre'], FILTER_SANITIZE_STRING) . (!isset($_POST['chkMyEmail']) ? ' - ' . filter_var($_POST['email'], FILTER_SANITIZE_STRING) : '') . '</p>
						  <table>
							<tr>
							  <td>' . filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING) . '</td>
							</tr>
						  </table>
						</body>
						</html>
						';

					mail($to, $subject, $msg, $headers);
					$success = true;
				}

			}
		}
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
				Cont&aacute;ctenos
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
				<div class="row contenedor-general contenedor-contacto">
					<h3 class="titulo-app">Cont&aacute;ctenos</h3>
					<hr class="no-margin"/>
					<form role="form"  id="form_contacto" name="form_contacto" method="post">
						<div class="form-group">
							<label for="nombre">Nombre Completo</label>
							<input id="nombre" class="form-control"  name="nombre" type="text" value="<?php echo !empty($postback_nombre) ? $postback_nombre : '' ?>"/>
						</div>
						<div class="form-group">
							<label for="email">Direcci&oacute;n de Email</label>
							<input id="email" class="form-control" name="email" type="email" value="<?php echo !empty($postback_email) ? $postback_email : '' ?>"/>
						</div>
						<div class="form-group">
							<label for="asunto">Asunto</label>
							<input id="asunto" class="form-control" name="asunto" type="text" value="<?php echo !empty($postback_asunto) ? $postback_asunto : 'Informaci&oacute;n acerca de los productos' ?>"/>
						</div>
						<div class="form-group">
							<label for="mensaje">Mensaje</label>
							<textarea id="mensaje" class="form-control" name="mensaje" placeholder="Solicitud de Información"><?php echo !empty($postback_mensaje) ? $postback_mensaje : '' ?></textarea>
						</div>
						<div class="checkbox">
							<label for="chkMyEmail">
								<input type="checkbox" id="chkMyEmail" name="chkMyEmail" <?php echo($postback_checked); ?>/>
								Enviar una copia de este mensaje a su propio E-mail </label>
						</div>
						<div class="form-group">
							<script type="text/javascript">
								var RecaptchaOptions = {
									lang : 'es',
									theme : 'clean'
								};
							</script>
							<?php
							$publickey = "6LcFZuMSAAAAAJH6qXD_qNWwmFzTlGlbTxXvmDRs";
							echo recaptcha_get_html($publickey);
							?>
						</div>
						<button id="btnSubmit" name="btnSubmit" value="Enviar" type="submit">
							Enviar
						</button>
					</form>
					<div class="row">
						<br />
						<?php if(!empty($errorMessage)) { ?>
								<ul class="list-group">
									<li class="list-group-item list-group-item-danger">Verifique los siguientes campos:</li>
									<?php echo( $errorMessage ); ?>
								</ul>
					<?php } elseif ($success) {?>
						<ul class="list-group">
						  <li class="list-group-item list-group-item-success">El mensaje se ha enviado exitosamente, un representante se comunicar&aacute; lo m&aacute;s pronto posible.</li>
						</ul>
					<?php
							}
					?>
					</div>
					<address>
						<strong>Tecnoscan Registradores S.A</strong>
						<br />
						300 m Este del Mall Paseo de Las Flores
						<br />
						Heredia, Costa Rica
						<br />
						<abbr title="Tel&eacute;fono y Fax">Tel&eacute;fonos:</abbr> (506) 2237 5117 / (506) 8348 3679 
						<br />Email:
						<a href="mailto:info@tecnoscanco.com">info@tecnoscanco.com</a>
					</address>
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
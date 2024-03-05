<?php

//obter valores associados aos sensores da temperatura
$valor_temperatura = number_format(file_get_contents("api/files/temperatura/valor.txt"), 2);
$hora_temperatura = file_get_contents("api/files/temperatura/hora.txt");
$nome_temperatura = file_get_contents("api/files/temperatura/nome.txt");
$estado_temperatura = file_get_contents("api/files/temperatura/estado.txt");

//obter valores associados aos sensores da luz
$valor_luz = number_format(file_get_contents("api/files/luz/valor.txt"), 2);
$hora_luz = file_get_contents("api/files/luz/hora.txt");
$nome_luz = file_get_contents("api/files/luz/nome.txt");
$estado_luz = file_get_contents("api/files/luz/estado.txt");




session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['luz'])) {
        date_default_timezone_set('Europe/Lisbon');
        $date = date("Y-m-d H:i:s");

        file_put_contents("api/files/luz/valor.txt", $_POST['luz']);
        file_put_contents("api/files/luz/hora.txt", $date);
        file_put_contents("api/files/luz/log.txt", $date . ";" . $_POST['luz'] . ";" . PHP_EOL, FILE_APPEND);
        if ($_POST['luz'] == "0") {
            file_put_contents("api/files/luz/estado.txt", "Off");
        } else if ($_POST['luz'] == "1") {
            file_put_contents("api/files/luz/estado.txt", "Dim");
        } else {
            file_put_contents("api/files/luz/estado.txt", "On");
        }
        header("Refresh:0");
    }
}


?>


<!DOCTYPE html>
<html lang="pt">

<head>
	<title>Praia Inteligente</title>
	<meta charset="utf-8">

	<meta http-equiv="refresh" content="3">

	<link rel="stylesheet" type="text/css" href="sensoresStyle.css">


	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
		crossorigin="anonymous"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body style="background-color: #577F91">

	<!--Navbar-->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="sensores.php">
				<img src="imagens/logoTI.png" alt="" width="60" height="48" class="d-inline-block align-text-top">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="sensores.php">Sensores</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="atuadores.php">Atuadores</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="historico.php">Histórico</a>
					</li>
				</ul>
			</div>
			<a class="text-white" style="text-decoration: none">Bem vindo</a>
			<a href="logout.php" class="btn btn-light btn-lg" tabindex="-1" role="button">Logout</a>
		</div>
	</nav>
	<!--Fim Navbar-->


	<div class="content" style="padding-top: 10px">
		<div class="container">
			<!--INFO SENSORES-->
			<div class="container">
				<div class="card bg-dark text-white">
					<div class="card-header" style="text-align: center">
						<p><b>Sensores</b></p>
					</div>
					<div class="card-body">

						<div class="container">

							<!-- Primeira linha da tabela -->
							<div class="row">

								<!-- Temperatura -->
								<div class="col-sm-3">
									<div class="card text-black">
										<div class="card text-center">
											<div class="card-header">
												<p class="text-center"><b>
														<?php echo $nome_temperatura . ": " . $valor_temperatura ?> ºC
													</b></p>
											</div>
											<div class="card-body">
												<img src="imagens/temperature.png" alt="Temperatura" height="100"
													width="100">
											</div>
											<div class="card-footer">
												<p class="text-center"><b>Atualização</b>:
													<?php echo $hora_temperatura ?> <a style="text-decoration: none"
														class="link-primary"
														href="./historico.php?nome=<?php echo $nome_temperatura ?>">
														Histórico </a>
												</p>
											</div>
										</div>
									</div>
								</div>

								<!-- Luz -->
								<div class="col-sm-4">
									<div class="card text-black">
										<div class="card text-center">
											<div class="card-header">
												<p class="text-center"><b>
														<?php echo $nome_luz . ": " . $estado_luz ?>
													</b></p>
											</div>
											<div class="card-body">
												<?php

												echo '<form method="post">';


												if ($valor_luz == "0") {
													echo '<input type="hidden" name="luz" value="1">';
													echo '<input type="image" height = "100" width = "100" src="imagens/light-bulb_off.png" alt="Submit">';
												} else if ($valor_luz == "1") {
													echo '<input type="hidden" name="luz" value="2">';
													echo '<input type="image" height = "100" width = "100" src="imagens/light-bulb_dim.png" alt="Submit">';
												} else {
													echo '<input type="hidden" name="luz" value="0">';
													echo '<input type="image" height = "100" width = "100" src="imagens/light-bulb.png" alt="Submit">';
												}

												echo '</form>';

												?>
											</div>


											<div class="card-footer">
												<p class="text-center"><b>Atualização</b>:
													<?php echo $hora_luz ?> <a style="text-decoration: none"
														class="link-primary"
														href="./historico.php?nome=<?php echo $nome_luz ?>">
														Histórico </a>
												</p>
											</div>
										</div>
									</div>
								</div>




								<!-- Segunda linha da tabela -->
								<div class="container" style="padding-top: 10px">
									<div class="row">


									</div>
								</div>
							</div>
						</div>


					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
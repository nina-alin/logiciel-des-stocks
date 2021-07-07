<?php
// Initialiser la session
session_start();
require_once('php/connect.php');
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["username"])) {
	header("Location: login.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Nina Alin">

	<title>Logiciel des stocks</title>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="css/sb-admin.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="css/plugins/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<script>
	function date() {
		var dateCles = document.getElementById('dateCles');
		dateCles.valueAsDate = new Date();
	}

	// GET
	dateCles.onchange = function() {
		console.log("samarche");
		var dateSortie = $(this).attr("data-date");
		$.ajax({
			url: "php/saveDashboard.php",
			method: "GET",
			data: {
				type: 4,
				dateSortie: dateSortie
			},
			success: function(dataResult) {
				$('#produitSortieDate').html(dataResult);
			},
			error: function(request, status, error) {
				alert(request.responseText);
			}
		});
	}

	// DELETE
	$(document).on("click", ".delete", function() {
		var tproduitsstockesPK = $(this).attr("data-id");
		$('#tproduitsstockesPK_d').val(tproduitsstockesPK);
	});

	$(document).on("click", "#delete", function() {
		$.ajax({
			url: "php/saveDashboard.php",
			type: "POST",
			cache: false,
			data: {
				type: 3,
				tproduitsstockesPK: $("#tproduitsstockesPK_d").val()
			},
			success: function(dataResult) {
				$('#myModalAlertDelete').modal('hide');
				$("#" + dataResult).remove();
				alert('Alerte correctement supprimée !');
				document.location.reload();
			},
			error: function(request, status, error) {
				alert(request.responseText);
			}
		});
	});
</script>

<body>
	<div id="wrapper">
		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="dashboard.php">Logiciel des stocks</a>
			</div>
			<!-- /.navbar-header -->

			<ul class="nav navbar-top-links navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-cog"></i> <?php echo $_SESSION["username"] ?> <i class="fa fa-caret-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="/stocks/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
						<li> <a href="/stocks/techniciens.php"><i class="fas fa-wrench"></i>&nbsp;Techniciens</a></li>
						<li> <a href="/stocks/lieuStockage.php"><i class="fas fa-box-open"></i>&nbsp;Lieux de stockage</a></li>
						<li><a href="/stocks/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
						<li><a href="/stocks/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
						<li><a href="/stocks/lieuSortie.php"><i class="fas fa-door-closed"></i>&nbsp;Lieux de sortie</a></li>
						<li><a href="/stocks/emplacements.php"><i class="fas fa-warehouse"></i>&nbsp;Emplacements</a></li>
						<li><a href="/stocks/uniteGestion.php"><i class="fas fa-paper-plane"></i>&nbsp;Unités de gestion</a></li>
						<li class="divider"></li>
						<li><a href="../stocks/php/logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
					</ul>
				</li>
			</ul>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li class="active">
						<a href="dashboard.php"> Dashboard <span class="badge badge-danger" style="background-color:red;">
								<?php
								$result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` WHERE alerte=1 AND quantite<4");
								$i = 0;
								while ($row = mysqli_fetch_array($result)) {
									$i++;
								}
								echo $i;

								?>
							</span>
						</a>
					</li>
					<li>
						<a href="stocks.php">Stocks</a>
					</li>
					<li>
						<a href="sorties.php">Dernières sorties</a>
					</li>
					<li>
						<a href="reforme.php">Réforme</a>
					</li>
					<li>
						<a href="commandes.php">Commandes</a>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

		<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header text-danger">
							Alertes
						</h1>
					</div>
				</div>
			</div>
			<!-- /.row -->

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<div class="panel-body">
								<?php
								$result = mysqli_query($conn, "SELECT * FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK");
								while ($row = mysqli_fetch_array($result)) {
									if ($row["quantite"] < 4 && $row["quantite"] != null && $row["alerte"] == 1) {
								?>
										<div class="col-lg-3">
											<div class="panel">
												<div class="panel-header">
													<button type="button" class="delete close" data-target="#myModalAlertDelete" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>">&times;</button>
												</div>
												<div class="panel-body">
													<h3 class="text-center"><?php echo $row["nomFabricant"] ?>&nbsp;<?php echo $row["nomModele"] ?><br />Reste&nbsp;<?php echo $row["quantite"] ?></h3>
												</div>
											</div>
										</div>
								<?php
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.row -->

			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header text-success">
						Chiffres clés
						<input type="date" id="dateCles" name="dateCles" value="dateCles" onkeyup="date()">
					</h1>
				</div>
			</div>
			<!-- /.row -->

			<div class=" row">
				<div class="col-lg-12">
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-body" id="produitSortieDate">
								<!--<div class="col-lg-3">
									<div class="panel">
										<div class="panel-body">
											<h3 class="text-center">Success</h3>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="panel">
										<div class="panel-body">
											<h3 class="text-center">Success</h3>
										</div>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="panel">
										<div class="panel-body">
											<h3 class="text-center">Success</h3>
										</div>
									</div>
								</div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.row -->

		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

	<!-- The Modal Alerte Delete-->
	<div class="modal fade" id="myModalAlertDelete">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Supprimer une alerte</h4>
					</div>
					<div class="modal-body">
						<input type="hidden" id="tproduitsstockesPK_d" name="tproduitsstockesPK" class="form-control">
						<p>Êtes-vous sûr de vouloir retirer cette alerte ?</p>
						<p class="text-warning"><small>Pour la réactiver, rendez-vous à la page <a href="./stocks.php">stocks</a>.</small></p>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" id="delete">Supprimer</button>
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- jQuery Version 1.11.0 -->
	<script src="js/jquery-1.11.0.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>

	<!-- Rechercher -->
	<script src="js/search.js"></script>
</body>

</html>
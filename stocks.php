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
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

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

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<script>
		// GET
		$(document).on('click', '.view', function(e) {
			var tproduitsstockesPK = $(this).attr("data-id");
			var nomModele = $(this).attr("data-nom");
			var nomFabricant = $(this).attr("data-fabricant");
			document.getElementById("afficherViewNomStocks").innerHTML = "Caractéristiques de " + nomFabricant + " " + nomModele;
			$.ajax({
				url: "php/saveEntrees.php",
				method: "GET",
				data: {
					type: 4,
					tproduitsstockesPK: tproduitsstockesPK
				},
				success: function(dataResult) {
					$('#stocks_details').html(dataResult);
					$('#myModalStocksView').modal('show');
				},
				error: function(request, status, error) {
					alert(request.responseText);
				}
			});
		});

		// POST
		$(document).on('click', '#btn-add', function(e) {
			var data = $("#tentrees_form").serialize();
			console.log(data);
			console.log($("#codeProduit_a").val());
			$.ajax({
				data: {
					codeProduit: $("#codeProduit_a").val(),
					quantiteEntree: $("#quantiteEntree_a").val(),
					tcommandesFK: $("#tcommandesFK_a").val(),
					ttechnicienFK: $("#ttechnicienFK_a").val(),
					type: "1"
				},
				type: "post",
				url: "php/saveEntrees.php",
				success: function(dataResult) {
					console.log(dataResult);
					try {
						var dataResult = JSON.parse(dataResult);
					} catch (e) {
						if (e instanceof SyntaxError) {
							alert("Erreur lors de la requête !", true);
						} else {
							alert("Erreur lors de la requête !", false);
						}
					}
					if (dataResult.statusCode == 200) {
						$('#myModaltentreeAdd').modal('hide');
						alert('Données correctement ajoutées !');
						location.reload();
					} else if (dataResult.statusCode == 201) {
						alert(dataResult);
					}
				},
				error: function(request, status, error) {
					alert(request.responseText);
				}
			});
		});

		$(document).on('click', '.update', function(e) {
			var tproduitsstockesPK = $(this).attr("data-id");
			var tlibellesFK = $(this).attr("data-libelles");
			var alerte = $(this).attr("data-alerte");
			$('#tproduitsstockesPK_u').val(tproduitsstockesPK);
			$('#tlibellesFK_u').val(tlibellesFK);
			$('#alerte_u').val(alerte);
		});

		$(document).ready(function() {
			$('input[type="checkbox"]').click(function() {
				if ($(this).prop("checked") == true) {
					alerte = 1;
				} else if ($(this).prop("checked") == false) {
					alerte = 0;
				}
			});
		});


		$(document).on('click', '#update', function(e) {
			var data = $("#update_form").serialize();
			$.ajax({
				data: {
					tproduitsstockesPK: $("#tproduitsstockesPK_u").val(),
					tlibellesFK: $("#tlibellesFK_u").val(),
					alerte: $("#alerte_u").val(),
					type: "2"
				},
				type: "post",
				url: "php/saveEntrees.php",
				success: function(dataResult) {
					try {
						var dataResult = JSON.parse(dataResult);
					} catch (e) {
						if (e instanceof SyntaxError) {
							alert("Erreur lors de la requête !", true);
						} else {
							alert("Erreur lors de la requête !", false);
						}
					}
					if (dataResult.statusCode == 200) {
						$('#myModalStocksUpdate').modal('hide');
						alert('Données correctement ajoutées !');
						location.reload();
					} else if (dataResult.statusCode == 201) {
						alert(dataResult);
					}
				},
				error: function(request, status, error) {
					alert(request.responseText);
				}
			});
		});

		// SORTIE
		$(document).on('click', '.delete', function(e) {
			var tproduitsstockesPK = $(this).attr("data-id");
			$('#tproduitsstockesPK_s').val(tproduitsstockesPK);
		});

		$(document).on('click', '#btn-sortie', function(e) {
			var data = $("#tsortie_form").serialize();
			$.ajax({
				data: {
					raisonSortie: $("#raisonSortie_s").val(),
					numeroSerie: $("#numeroSerie_s").val(),
					ttechnicienFK: $("#ttechnicienFK_s").val(),
					tlieusortieFK: $("#tlieusortieFK_s").val(),
					quantite: $("#quantite_s").val(),
					tproduitsstockesPK: $("#tproduitsstockesPK_s").val(),
					type: "3"
				},
				type: "post",
				url: "php/saveEntrees.php",
				success: function(dataResult) {
					console.log(dataResult);
					try {
						var dataResult = JSON.parse(dataResult);
					} catch (e) {
						if (e instanceof SyntaxError) {
							alert("Erreur lors de la requête !", true);
						} else {
							alert("Erreur lors de la requête !", false);
						}
					}
					if (dataResult.statusCode == 200) {
						$('#myModalStocksSortie').modal('hide');
						alert('Données correctement ajoutées !');
						location.reload();
					} else if (dataResult.statusCode == 201) {
						alert(dataResult);
					}
				},
				error: function(request, status, error) {
					alert(request.responseText);
				}
			});
		});
	</script>
</head>

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
						<li class="divider"></li>
						<li><a href="../stocks/php/logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
					</ul>
				</li>
			</ul>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li>
						<a href="dashboard.php">Dashboard</a>
					</li>
					<li class="active">
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
					<div class="col-lg-11">
						<h1 class="page-header text-primary">
							Stocks
						</h1>
					</div>
					<br /><br />
					<div class="col-1">
						<button class="btn btn-warning" data-target="#myModaltentreeAdd" data-toggle="modal">
							<i class="fas fa-plus"></i>
						</button>
					</div>
				</div>
				<!-- /.row -->

				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Désignation</th>
										<th>Emplacement</th>
										<th>Quantité</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$result = mysqli_query($conn, "SELECT * FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN tlibelles ON tlibelles.tlibellesPK = tproduitsstockes.tlibellesFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK ORDER BY nomFabricant, nomTypeProduit, nomModele");
									while ($row = mysqli_fetch_array($result)) {
									?>
										<?php if ($row["quantite"] < 3 && $row["quantite"] != null) {  ?>
											<tr tproduitsstockes="<?php echo $row["tproduitsstockesPK"]; ?>" style="background-color: #ffbdbd;">
											<?php } else { ?>
											<tr tproduitsstockes="<?php echo $row["tproduitsstockesPK"]; ?>">
											<?php } ?>
											<td><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></td>
											<td><?php echo $row["nomEmplacement"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLibelle"]; ?></td>
											<td><?php echo $row["quantite"]; ?></td>
											<td>
												<button class="view btn btn-success" data-target="#myModalStocksView" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-nom="<?php echo $row["nomModele"]; ?>" data-fabricant=" <?php echo $row["nomFabricant"]; ?>">
													<i class="far fa-eye"></i>
												</button>&nbsp;
												<button class="update btn btn-primary" data-target="#myModalStocksUpdate" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-libelles="<?php echo $row["tlibellesFK"]; ?>" data-alerte="<?php echo $row["alerte"]; ?>">
													<i class="fas fa-pen"></i>
												</button>&nbsp;
												<button class="delete btn btn-danger" data-target="#myModalStocksSortie" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>">
													<i class="fas fa-door-open"></i>
												</button>
											</td>
											</tr>
										<?php
									}
										?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- /.row -->


			</div>
			<!-- /.container-fluid -->

		</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- The Modal Type Produit view-->
	<div class="modal fade" id="myModalStocksView">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="afficherViewNomStocks"></h4>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<thead>
								<tr>
									<th>Fabricant</th>
									<th>Nom</th>
									<th>Désignation</th>
									<th>Compatibilité</th>
									<th>Code produit</th>
								</tr>
							</thead>
							<tbody id="stocks_details">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal Entree Add-->
	<div class="modal fade" id="myModaltentreeAdd">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Nouvelle entrée</h4>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<form id="tentrees_form">
								<tr>
									<th>Code produit</th>
									<td>
										<input class="form-control" id="codeProduit_a" name="codeProduit_a" value="" placeholder="Code barre du produit" required><b></b>
									</td>
								</tr>
								<tr>
									<th>Quantité</th>
									<td>
										<input type="number" class="form-control" id="quantiteEntree_a" name="quantiteEntree_a" required><b></b>
									</td>
								</tr>
								<tr>
									<th>Numéro de commande</th>
									<td>
										<select class="form-control" id="tcommandesFK_a" name="tcommandesFK_a" value="" required>
											<?php
											$result = mysqli_query($conn, "SELECT * FROM tcommandes");
											while ($row = mysqli_fetch_array($result)) {
											?>
												<option value="<?php echo $row["tcommandesPK"]; ?>"><?php echo $row["numeroCommande"]; ?></option>
											<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Technicien</th>
									<td>
										<select class="form-control" id="ttechnicienFK_a" name="ttechnicienFK_a" value="" required>
											<?php
											$result = mysqli_query($conn, "SELECT * FROM ttechnicien ORDER BY nomTechnicien, prenomTechnicien");
											while ($row = mysqli_fetch_array($result)) {
											?>
												<option value="<?php echo $row["ttechnicienPK"]; ?>"><?php echo $row["prenomTechnicien"]; ?>&nbsp;<?php echo $row["nomTechnicien"]; ?></option>
											<?php
											}
											?>
										</select>
									</td>
								</tr>
							</form>
						</table>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-warning" id="btn-add">Ajouter</button>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal Stocks Update-->
	<div class="modal fade" id="myModalStocksUpdate">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="update_form">
					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modifier un produit stocké</h4>
					</div>
					<!-- Modal body -->
					<div class="modal-body">
						<div id="doubleU" style="display: none;"></div>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
								<tr>
									<th>Emplacement</th>
									<td>
										<select class="form-control" id="tlibellesFK_u" name="tlibellesFK_u" value="" required>
											<?php
											$result = mysqli_query($conn, "SELECT * FROM tlibelles JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK ORDER BY nomEmplacement, nomLibelle");
											while ($row = mysqli_fetch_array($result)) {
											?>
												<option value="<?php echo $row["tlibellesPK"]; ?>"><?php echo $row["nomEmplacement"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLibelle"]; ?></option>
											<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Alerter en cas de stocks bas ?</th>
									<td>
										<input type="checkbox" id="alerte_u" name="alerte_u" value="1" checked>
										<label for="alerte_u">Oui</label>
									</td>
								</tr>
							</table>
							<small>Pour modifier les caractéristiques du produit, rendez-vous dans <a href="caracteristiquesProduits.php">Modèles des produits</a>.</small>
						</div>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<input type="hidden" id="tproduitsstockesPK_u" name="tproduitsstockesPK_u" name="type">
						<button type="submit" class="btn btn-primary" id="update">
							<span class="fas fa-pen"></span> Modifier
						</button>
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- The Modal libellé Delete-->
	<div class="modal fade" id="myModalStocksSortie">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="produitDelete">Sortie d'un produit</h4>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<form id="tsortie_form">
								<tr>
									<th>Raison de la sortie</th>
									<td>
										<input class="form-control" id="raisonSortie_s" name="raisonSortie_s" size="40px" value=""><b></b>
									</td>
								</tr>
								<tr>
									<th>Numéro de série</th>
									<td>
										<input class="form-control" id="numeroSerie_s" name="numeroSerie_s" size="40px" value=""><b></b>
									</td>
								</tr>
								<tr>
									<th>Technicien</th>
									<td>
										<select class="form-control" id="ttechnicienFK_s" name="ttechnicienFK_s" value="" required>
											<?php
											$result = mysqli_query($conn, "SELECT * FROM ttechnicien ORDER BY nomTechnicien, prenomTechnicien");
											while ($row = mysqli_fetch_array($result)) {
											?>
												<option value="<?php echo $row["ttechnicienPK"]; ?>"><?php echo $row["prenomTechnicien"]; ?>&nbsp;<?php echo $row["nomTechnicien"]; ?></option>
											<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Lieu de sortie</th>
									<td>
										<select class="form-control" id="tlieusortieFK_s" name="tlieusortieFK_s" value="" required>
											<?php
											$result = mysqli_query($conn, "SELECT * FROM tlieusortie JOIN tunitegestion ON tlieusortie.tunitegestionFK = tunitegestion.tunitegestionPK ORDER BY nomUniteGestion, nomLieuSortie");
											while ($row = mysqli_fetch_array($result)) {
											?>
												<option value="<?php echo $row["tlieusortiePK"]; ?>"><?php echo $row["nomUniteGestion"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLieuSortie"]; ?></option>
											<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Quantité</th>
									<td>
										<input type="number" class="form-control" id="quantite_s" name="quantite_s" size="40px" value="" required><b></b>
									</td>
								</tr>
							</form>
						</table>
						<!-- Modal footer -->
						<div class="modal-footer">
							<input type="hidden" id="tproduitsstockesPK_s" name="tproduitsstockesPK_s" name="type">
							<button type="submit" class="btn btn-danger" id="btn-sortie">
								<span class="fas fa-door-open"></span> Sortir
							</button>
							<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- jQuery Version 1.11.0 -->
	<script src="js/jquery-1.11.0.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>
</body>

</html>
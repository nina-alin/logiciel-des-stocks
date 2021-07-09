<?php
// Initialiser la session
session_start();
require_once('config/connect.php');
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
		function typeEntreeFunction() {
			if (document.getElementById('typeEntree').value == 1) {
				$.ajax({
					url: "config/saveEntrees.php",
					method: "GET",
					data: {
						type: 5,
					},
					success: function(dataResult) {
						$("#trTypeEntree").html(dataResult);
					}
				});
			} else if (document.getElementById('typeEntree').value == 2) {
				$.ajax({
					url: "config/saveEntrees.php",
					method: "GET",
					data: {
						type: 6,
					},
					success: function(dataResult) {
						$("#trTypeEntree").html(dataResult);
					}
				});
			}
			$("#trQuantite").html('<th>Quantité</th>' +
				'<td><input type="number" class="form-control" id="quantiteEntree_a" name="quantiteEntree_a" min="1" required><b></b></td></tr>');
			$.ajax({
				url: "config/saveEntrees.php",
				method: "GET",
				data: {
					type: 7,
				},
				success: function(dataResult) {
					$("#trTechnicien").html(dataResult);
				}
			});
		}

		// GET
		$(document).on('click', '.view', function(e) {
			var tproduitsstockesPK = $(this).attr("data-id");
			var nomModele = $(this).attr("data-nom");
			var nomFabricant = $(this).attr("data-fabricant");
			document.getElementById("afficherViewNomStocks").innerHTML = "Caractéristiques de " + nomFabricant + " " + nomModele;
			$.ajax({
				url: "config/saveEntrees.php",
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

		$(document).on('click', '.add', function(e) {
			var tproduitsstockesPK = $(this).attr("data-id");
			var nomModele = $(this).attr("data-modele");
			var nomFabricant = $(this).attr("data-fabricant");
			document.getElementById("afficherAddSortie").innerHTML = "Ajouter une entrée pour " + nomFabricant + "&nbsp;" + nomModele;
			$('#tproduitsstockesFK_a').val(tproduitsstockesPK);
		});

		// POST
		$(document).on('click', '#btn-add', function(e) {
			if (document.getElementById('typeEntree').value == 1) {
				$.ajax({
					data: {
						quantiteEntree: $("#quantiteEntree_a").val(),
						tproduitsstockesFK: $("#tproduitsstockesFK_a").val(),
						tcommandesFK: $("#tcommandesFK_a").val(),
						ttechnicienFK: $("#ttechnicienFK_a").val(),
						type: "1"
					},
					type: "post",
					url: "config/saveEntrees.php",
					success: function(dataResult) {
						console.log(dataResult);
						try {
							var dataResult = JSON.parse(dataResult);
						} catch (e) {
							if (e instanceof SyntaxError) {
								alert("Erreur lors de la requête : " + dataResult, true);
							} else {
								alert("Erreur lors de la requête : " + dataResult, false);
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
			} else if (document.getElementById('typeEntree').value == 2) {
				$.ajax({
					data: {
						quantiteEntree: $("#quantiteEntree_a").val(),
						tproduitsstockesFK: $("#tproduitsstockesFK_a").val(),
						ttechnicienFK: $("#ttechnicienFK_a").val(),
						tlieusortieFK: $("#tlieusortieFK_a").val(),
						type: "8"
					},
					type: "post",
					url: "config/saveEntrees.php",
					success: function(dataResult) {
						console.log(dataResult);
						try {
							var dataResult = JSON.parse(dataResult);
						} catch (e) {
							if (e instanceof SyntaxError) {
								alert("Erreur lors de la requête : " + dataResult, true);
							} else {
								alert("Erreur lors de la requête : " + dataResult, false);
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
			}
		});

		// UPDATE
		$(document).on('click', '.update', function(e) {
			var tproduitsstockesPK = $(this).attr("data-id");
			var tlibellesFK = $(this).attr("data-libelles");
			var alerte = $(this).attr("data-alerte");
			$('#tproduitsstockesPK_u').val(tproduitsstockesPK);
			$('#tlibellesFK_u').val(tlibellesFK);
			$('#alerte_u').val(alerte);
		});


		$(document).on('click', '#update', function(e) {
			$.ajax({
				data: {
					type: "2",
					alerte: $('input[name="alerte_u"]:checked').val(),
					tlibellesFK: $("#tlibellesFK_u").val(),
					tproduitsstockesPK: $("#tproduitsstockesPK_u").val(),
				},
				type: "post",
				url: "config/saveEntrees.php",
				success: function(dataResult) {
					console.log(dataResult);
					try {
						var dataResult = JSON.parse(dataResult);
					} catch (e) {
						if (e instanceof SyntaxError) {
							alert("Erreur lors de la requête : " + dataResult, true);
						} else {
							alert("Erreur lors de la requête : " + dataResult, false);
						}
					}
					if (dataResult.statusCode == 200) {
						$('#myModalStocksUpdate').modal('hide');
						alert('Données correctement modifiées !');
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
					quantiteSortie: $("#quantiteSortie_s").val(),
					ttechnicienFK: $("#ttechnicienFK_s").val(),
					tlieusortieFK: $("#tlieusortieFK_s").val(),
					quantite: $("#quantite_s").val(),
					tproduitsstockesPK: $("#tproduitsstockesPK_s").val(),
					type: "3"
				},
				type: "post",
				url: "config/saveEntrees.php",
				success: function(dataResult) {
					console.log(dataResult);
					try {
						var dataResult = JSON.parse(dataResult);
					} catch (e) {
						if (e instanceof SyntaxError) {
							alert("Erreur lors de la requête : " + dataResult, true);
						} else {
							alert("Erreur lors de la requête : " + dataResult, false);
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
				<a class="navbar-brand" href="index.php">Logiciel des stocks</a>
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
					<li>
						<a href="index.php"> Dashboard <span class="badge badge-danger" style="background-color:red;">
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
					<div class="col-lg-9">
						<h1 class="page-header text-primary">
							Stocks
						</h1>
					</div>
					<div class="col-lg-3">
						<br /><br /><br />
						<i class="fas fa-search"></i>&nbsp;&nbsp;<input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Rechercher..">
					</div>
				</div>
				<!-- /.row -->

				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table table-hover" id="myTable">
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
										<?php if ($row["quantite"] < 4 && $row["quantite"] != null && $row["alerte"] == 1) {  ?>
											<tr tproduitsstockes="<?php echo $row["tproduitsstockesPK"]; ?>" style="background-color: #ffbdbd;">
											<?php } else { ?>
											<tr tproduitsstockes="<?php echo $row["tproduitsstockesPK"]; ?>">
											<?php } ?>
											<td><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></td>
											<td><?php echo $row["nomEmplacement"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLibelle"]; ?></td>
											<td><?php echo $row["quantite"]; ?></td>
											<td>
												<button class="add btn btn-warning" data-target="#myModaltentreeAdd" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>">
													<i class="fas fa-plus"></i>
												</button>&nbsp;
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
					<h4 class="modal-title" id="afficherAddSortie"></h4>
				</div>
				<form id="tentrees_form">
					<!-- Modal body -->
					<div class="modal-body">
						<div id="doubleU" style="display: none;"></div>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
								<tr>
									<th>D'où provient le produit ?</th>
									<td>
										<select id="typeEntree" name="typeEntree" class="form-control" onchange="typeEntreeFunction()">
											<option disabled selected value> -- Sélectionnez une option -- </option>
											<option value="1">Une commande</option>
											<option value="2">Une UG</option>
										</select>
									</td>
								</tr>
								<tr id="trTypeEntree"></tr>
								<tr id="trQuantite"></tr>
								<tr id="trTechnicien"></tr>
							</table>
						</div>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<input type="hidden" id="tproduitsstockesFK_a" name="tproduitsstockesFK_a">
						<button type="button" class="btn btn-warning" id="btn-add">Ajouter</button>
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- The Modal libellé Update-->
	<div class="modal fade" id="myModalStocksUpdate">
		<div class="modal-dialog">
			<div class="modal-content">
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
									<select class="form-control" id="tlibellesFK_u" name="tlibellesFK_u" required>
										<?php
										$result = mysqli_query($conn, "SELECT * FROM tlibelles JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK");
										while ($row = mysqli_fetch_array($result)) {
										?>
											<option value="<?php echo $row["tlibellesPK"]; ?>"><?php echo $row["nomEmplacement"]; ?> - <?php echo $row["nomLibelle"]; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Alerter en cas de stocks bas ?</th>
								<td>
									<input type="radio" id="alerte_u_oui" name="alerte_u" value="1">&nbsp;Oui
									<input type="radio" id="alerte_u" name="alerte_u" value="0">&nbsp;Non
								</td>
							</tr>
						</table>
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
										<input class="form-control" id="raisonSortie_s" name="raisonSortie_s" size="40px" placeholder="Champ non obligatoire"><b></b>
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
										<input type="number" class="form-control" id="quantiteSortie_s" name="quantiteSortie_s" min="1" size="40px" value="" required><b></b>
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

	<!-- Rechercher -->
	<script src="js/search.js"></script>
</body>

</html>
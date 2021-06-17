<?php
// On inclut la connexion à la base
require_once('php/connect.php');
?>

<!DOCTYPE html>
<html lang="en">

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

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<script>
	// POST
	$(document).on('click', '#btn-add', function(e) {
		var data = $("#libelle_form").serialize();
		$.ajax({
			data: data,
			type: "post",
			url: "php/saveLibelle.php",
			success: function(dataResult) {
				var dataResult = JSON.parse(dataResult);
				if (dataResult.statusCode == 200) {
					$('#myModalLibelleAdd').modal('hide');
					alert('Data added successfully !');
					location.reload();
				} else if (dataResult.statusCode == 201) {
					alert(dataResult);
				}
			}
		});
	});

	$(document).on('click', '.update', function(e) {
		var templacementsFK = $(this).attr("data-nom-emplacement");
		var nomLibelle = $(this).attr("data-nom-libelle");
		$('#id_u_emplacement').val(templacementsFK);
		$('#nom_u_libelle').val(nomLibelle);
	});

	$(document).on('click', '#update', function(e) {
		var data = $("#update_form").serialize();
		$.ajax({
			data: data,
			type: "post",
			url: "php/saveLibelle.php",
			success: function(dataResult) {
				var dataResult = JSON.parse(dataResult);
				if (dataResult.statusCode == 200) {
					$('#editLibelleModal').modal('hide');
					alert('Data updated successfully !');
					location.reload();
				} else if (dataResult.statusCode == 201) {
					alert(dataResult);
				}
			}
		});
	});


	$(document).on("click", ".delete", function() {
		var tlibellesPK = $(this).attr("data-id");
		$('#tlibellesPK_d').val(tlibellesPK);

	});
	$(document).on("click", "#delete", function() {
		$.ajax({
			url: "php/saveLibelle.php",
			type: "POST",
			cache: false,
			data: {
				type: 3,
				tlibellesPK: $("#tlibellesPK_d").val()
			},
			success: function(dataResult) {
				$('#myModalLibelleDelete').modal('hide');
				$("#" + dataResult).remove();

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
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li>
						<a href="dashboard.php">Dashboard</a>
					</li>
					<li>
						<a href="stocks.php">Stocks</a>
					</li>
					<li class="active">
						<a href="lieuStockage.php">Lieux de stockage</a>
					</li>
					<li>
						<a href="suivi.php">Suivi</a>
					</li>
					<li>
						<a href="reforme.php">Réforme</a>
					</li>
					<li>
						<a href="sorties.php">Dernières sorties</a>
					</li>
					<li>
						<a href="techniciens.php">Techniciens</a>
					</li>
					<li>
						<a href="marques.php">Marques</a>
					</li>
					<li>
						<a href="typesProduits.php">Types de produits</a>
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
							Lieux de stockage
						</h1>
					</div>
					<br /><br />
					<div class="col-1">
						<button class="btn btn-warning" data-target="#myModalLibelleAdd" data-toggle="modal">
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
										<th>Libellé</th>
										<th>Emplacement</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$result = mysqli_query($conn, "SELECT * FROM tlibelles INNER JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK");
									while ($row = mysqli_fetch_array($result)) {
									?>
										<tr tlibellesPK="<?php echo $row["tlibellesPK"]; ?>">
											<td><?php echo $row["nomLibelle"]; ?></td>
											<td><?php echo $row["nomEmplacement"]; ?></td>
											<td>
												<button class="btn btn-success" data-target="#myModalLibelleView" data-toggle="modal">
													<i class="far fa-eye"></i>
												</button>&nbsp;
												<button class="btn btn-primary" data-target="#myModalLibelleUpdate" data-toggle="modal" data-libelle-id=<?php echo $row["tlibellesPK"]; ?> data-nom-libelle=<?php echo $row["nomLibelle"]; ?> data-emplacement-id=<?php echo $row["templacementsPK"]; ?>>
													<i class="fas fa-pen"></i>
												</button>&nbsp;
												<button class="btn btn-danger" data-target="#myModalLibelleDelete" data-toggle="modal" data-id="<?php echo $row["tlibellesPK"]; ?>">
													<i class="fas fa-trash-alt"></i>
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

	<!-- The Modal libellé Add-->
	<div class="modal fade" id="myModalLibelleAdd">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Ajouter un libellé</h4>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<form id="libelle_form">
								<tr>
									<th>Emplacement</th>
									<td>
										<select class="form-control" id="nomEmplacement" name="nomEmplacement" value="" required>
											<?php
											$result = mysqli_query($conn, "SELECT * FROM templacements");
											while ($row = mysqli_fetch_array($result)) {
											?>
												<option value="<?php echo $row["templacementsPK"]; ?>"><?php echo $row["nomEmplacement"]; ?></option>
											<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th>Nom</th>
									<td><input class="form-control" id="nomLibelle" name="nomLibelle" size="40px" value="" required><b></b></td>
								</tr>
							</form>
						</table>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" value="1" name="type">
					<button type="submit" class="btn btn-warning" id="btn-add">
						<span class="fas fa-plus"></span> Ajouter
					</button>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal libellé view-->
	<div class="modal fade" id="myModalLibelleView">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Liste des produits dans </h4>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<thead>
								<tr>
									<th>Nom du produit</th>
									<th>Marque</th>
									<th>Numéro de série</th>
									<th>Compatibilité</th>
									<th>Code produit</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$result = mysqli_query($conn, "SELECT * FROM tproduitsstockes JOIN tlibelles ON tproduitsstockes.tlibellesFK = tlibelles.tlibellesPK");
								while ($row = mysqli_fetch_array($result)) {
								?>
									<tr tlibellesPK="<?php echo $row["tproduitsPK"]; ?>">
										<td><?php echo $row["nomModele"]; ?></td>
										<td><?php echo $row["codeProduit"]; ?></td>
										<td>
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
		</div>
	</div>

	<!-- The Modal libellé Update-->
	<div class="modal fade" id="myModalLibelleUpdate">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modifier un libellé</h4>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<tr>
								<th>Emplacement</th>
								<td>
									<select>
										<?php
										$result = mysqli_query($conn, "SELECT * FROM templacements");
										while ($row = mysqli_fetch_array($result)) {
										?>
											<option value="<?php echo $row["templacementsPK"]; ?>"><?php echo $row["nomEmplacement"]; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Nom</th>
								<td><input class="form-control" id="nom_u_libelle" name="nom" size="40px" value="" required><b></b></td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" value="2" name="type">
					<button type="submit" class="btn btn-primary" id="update">
						<span class="fas fa-pen"></span> Modifier
					</button>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal libellé Delete-->
	<div class="modal fade" id="myModalLibelleDelete">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="libelleDelete">Supprimer un libellé</h4>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<input type="hidden" id="tlibellesPK_d" name="tlibellesPK" name="type">
						<button type="submit" class="btn btn-danger" id="delete">
							<span class="fas fa-trash"></span> Supprimer
						</button>
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

	<!-- Morris Charts JavaScript -->
	<script src="js/plugins/morris/raphael.min.js"></script>
	<script src="js/plugins/morris/morris.min.js"></script>
	<script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
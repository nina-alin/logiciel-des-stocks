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

	<!--Calendar script-->
	<script src="js/jsSimpleDatePickr.2.1.js"></script>


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<script>
		// quelques variables globales
		var theProductSelected;
		var tProduitPK;

		$(function() {

			// on récupère la liste des produits
			$.ajax({
				type: "GET",
				url: "php/readtProduit.php",
				success: function(response) {
					loadProduit();
				},
				error: function(resultat, statut, erreur) {},
			});



			// Si on veut modifier les données d'un produit
			$(document).on('click', "#produitUpdate", function(event) {
				tProduitPK = $(this).attr("ident");
				loadProduit(tProduitPK);
			});

			// on met à jour un produit
			$(document).on('click', "#updateProduit", function() {
				tTypeProduitFK = $("#tTypeProduitFK").val();
				nomProduit = $("#nomProduit").val();
				compatibilite = $("#compatibilite").val();
				codeProduit = $("#codeProduit").val();
				marque = $("#marque").val();
				quantiteTotale = $("#quantiteTotale").val();
				var produitInfo = {
					"id": tProduitPK,
					"nomProduit": nomProduit,
					"compatibilite": compatibilite,
					"codeProduit": codeProduit,
					"marque": marque,
					"quantiteTotale": quantiteTotale
				};
				$.ajax({
					type: "POST",
					url: "php/updatetProduit.php",
					data: JSON.stringify(produitInfo),
					success: function(response) {
						loadProduit();
						alert(response.message);
					},
					error: function(resultat, statut, erreur) {},
				});
			});

			// Si on veut supprimer un libellé
			$(document).on('click', "#produitDelete", function(event) {
				tProduitPK = $(this).attr("ident"); // lors d'un clic sur la poubelle
			});


			$(document).on('click', "#deleteProduit", function(event) {
				var produitInfo = {
					"tProduitPK": tProduitPK, // récupéré lors du clic sur la poubelle
				};
				$.ajax({
					type: "DELETE",
					url: "php/deletetProduit.php",
					data: JSON.stringify(produitInfo),
					success: function(response) {
						loadProduit();
						alert(response.message);
					},
					error: function(resultat, statut, erreur) {},
				});
			});

		});

		function loadProduit() {
			$.ajax({
				type: "GET",
				url: "php/readtProduit.php",
				success: produitSuccess,
				error: function(resultat, statut, erreur) {},
				complete: function(resultat, statut) {}
			});
		}


		function produitSuccess(jsonDatas) {
			var dropDownList = "";
			$.each(jsonDatas, function(key1, value1) {
				$.each(value1, function(key2, value2) {
					if (key2 == "codeProduit")
						codeProduit = value2;
					if (key2 == "nomTypeProduit")
						nomTypeProduit = value2;
					if (key2 == "marque")
						marque = value2;
					if (key2 == "nomProduit")
						nomProduit = value2;
					if (key2 == "quantiteTotale")
						dropDownList += '<tr><td>' + codeProduit + '</td><td></td><td>' + marque + '</td><td>' + nomProduit + '</td><td>' + value2 + '</td><td><button class="btn btn-primary" data-target="#myModalProductUpdate" data-toggle="modal"><i class="fas fa-pen"></i></button>&nbsp;<button class="btn btn-danger" data-target="#myModalProductDelete" data-toggle="modal"><i class="fas fa-trash-alt"></i></button></td></tr>';
				});
			});
			$("#produitList").html(dropDownList);
		}
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
							Stocks
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
										<th>Code produit</th>
										<th>Catégorie</th>
										<th>Marque</th>
										<th>Désignation</th>
										<th>Emplacement</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="produitList">
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

	<!-- The Modal libellé Update-->
	<div class="modal fade" id="myModalProductUpdate">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Modifier un produit</h4>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<tr>
								<th>Code produit</th>
								<td>
									<input class="form-control" id="codeProduit" name="codeProduit" size="40px" value="" required><b></b>
								</td>
							</tr>
							<tr>
								<th>Catégorie</th>
								<td>
									<select name="emplacements" id="emplacementList">
									</select>
								</td>
							</tr>
							<tr>
								<th>Marque</th>
								<td><input class="form-control" id="marque" name="marque" size="40px" value="" required><b></b></td>
							</tr>
							<tr>
								<th>Désignation</th>
								<td><input class="form-control" id="designation" name="designation" size="40px" value="" required><b></b></td>
							</tr>
							<tr>
								<th>Quantité</th>
								<td><input class="form-control" id="quantite" name="quantite" size="40px" value="" required><b></b></td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="updateLibelle">
						<span class="fas fa-pen"></span> Modifier
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal libellé Delete-->
	<div class="modal fade" id="myModalProductDelete">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="produitDelete">Supprimer un produit</h4>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger" id="deleteProduit">
						<span class="fas fa-trash"></span> Supprimer
					</button>
				</div>
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
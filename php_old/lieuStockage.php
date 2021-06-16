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
	<script>
		// quelques variables globales
		var theLibelleSelected;
		var tLibellePK;
		var tEmplacementPK;

		$(function() {

			/*************************************************************************/
			/***************** PARTIE LIBELLE **********************/
			/*************************************************************************/


			// on récupère la liste des libellé
			$.ajax({
				type: "GET",
				url: "php/readtLibelleAndEmplacement.php",
				success: function(response) {
					loadLibelle();
				},
				error: function(resultat, statut, erreur) {},
			});


			tLibellePK = ($(this).attr("ident")); // id du Libellé

			$.ajax({
				type: "GET",
				url: "php/readProduitsByLibelle.php",
				data: {
					"tLibellePK": tLibellePK
				},
				success: libelleProductSuccess,
				error: function(resultat, statut, erreur) {},
				complete: function(resultat, statut) {}
			});

			// Si on veut modifier les données d'un libellé
			$(document).on('click', "#libelleUpdate", function(event) {
				tLibellePK = $(this).attr("ident");
				loadLibelle(tLibellePK);
			});

			// on met à jour un libellé
			$(document).on('click', "#updateLibelle", function() {
				nom = $("#nomUpdate").val();
				tEmplacementFK = $("#tEmplacementFKUpdate").val();
				var libelleInfo = {
					"id": tLibellePK,
					"nom": nom,
					"tEmplacementFK": tEmplacementFK
				};

				$.ajax({
					type: "POST",
					url: "php/updatetLibelle.php",
					data: JSON.stringify(libelleInfo),
					success: function(response) {
						loadLibelle();
						alert(response.message);
					},
					error: function(resultat, statut, erreur) {},
				});
			});

			// Si on veut supprimer un libellé
			$(document).on('click', "#libelleDelete", function(event) {
				tLibellePK = $(this).attr("ident"); // lors d'un clic sur la poubelle
			});


			$(document).on('click', "#deleteLibelle", function(event) {
				var libelleInfo = {
					"tLibellePK": tLibellePK, // récupéré lors du clic sur la poubelle
				};
				$.ajax({
					type: "POST",
					url: "php/deletetLibelle.php",
					data: JSON.stringify(libelleInfo),
					success: function(response) {
						loadLibelle();
						alert(response.message);
					},
					error: function(resultat, statut, erreur) {},
				});
			});


			/*************************************************************************/
			/***************** PARTIE EMPLACEMENT **********************/
			/*************************************************************************/

			// on récupère la liste des emplacements
			$.ajax({
				type: "POST",
				url: "php/readtEmplacement.php",
				success: function(response) {
					loadEmplacement();
				},
				error: function(resultat, statut, erreur) {},
			});

		});

		function loadLibelle() {
			$.ajax({
				type: "GET",
				url: "php/readtLibelleAndEmplacement.php",
				success: libelleSuccess,
				error: function(resultat, statut, erreur) {},
				complete: function(resultat, statut) {}
			});
		}

		function loadEmplacement() {
			$.ajax({
				type: "GET",
				url: "php/readtEmplacement.php",
				success: emplacementSuccess,
				error: function(resultat, statut, erreur) {},
				complete: function(resultat, statut) {}
			});
		}

		function libelleSuccess(jsonDatas) {
			var dropDownList = "";
			$.each(jsonDatas, function(key1, value1) {
				$.each(value1, function(key2, value2) {
					if (key2 == "tLibellePK")
						tLibellePK = value2;
					if (key2 == "nom")
						nom = value2;
					if (key2 == "nomEmplacement")
						dropDownList += '<tr><td>' + nom + '</td><td>' + value2 + '</td><td><button class="btn btn-success" data-target="#myModalLibelleView" data-toggle="modal"><i class="far fa-eye"></i></button>&nbsp;<button class="btn btn-primary" data-target="#myModalLibelleUpdate" data-toggle="modal"><i class="fas fa-pen"></i></button>&nbsp;<button class="btn btn-danger" data-target="#myModalLibelleDelete" data-toggle="modal"><i class="fas fa-trash-alt"></i></button></td></tr>';
				});
			});
			$("#libelleList").html(dropDownList);
		}

		function emplacementSuccess(jsonDatas) {
			var dropDownList = "";
			$.each(jsonDatas, function(key1, value1) {
				$.each(value1, function(key2, value2) {
					if (key2 == "tEmplacementPK")
						tEmplacementPK = value2;
					if (key2 == "nomEmplacement") // on mémorise le nom de l'emplacement
						dropDownList += '<option value=' + tEmplacementPK + '><a ident=' + tEmplacementPK + '>' + value2 + '</a></option>';
				});
			});

			$("#emplacementList").html(dropDownList);
		}

		function libelleProductSuccess(jsonDatas) {
			var dropDownList = "";
			$.each(jsonDatas, function(key1, value1) {
				$.each(value1, function(key2, value2) {
					if (key2 == "tLibelleFK")
						tLibelleFK = value2;
					if (key2 == "nomProduit")
						nomProduit = value2;
					if (key2 == "numeroSerie")
						numeroSerie = value2;
					if (key2 == "compatibilite")
						compatibilite = value2;
					if (key2 == "codeProduit")
						codeProduit = value2;
					if (key2 == "marque")
						dropDownList += '<tr><td>' + nomProduit + '</td><td>' + value2 + '</td><td>' + numeroSerie + '</td><td>' + compatibilite + '</td><td>' + codeProduit + '</td></tr>';
				});
			});
			$("#productByLibelleView").html(dropDownList);
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
				<a class="navbar-brand" href="dashboard.php">Stocks</a>
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
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

		<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-10">
						<h1 class="page-header text-primary">
							Lieux de stockage
						</h1>
					</div>
					<br /><br />
					<div class="col-2">
						<button class="btn btn-secondary" data-target="#myModalLibelleAdd" data-toggle="modal">
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
								<tbody id="libelleList">
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

	<!-- The Modal libellé view-->
	<div class="modal fade" id="myModalLibelleView">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Liste des produits</h4>
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
							<tbody id="productByLibelleView">
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
									<select name="emplacements" id="emplacementList">
									</select>
								</td>
							</tr>
							<tr>
								<th>Nom</th>
								<td><input class="form-control" id="nomUpdate" name="nom" size="40px" value="" required><b></b></td>
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
	<div class="modal fade" id="myModalLibelleDelete">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="libelleDelete">Supprimer un libellé</h4>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-danger" id="deleteLibelle">
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
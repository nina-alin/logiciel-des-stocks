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
    <meta name="description" content="Liste des types de produit">
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
    // GET
    $(document).on('click', '.view', function(e) {
        var ttypeproduitsPK = $(this).attr("data-id");
        var nomTypeProduit = $(this).attr("data-nom");
        document.getElementById("afficherNomTypeProduit").innerHTML = "Liste des produits de type " + nomTypeProduit;

        $.ajax({
            type: "GET",
            data: {
                type: 4,
                ttypeproduitsPK: ttypeproduitsPK
            },
            url: "php/saveTypeProduits.php",
            success: function(resultat) {},
            error: function(request, status, error) {
                alert(request.responseText);
            },
            complete: function(resultat, statut) {}
        });
    });

    // POST
    $(document).on('click', '#btn-add', function(e) {
        var data = $("#caracteristiquesProduits_form").serialize();
        $.ajax({
            data: {
                nomModele: $("#nomModele_a").val(),
                compatibilite: $("#compatibilite_a").val(),
                ttypeproduitsFK: $("#ttypeproduitsFK_a").val(),
                tfabricantsFK: $("#tfabricantsFK_a").val(),
                tlibellesFK: $("#tlibellesFK_a").val(),
                type: "1"
            },
            type: "post",
            url: "php/saveCaracteristiquesProduits.php",
            success: function(dataResult) {
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
                    $('#myModalLibelleAdd').modal('hide');
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

    // UPDATE
    $(document).on('click', '.update', function(e) {
        var tcaracteristiquesproduitsPK = $(this).attr("data-id");
        var tfabricantsFK = $(this).attr("data-id-fabricant");
        var ttypeproduitsFK = $(this).attr("data-id-typeproduit");
        var compatibilite = $(this).attr("data-compatibilite");
        var nomModele = $(this).attr("data-nom-modele");

        var nomFabricant = $(this).attr("data-nom-fabricant");


        document.getElementById("afficherUpdateCaracteristiquesProduits").innerHTML = "Modifier " + nomFabricant + "&nbsp;" + nomModele;

        $('#tcaracteristiquesproduitsPK_u').val(tcaracteristiquesproduitsPK);
        $('#tfabricantsFK_u').val(tfabricantsFK);
        $('#nomModele_u').val(nomModele);
        $('#ttypeproduitsFK_u').val(ttypeproduitsFK);
        $('#compatibilite_u').val(compatibilite);
    });

    $(document).on('click', '#update', function(e) {
        var data = $("#update_form").serialize();
        $.ajax({
            data: {
                type: 2,
                tcaracteristiquesproduitsPK: $("#tcaracteristiquesproduitsPK_u").val(),
                tfabricantsFK: $("#tfabricantsFK_u").val(),
                nomModele: $("#nomModele_u").val(),
                ttypeproduitsFK: $("#ttypeproduitsFK_u").val(),
                compatibilite: $("#compatibilite_u").val(),
            },
            type: "post",
            url: "php/saveCaracteristiquesProduits.php",
            success: function(dataResult) {
                try {
                    var dataResult = JSON.parse(dataResult);
                } catch (e) {
                    if (e instanceof SyntaxError) {
                        alert(dataResult, true);
                    } else {
                        alert(dataResult, false);
                    }
                }
                if (dataResult.statusCode == 200) {
                    $('#myModalCaracteristiquesProduitsUpdate').modal('hide');
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

    // DELETE
    $(document).on("click", ".delete", function() {
        var tcaracteristiquesproduitsPK = $(this).attr("data-id");
        $('#tcaracteristiquesproduitsPK_d').val(tcaracteristiquesproduitsPK);
    });

    $(document).on("click", "#delete", function() {
        $.ajax({
            url: "php/saveCaracteristiquesProduits.php",
            type: "POST",
            cache: false,
            data: {
                type: 3,
                tcaracteristiquesproduitsPK: $("#tcaracteristiquesproduitsPK_d").val()
            },
            success: function(dataResult) {
                $('#myModalCaracteristiquesProduitsDelete').modal('hide');
                $("#" + dataResult).remove();
                alert('Données correctement supprimées !');
                location.reload();
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
                        <li class="active"><a href="/stocks/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
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
                    <div class="col-lg-8">
                        <h1 class="page-header text-primary">
                            Modèles des produits
                        </h1>
                    </div>
                    <div class="col-lg-3">
                        <br /><br /><br />
                        <i class="fas fa-search"></i>&nbsp;&nbsp;<input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Rechercher..">
                    </div>
                    <br /><br /><br />
                    <div class="col-1">
                        <button class="btn btn-warning" data-target="#myModalCaracteristiqueProduitAdd" data-toggle="modal">
                            <i class="fas fa-plus"></i>
                        </button>
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
                                        <th>Type de produit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM tcaracteristiquesproduits JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK ORDER BY nomFabricant, nomTypeProduit, nomModele");
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr ttcaracteristiquesproduitsPK="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>">
                                            <td><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></td>
                                            <td><?php echo $row["nomTypeProduit"]; ?></td>
                                            <td>
                                                <button class="view btn btn-success" data-target="#myModalMarquesView" data-toggle="modal" data-id="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>" data-nom-fabricant="<?php echo $row["nomFabricant"]; ?>">
                                                    <i class="far fa-eye"></i>
                                                </button>&nbsp;
                                                <button class="update btn btn-primary" data-target="#myModalCaracteristiquesProduitsUpdate" data-toggle="modal" data-id="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>" data-id-fabricant="<?php echo $row["tfabricantsFK"]; ?>" data-nom-fabricant="<?php echo $row["nomFabricant"]; ?>" data-nom-modele="<?php echo $row["nomModele"]; ?>" data-id-typeproduit="<?php echo $row["ttypeproduitsFK"]; ?>" data-compatibilite="<?php echo $row["compatibilite"]; ?>">
                                                    <i class="fas fa-pen"></i>
                                                </button>&nbsp;
                                                <button class="delete btn btn-danger" data-target="#myModalCaracteristiquesProduitsDelete" data-toggle="modal" data-id="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>">
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

    <!-- The Modal Type Produit Add-->
    <div class="modal fade" id="myModalCaracteristiqueProduitAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ajouter un produit</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <form id="caracteristiquesProduits_form">
                                <tr>
                                    <th>Fabricant</th>
                                    <td>
                                        <select class="form-control" id="tfabricantsFK_a" name="tfabricantsFK_a" value="" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tfabricants");
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <option value="<?php echo $row["tfabricantsPK"]; ?>"><?php echo $row["nomFabricant"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nom</th>
                                    <td>
                                        <input class="form-control" id="nomModele_a" name="nomModele_a" size="40px" value="" required><b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Désignation</th>
                                    <td>
                                        <select class="form-control" id="ttypeproduitsFK_a" name="ttypeproduitsFK_a" value="" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM ttypeproduits");
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <option value="<?php echo $row["ttypeproduitsPK"]; ?>"><?php echo $row["nomTypeProduit"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Compatibilite</th>
                                    <td>
                                        <input class="form-control" id="compatibilite_a" name="compatibilite_a" size="40px" value=""><b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Futur lieu de stockage</th>
                                    <td>
                                        <select class="form-control" id="tlibellesFK_a" name="tlibellesFK_a" value="" required>
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
                            </form>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" value="1" name="type">
                    <button type="button" class="btn btn-warning" id="btn-add">Ajouter</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal Type Produit view-->
    <div class="modal fade" id="myModalTypeProduitView">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="afficherNomTypeProduit"></h4>
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
                                    <th>Lieu de stockage</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal Caracteristique Produit Update-->
    <div class="modal fade" id="myModalCaracteristiquesProduitsUpdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update_form">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="afficherUpdateCaracteristiquesProduits"></h4>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="doubleU" style="display: none;"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <tr>
                                    <th>Fabricant</th>
                                    <td>
                                        <select class="form-control" id="tfabricantsFK_u" name="tfabricantsFK_u" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tfabricants");
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <option value="<?php echo $row["tfabricantsPK"]; ?>"><?php echo $row["nomFabricant"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nom du modèle</th>
                                    <td><input class="form-control" id="nomModele_u" name="nomModele_u" size="40px" value="<?php echo '$nomModele'; ?>" required><b></b></td>
                                </tr>
                                <tr>
                                    <th>Type de produit</th>
                                    <td>
                                        <select class="form-control" id="ttypeproduitsFK_u" name="ttypeproduitsFK_u" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM ttypeproduits");
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <option value="<?php echo $row["ttypeproduitsPK"]; ?>"><?php echo $row["nomTypeProduit"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Compatibilité</th>
                                    <td><input class="form-control" id="compatibilite_u" name="compatibilite_u" size="40px" value="<?php echo '$compatibilite'; ?>" required><b></b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="hidden" id="tcaracteristiquesproduitsPK_u" name="tcaracteristiquesproduitsPK_u" name="type">
                        <button type="submit" class="btn btn-primary" id="update">
                            <span class="fas fa-pen"></span> Modifier
                        </button>
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                    </div>
                </form>
            </div>
        </div>

        <!-- The Modal Type Produit Delete-->
        <div class="modal fade" id="myModalCaracteristiquesProduitsDelete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form>
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Supprimer un type de produits</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="ttypeproduitsPK_d" name="ttypeproduitsPK" class="form-control">
                            <p>Êtes-vous sûr de vouloir supprimer ce type de produits ?</p>
                            <p class="text-warning"><small>Cette action ne peut pas être annulée.</small></p>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="delete">Supprimer</button>
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>

        <!-- jQuery Version 1.11.0 -->
        <script src="js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Rechercher -->
        <script src="js/search.js"></script>
</body>

</html>
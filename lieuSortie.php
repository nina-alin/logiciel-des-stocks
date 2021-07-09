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
        var tlieusortiePK = $(this).attr("data-id");
        var nomLieuSortie = $(this).attr("data-nom-lieu");
        document.getElementById("afficherViewNomLieuSortie").innerHTML = "Liste des produits sortis dans " + nomLieuSortie;
        $.ajax({
            url: "config/saveLieuSortie.php",
            method: "GET",
            data: {
                type: 4,
                tlieusortiePK: tlieusortiePK
            },
            success: function(dataResult) {
                $('#lieuSortie_details').html(dataResult);
                $('#myModalLieuSortieView').modal('show');
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });

    // POST
    $(document).on('click', '#btn-add', function(e) {
        var data = $("#lieuSortie_form").serialize();
        $.ajax({
            data: {
                nomLieuSortie: $("#nomLieuSortie_a").val(),
                tunitegestionFK: $("#tunitegestionFK_a").val(),
                type: "1"
            },
            type: "post",
            url: "config/saveLieuSortie.php",
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
                    $('#myModalLieuSortieAdd').modal('hide');
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
        var tlieusortiePK = $(this).attr("data-id");
        var nomLieuSortie = $(this).attr("data-nom-lieu");
        var tunitegestionFK = $(this).attr("data-ug-id");
        document.getElementById("afficherUpdateNomLieuSortie").innerHTML = "Modifier le lieu de sortie " + nomLieuSortie;
        $('#tlieusortiePK_u').val(tlieusortiePK);
        $('#nomLieuSortie_u').val(nomLieuSortie);
        $('#tunitegestionFK_u').val(tunitegestionFK);
    });

    $(document).on('click', '#update', function(e) {
        var data = $("#update_form").serialize();
        $.ajax({
            data: {
                tlieusortiePK: $("#tlieusortiePK_u").val(),
                nomLieuSortie: $("#nomLieuSortie_u").val(),
                tunitegestionFK: $("#tunitegestionFK_u").val(),
                type: "2"
            },
            type: "post",
            url: "config/saveLieuSortie.php",
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
                    $('#myModalLieuSortieUpdate').modal('hide');
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


    $(document).on("click", ".delete", function() {
        var tlieusortiePK = $(this).attr("data-id");
        $('#tlieusortiePK_d').val(tlieusortiePK);
    });

    $(document).on("click", "#delete", function() {
        $.ajax({
            url: "config/saveLieuSortie.php",
            type: "POST",
            cache: false,
            data: {
                type: 3,
                tlieusortiePK: $("#tlieusortiePK_d").val()
            },
            success: function(dataResult) {
                $('#myModalLieuSortieDelete').modal('hide');
                $("#" + dataResult).remove();
                alert('Données correctement supprimées !');
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
                        <li><a href="/stocks/lieuStockage.php"><i class="fas fa-box-open"></i>&nbsp;Lieux de stockage</a></li>
                        <li><a href="/stocks/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
                        <li><a href="/stocks/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
                        <li class="active"> <a href="/stocks/lieuSortie.php"><i class="fas fa-door-closed"></i>&nbsp;Lieux de sortie</a></li>
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
                            Lieux de sortie
                        </h1>
                    </div>
                    <div class="col-lg-3">
                        <br /><br /><br />
                        <i class="fas fa-search"></i>&nbsp;&nbsp;<input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Rechercher..">
                    </div>
                    <br /><br /><br />
                    <div class="col-1">
                        <button class="btn btn-warning" data-target="#myModalLieuSortieAdd" data-toggle="modal">
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
                                        <th>Lieu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM tlieusortie INNER JOIN tunitegestion ON tlieusortie.tunitegestionFK = tunitegestion.tunitegestionPK ORDER BY nomUniteGestion, nomLieuSortie");
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr tlieusortiePK="<?php echo $row["tlieusortiePK"]; ?>">
                                            <td><?php echo $row["nomUniteGestion"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLieuSortie"]; ?></td>
                                            <td>
                                                <button class="view btn btn-success" data-target="#myModalLieuSortieView" data-toggle="modal" data-id="<?php echo $row["tlieusortiePK"]; ?>" data-nom-lieu="<?php echo $row["nomLieuSortie"]; ?>" data-nom-ug="<?php echo $row["nomUniteGestion"]; ?>">
                                                    <i class="far fa-eye"></i>
                                                </button>&nbsp;
                                                <button class="update btn btn-primary" data-target="#myModalLieuSortieUpdate" data-toggle="modal" data-id=<?php echo $row["tlieusortiePK"]; ?> data-nom-lieu=<?php echo $row["nomLieuSortie"]; ?> data-ug-id=<?php echo $row["tunitegestionFK"]; ?>>
                                                    <i class="fas fa-pen"></i>
                                                </button>&nbsp;
                                                <button class="delete btn btn-danger" data-target="#myModalLieuSortieDelete" data-toggle="modal" data-id="<?php echo $row["tlieusortiePK"]; ?>">
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
    <div class="modal fade" id="myModalLieuSortieAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ajouter un lieu de sortie</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <form id="lieuSortie_form">
                                <tr>
                                    <th>Unité de gestion</th>
                                    <td>
                                        <select class="form-control" id="tunitegestionFK_a" name="tunitegestionFK_a" value="" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tunitegestion");
                                            while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                                <option value="<?php echo $row["tunitegestionPK"]; ?>"><?php echo $row["nomUniteGestion"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nom</th>
                                    <td><input class="form-control" id="nomLieuSortie_a" name="nomLieuSortie_a" size="40px" value="" required><b></b></td>
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
    <div class="modal fade" id="myModalLieuSortieView">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="afficherViewNomLieuSortie"></h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Désignation</th>
                                    <th>Type de produit</th>
                                    <th>Raison de sortie</th>
                                    <th>Quantité</th>
                                    <th>Technicien</th>
                                </tr>
                            </thead>
                            <tbody id="lieuSortie_details">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal libellé Update-->
    <div class="modal fade" id="myModalLieuSortieUpdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="afficherUpdateNomLieuSortie"></h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Unité de gestion</th>
                                <td>
                                    <select class="form-control" id="tunitegestionFK_u" name="tunitegestionFK_u" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tunitegestion");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tunitegestionPK"]; ?>"><?php echo $row["nomUniteGestion"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Nom</th>
                                <td><input class="form-control" id="nomLieuSortie_u" name="nom" size="40px" value="<?php echo '$nomUniteGestion'; ?>" required><b></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="tlieusortiePK_u" name="tlieusortiePK_u" name="type">
                    <button type="submit" class="btn btn-primary" id="update">
                        <span class="fas fa-pen"></span> Modifier
                    </button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal libellé Delete-->
    <div class="modal fade" id="myModalLieuSortieDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Supprimer un lieu de sortie</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="tlieusortiePK_d" name="tlieusortiePK" class="form-control">
                        <p>Êtes-vous sûr de vouloir supprimer ce lieu de sortie ?</p>
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
    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Rechercher -->
    <script src="js/search.js"></script>
</body>

</html>
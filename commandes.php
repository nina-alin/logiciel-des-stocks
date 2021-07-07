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
        var tcommandesPK = $(this).attr("data-id");
        var numeroCommande = $(this).attr("data-numero");
        document.getElementById("afficherViewNumeroCommande").innerHTML = "Produits de la commande n°" + numeroCommande;
        $.ajax({
            url: "php/saveCommande.php",
            method: "GET",
            data: {
                type: 4,
                tcommandesPK: tcommandesPK
            },
            success: function(dataResult) {
                $('#produitsCommandeList').html(dataResult);
                $('#myModalCommandeView').modal('show');
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });

    // POST
    $(document).on('click', '#btn-add', function(e) {
        var data = $("#commande_form").serialize();
        $.ajax({
            data: {
                numeroCommande: $("#numeroCommande_a").val(),
                dateCommande: $("#dateCommande_a").val(),
                arrivee: $('input[name="arrivee_a"]:checked').val(),
                type: "1"
            },
            type: "post",
            url: "php/saveCommande.php",
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
                    $('#myModalCommandeAdd').modal('hide');
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
        var tcommandesPK = $(this).attr("data-id");
        var numeroCommande = $(this).attr("data-numero");
        var dateCommande = $(this).attr("data-date");
        var arrivee = $(this).attr("data-arrivee");
        document.getElementById("afficherUpdateNumeroCommande").innerHTML = "Modifier la commande n°" + numeroCommande;
        $('#tcommandesPK_u').val(tcommandesPK);
        $('#numeroCommande_u').val(numeroCommande);
        $('#dateCommande_u').val(dateCommande);
        $('input[name="arrivee_u"]:checked').val(arrivee);
    });

    $(document).on('click', '#update', function(e) {
        var data = $("#update_form").serialize();
        $.ajax({
            data: {
                tcommandesPK: $("#tcommandesPK_u").val(),
                numeroCommande: $("#numeroCommande_u").val(),
                dateCommande: $("#dateCommande_u").val(),
                arrivee: $('input[name="arrivee_u"]:checked').val(),
                type: "2"
            },
            type: "post",
            url: "php/saveCommande.php",
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
                    console.log(dataResult);
                    $('#myModalCommandeUpdate').modal('hide');
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
        var tcommandesPK = $(this).attr("data-id");
        $('#tcommandesPK_d').val(tcommandesPK);
    });

    $(document).on("click", "#delete", function() {
        $.ajax({
            url: "php/saveCommande.php",
            type: "POST",
            cache: false,
            data: {
                type: 3,
                tcommandesPK: $("#tcommandesPK_d").val()
            },
            success: function(dataResult) {
                $('#myModalCommandeDelete').modal('hide');
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
                    <li class="active">
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
                            Commandes
                        </h1>
                    </div>
                    <br /><br />
                    <div class="col-1">
                        <button class="btn btn-warning" data-target="#myModalCommandeAdd" data-toggle="modal">
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
                                        <th>Numéro de commande</th>
                                        <th>Date</th>
                                        <th>La commande est-elle arrivée ?</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM tcommandes ORDER BY dateCommande DESC");
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr tcommandesPK="<?php echo $row["tcommandesPK"]; ?>">
                                            <td><?php echo $row["numeroCommande"]; ?></td>
                                            <td><?php setlocale(LC_TIME, "fr_FR", "French");
                                                echo strftime("%d/%m/%G", strtotime($row["dateCommande"]));
                                                ?></td>
                                            <td><?php if ($row["arrivee"] == 1) { ?>
                                                    Oui
                                                <?php } else if ($row["arrivee"] == 0) { ?>
                                                    Non
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <?php if ($row["arrivee"] == 1) { ?>
                                                    <button class="view btn btn-success" data-target="#myModalCommandeView" data-toggle="modal" data-id="<?php echo $row["tcommandesPK"]; ?>" data-numero="<?php echo $row["numeroCommande"]; ?>">
                                                        <i class="far fa-eye"></i>
                                                    </button>&nbsp;
                                                <?php } ?>
                                                <button class="update btn btn-primary" data-target="#myModalCommandeUpdate" data-toggle="modal" data-id="<?php echo $row["tcommandesPK"]; ?>" data-numero="<?php echo $row["numeroCommande"]; ?>" data-date="<?php echo $row["dateCommande"]; ?>" data-arrivee="<?php echo $row["arrivee"]; ?>">
                                                    <i class=" fas fa-pen"></i>
                                                </button>&nbsp;
                                                <button class="delete btn btn-danger" data-target="#myModalCommandeDelete" data-toggle="modal" data-id="<?php echo $row["tcommandesPK"]; ?>">
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

    <!-- The Modal Commande Add-->
    <div class="modal fade" id="myModalCommandeAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ajouter une commande</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <form id="commande_form">
                                <tr>
                                    <th>Numéro de commande</th>
                                    <td><input class="form-control" id="numeroCommande_a" name="numeroCommande_a" size="40px" value="" required><b></b></td>
                                </tr>
                                <tr>
                                    <th>Date de commande</th>
                                    <td><input type="date" class="form-control" id="dateCommande_a" name="dateCommande_a" value="" required><b></b></td>
                                </tr>
                                <tr>
                                    <th>La commande est-elle arrivée ?</th>
                                    <td>
                                        <input type="radio" id="arrivee_a" name="arrivee_a" value="1" checked>&nbsp;Oui
                                        <input type="radio" id="arrivee_a" name="arrivee_a" value="0">&nbsp;Non
                                    </td>
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

    <!-- The Modal commande view-->
    <div class="modal fade" id="myModalCommandeView">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="afficherViewNumeroCommande"></h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Fabricant</th>
                                    <th>Nom des produits</th>
                                    <th>Quantité</th>
                                    <th>Technicien</th>
                                </tr>
                            </thead>
                            <tbody id="produitsCommandeList">
                            </tbody>
                        </table>
                    </div>
                    <small>Pour ajouter des nouveaux produits à cette commande, rendez-vous à la page <a href="Stocks.php">stocks</a>.</small>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal libellé Update-->
    <div class="modal fade" id="myModalCommandeUpdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="afficherUpdateNumeroCommande"></h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <form id="update_form">
                                <tr>
                                    <th>Numéro de commande</th>
                                    <td><input class="form-control" id="numeroCommande_u" name="numeroCommande_u" size="40px" value="" required><b></b></td>
                                </tr>
                                <tr>
                                    <th>Date de commande</th>
                                    <td><input type="date" class="form-control" id="dateCommande_u" name="dateCommande_u" value="" required><b></b></td>
                                </tr>
                                <tr>
                                    <th>La commande est-elle arrivée ?</th>
                                    <td>
                                        <input type="radio" id="arrivee_u" name="arrivee_u" value="1">&nbsp;Oui
                                        <input type="radio" id="arrivee_u" name="arrivee_u" value="0">&nbsp;Non
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="tcommandesPK_u" name="tcommandesPK_u" name="type">
                    <button type="submit" class="btn btn-primary" id="update">
                        <span class="fas fa-pen"></span> Modifier
                    </button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal Commande Delete-->
    <div class="modal fade" id="myModalCommandeDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Supprimer une commande</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="tcommandesPK_d" name="tcommandesPK_d" class="form-control">
                        <p>Êtes-vous sûr de vouloir supprimer cette commande ?</p>
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
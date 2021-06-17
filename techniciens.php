<?php
// On inclut la connexion à la base
require_once('php/connect.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Page des techniciens du service informatique">
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

    <!--Calendar script-->
    <script src="js/jsSimpleDatePickr.2.1.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
    <script>
        // POST
        $(document).on('click', '#btn-add', function(e) {
            // Get the checkbox
            var checkBoxOui = document.getElementById("ouiService");
            var checkBoxNon = document.getElementById("nonService");
            // If the checkbox is checked, display the output text
            if (checkBoxOui.checked == true) {
                $("#toujoursService").val == 1;
            } else if (checkBoxNon.checked == true) {
                ("#toujoursService").val == 0;
            }
            var data = $("#technicien_form").serialize();
            $.ajax({
                data: {
                    type: 1,
                    nomTechnicien: $("#nomTechnicien").val(),
                    fonction: $("#fonction").val(),
                    toujoursService: $("#toujoursService").val()
                },
                type: "post",
                url: "php/saveTechnicien.php",
                success: function(dataResult) {
                    console.log(dataResult);
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.statusCode == 200) {
                        $('#myModalTechnicienAdd').modal('hide');
                        alert('Données ajoutées avec succès !');
                        location.reload();
                    } else if (dataResult.statusCode == 201) {
                        alert(dataResult);
                    }
                }
            });
        });

        // UPDATE
        $(document).on('click', '.update', function(e) {
            var ttechnicienPK = $(this).attr("data-id");
            var nomTechnicien = $(this).attr("data-nom");
            var fonction = $(this).attr("data-fonction");
            var toujoursService = $(this).attr("data-service");
            $('#ttechnicienPK_u').val(ttechnicienPK);
            $('#nomTechnicien_u').val(nomTechnicien);
            $('#fonction_u').val(fonction);
            $('#toujoursService_u').val(toujoursService);
        });

        $(document).on('click', '#update', function(e) {
            var data = $("#update_form").serialize();
            $.ajax({
                data: {
                    type: 2,
                    ttechnicienPK: $("ttechnicienPK_u").val(),
                    nomTechnicien: $("#nomTechnicien_u").val(),
                    fonction: $("#fonction_u").val(),
                    toujoursService: $("#toujoursService_u").val()
                },
                type: "post",
                url: "php/saveTechnicien.php",
                success: function(dataResult) {
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.statusCode == 200) {
                        $('#myModalTechnicienUpdate').modal('hide');
                        alert('Données correctement modifiées !');
                        location.reload();
                    } else if (dataResult.statusCode == 201) {
                        alert(dataResult);
                    }
                }
            });
        });

        // DELETE
        $(document).on("click", ".delete", function() {
            var ttechnicienPK = $(this).attr("data-id");
            $('#ttechnicienPK_d').val(ttechnicienPK);
        });

        $(document).on("click", "#delete", function() {
            $.ajax({
                url: "php/saveTechnicien.php",
                type: "POST",
                cache: false,
                data: {
                    type: 3,
                    ttechnicienPK: $("#ttechnicienPK_d").val()
                },
                success: function(dataResult) {
                    $('#myModalTechnicienDelete').modal('hide');
                    $("#" + dataResult).remove();
                    alert('Données correctement supprimées !');
                    document.location.reload();
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
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard.php">Dashboard</a>
                    </li>
                    <li>
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
                    <li class="active">
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
                            Techniciens
                        </h1>
                    </div>
                    <br /><br />
                    <div class="col-1">
                        <button class="btn btn-warning" data-target="#myModalTechnicienAdd" data-toggle="modal">
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
                                        <th>Nom</th>
                                        <th>Fonction</th>
                                        <th>Toujours dans le service</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM ttechnicien");
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr ttechnicienPK="<?php echo $row["ttechnicienPK"]; ?>">
                                            <td><?php echo $row["nomTechnicien"]; ?></td>
                                            <td><?php echo $row["fonction"]; ?></td>
                                            <td><?php
                                                if ($row["toujoursService"] == 1) {
                                                    echo "Oui";
                                                } else if ($row["toujoursService"] == 0) {
                                                    echo "Non";
                                                } ?>
                                            <td>
                                                <button class="view btn btn-success" data-target="#myModalTechnicienView" data-toggle="modal" data-id="<?php echo $row["ttechnicienPK"]; ?>" data-nom="<?php echo $row["nomTechnicien"]; ?>" data-fonction="<?php echo $row["fonction"]; ?>" data-service="<?php echo $row["toujoursService"]; ?>">
                                                    <i class="far fa-eye"></i>
                                                </button>&nbsp;
                                                <button class="update btn btn-primary" data-target="#myModalTechnicienUpdate" data-toggle="modal" data-id="<?php echo $row["ttechnicienPK"]; ?>" data-nom="<?php echo $row["nomTechnicien"]; ?>" data-fonction="<?php echo $row["fonction"]; ?>" data-service="<?php echo $row["toujoursService"]; ?>">
                                                    <i class="fas fa-pen"></i>
                                                </button>&nbsp;
                                                <button class="delete btn btn-danger" data-target="#myModalTechnicienDelete" data-toggle="modal" data-id="<?php echo $row["ttechnicienPK"]; ?>">
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
    <div class="modal fade" id="myModalTechnicienAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ajouter un technicien</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <form id="technicien_form">
                                <tr>
                                    <th>Nom</th>
                                    <td>
                                        <input class="form-control" id="nomTechnicien" name="nomTechnicien" size="40px" value="" required><b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fonction</th>
                                    <td>
                                        <input class="form-control" id="fonction" name="fonction" size="40px" value="" required><b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Est-il toujours dans le service ?</th>
                                    <td>
                                        <fieldset>
                                            <input type="radio" id="ouiService" name="toujoursService" value="1">
                                            <label for="ouiService">Oui</label>
                                            <input type="radio" id="nonService" name="toujoursService" value="0">
                                            <label for="nonService">Non</label>
                                        </fieldset>
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
    <div class="modal fade" id="myModalTechnicienView">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Liste des produits ajoutés par <?php echo '$nomTechnicien'; ?></h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Nom du produit</th>
                                    <th>Type de produit</th>
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

    <!-- The Modal Technicien Update-->
    <div class="modal fade" id="myModalTechnicienUpdate">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update_form">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modifier un technicien</h4>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div id="doubleU" style="display: none;"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                <input type="hidden" id="ttypeproduitsPK_u" name="ttypeproduitsPK" class="form-control" required>
                                <tr>
                                    <th>Nom du technicien</th>
                                    <td>
                                        <input type="text" id="nomTypeProduit_u" name="nom" class="form-control" value="<?php echo '$nomTypeProduit'; ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nom du technicien</th>
                                    <td>
                                        <input type="text" id="nomTypeProduit_u" name="nom" class="form-control" value="<?php echo '$nomTypeProduit'; ?>" required>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="update">Modifier</button>
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- The Modal Type Produit Delete-->
    <div class="modal fade" id="myModalTechnicienDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Supprimer un technicien</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="ttechnicienPK_d" name="technicienPK" class="form-control">
                        <p>Êtes-vous sûr de vouloir supprimer ce technicien ?</p>
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

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
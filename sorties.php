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
                    <li>
                        <a href="stocks.php">Stocks</a>
                    </li>
                    <li class="active">
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
                            Dernières sorties
                        </h1>
                    </div>
                    <div class="col-lg-3">
                        <br /><br /><br />
                        <i class="fas fa-search"></i>&nbsp;&nbsp;<input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Rechercher..">
                    </div> <!-- /.row -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="myTable">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Désignation</th>
                                            <th>Raison de sortie</th>
                                            <th>Lieu de sortie</th>
                                            <th>Quantité</th>
                                            <th>Date de sortie</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tsorties JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tsorties.tcaracteristiquesproduitsFK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN tlieusortie ON tsorties.tlieusortieFK = tlieusortie.tlieusortiePK JOIN ttypeproduits ON tcaracteristiquesproduits.ttypeproduitsFK = ttypeproduits.ttypeproduitsPK JOIN ttechnicien ON ttechnicien.ttechnicienPK = tsorties.ttechnicienFK JOIN tunitegestion ON tunitegestion.tunitegestionPK = tlieusortie.tunitegestionFK ORDER BY 1 DESC");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <tr tproduitsstockes="<?php echo $row["tsortiesPK"]; ?>">
                                                <td><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></td>
                                                <td><?php echo $row["raisonSortie"]; ?></td>
                                                <td><?php echo $row["nomUniteGestion"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLieuSortie"]; ?></td>
                                                <td><?php echo $row["quantiteSortie"]; ?></td>
                                                <td><?php setlocale(LC_TIME, "fr_FR", "French");
                                                    echo strftime("%d/%m/%G", strtotime($row["dateSortie"]));
                                                    ?></td>
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

        <!-- jQuery Version 1.11.0 -->
        <script src="js/jquery-1.11.0.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Rechercher -->
        <script src="js/search.js"></script>
</body>

</html>
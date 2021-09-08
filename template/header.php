<?php
ini_set('session.save_path', dirname('/var/www/html/session/session'));
ini_set('session.cookie_domain', '.crous-lille.fr');
@session_start();

// Session de 12h
ini_set('session.gc_maxlifetime', 43200);

ini_set('display_errors', 0);
require_once('../connect.php');

require_once('../config.php');

if (!isset($_SESSION['access_token']) || $_SESSION['access_token'] == FALSE) {
    session_destroy();
    if (@!$index_principal) {

        echo ("<script>
		alert('Acc\u00e8ss refus\u00e9 : vous devez vous identifier pour acc\u00e9der \u00e0 cette page.');
		location.href='http://logicieldesstocks.crous-lille.fr';
		</script>");
    }
}

if (!$_SESSION['isStocksAdmin']) {
    echo '
	<div class="row">
		<div class="col-lg-9">
			<h1 class="page-header">Identification</h1>
				<div class="alert alert-danger">
                    IDENTIFICATION REFUS&Eacute;E : Vous n\'êtes pas autorisé à accéder au logiciel des stocks. Contactez la DSI.
                </div>
			</div>
		</div>
	</div>
	';
    exit();
}


//*******************************************************************
// Empecher de se connecter avec un compte autre que crous-lille.fr
//*******************************************************************

//On r�cup�re le texte apres @
if (isset($_SESSION['mail']) && !is_null($_SESSION['mail']) && $_SESSION['mail'] != "") {
    $domain = explode("@", $_SESSION['mail'])[1];
    //On v�rifie si ce n'est pas crous-lille.fr
    if ($domain != "crous-lille.fr") {
        //On renvoi la personne vers une d�connexion en expliquant pourquoi
        echo ("<script>
		alert('Merci de vous connecter avec une adresse crous-lille.fr');
		location.href='/logout.php';
		</script>");
    }
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

    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.ico" />

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

    <!-- jQuery Version 1.11.0 -->
    <script src="../js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Datatables JavaScript -->
    <script src="../js/datatables/js/jquery.dataTables.js"></script>
    <script src="../js/datatables-plugins/dataTables.bootstrap.js"></script>
</head>
<script>
    $(document).ready(function() {

        $('#dataTables-example').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            },
            "lengthMenu": [
                [10, 25, 50, 75, 100, -1],
                [10, 25, 50, 75, 100, "Tous"]
            ],
            responsive: true,

        })

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
                <a class="navbar-brand" href="../pages/dashboard.php">Logiciel des stocks</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cog"></i> <?php echo $_SESSION["nom"] ?> <i class="fa fa-caret-down"></i>
                    </a>
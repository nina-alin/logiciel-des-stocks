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
		 
		 <!--Calendar script-->
		<script src="js/jsSimpleDatePickr.2.1.js"></script>


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
					<a class="navbar-brand" href="dashboard.php">Stocks</a>
				</div>
				<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav side-nav">
						<li class="active">
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
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</nav>

			<div id="page-wrapper">

				<div class="container-fluid">

					<!-- Page Heading -->
					<div class="row">
						<div class="col-lg-12">
							<h1 class="page-header text-danger">
								Alertes
							</h1>
						</div>
					</div>
					<!-- /.row -->

					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div class="panel-body">
										<div class="col-lg-3">
											 <div class="panel">
												<div class="panel-body">
													<h3 class="text-center">Alerte</h3>
												</div>
											 </div>
										</div>
										<div class="col-lg-3">
											 <div class="panel">
												<div class="panel-body">
													<h3 class="text-center">Alerte</h3>
												</div>
											 </div>
										</div>
										<div class="col-lg-3">
											 <div class="panel">
												<div class="panel-body">
													<h3 class="text-center">Alerte</h3>
												</div>
											 </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.row -->
					
					<!-- Page Heading -->
					<div class="row">
						<div class="col-lg-12">
							<h1 class="page-header text-success">
								Chiffres clés 
								<small id="calendarMain" class="calendarMain">
									<script type="text/javascript">
										var myCalendar = new jsSimpleDatePickr();
										myCalendar.CalAdd({
											'divId': 'calendarMain',
											'buttonTitle': 'Période souhaitée',
											'dateMask': 'JJ/MM/AAAA',
											'dateCentury': 20,
											'titleMask': 'M AAAA',
											'navType': '01',
											'classTable': 'jsCalendar',
											'classDay': 'day',
											'classDaySelected': 'selectedDay',
											'monthLst': ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
											'dayLst': ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
											'hideOnClick': false,
											'showOnLaunch': false
										});
									</script>
								</small>
							</h1>
						</div>
					</div>
					<!-- /.row -->

					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="panel-body">
										<div class="col-lg-3">
											 <div class="panel">
												<div class="panel-body">
													<h3 class="text-center">Success</h3>
												</div>
											 </div>
										</div>
										<div class="col-lg-3">
											 <div class="panel">
												<div class="panel-body">
													<h3 class="text-center">Success</h3>
												</div>
											 </div>
										</div>
										<div class="col-lg-3">
											 <div class="panel">
												<div class="panel-body">
													<h3 class="text-center">Success</h3>
												</div>
											 </div>
										</div>
										<div class="col-lg-3">
											 <div class="panel">
												<div class="panel-body">
													<h3 class="text-center">Success</h3>
												</div>
											 </div>
										</div>
									</div>
								</div>
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

		<!-- Morris Charts JavaScript -->
		<script src="js/plugins/morris/raphael.min.js"></script>
		<script src="js/plugins/morris/morris.min.js"></script>
		<script src="js/plugins/morris/morris-data.js"></script>

	</body>

</html>
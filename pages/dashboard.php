<?php include("../template/header.php");

include("../template/dropdown.php"); ?>

</li>
</ul>

<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
	<ul class="nav navbar-nav side-nav">
		<li class="active">
			<a href="dashboard.php"> Dashboard <span class="badge badge-danger" style="background-color:red;">
					<?php
					$result = mysqli_query($conn, "SELECT * FROM `tproduitsstockes` WHERE alerte=1 AND quantite<4");
					$i = 0;
					while ($row = mysqli_fetch_array($result)) {
						$i++;
					}
					$result = mysqli_query($conn, "SELECT SUM(quantite), nomTypeProduit, alerteTypeProduit FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK WHERE ttypeproduits.ttypeproduitsPK = ttypeproduitsFK GROUP BY nomTypeProduit;");
					while ($row = mysqli_fetch_array($result)) {
						if ($row["SUM(quantite)"] < 10 && $row["SUM(quantite)"] != null && $row["alerteTypeProduit"] == 1) {
							$i++;
						}
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
		<li>
			<a href="besoins.php">Besoins en produits <span class="badge badge-primary" style="background-color:blue;">
					<?php
					$result = mysqli_query($conn, "SELECT * FROM `tbesoins`");
					$i = 0;
					while ($row = mysqli_fetch_array($result)) {
						$i++;
					}
					echo $i;

					?>
				</span>
			</a>
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
	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="panel-body">
						<?php
						$result = mysqli_query($conn, "SELECT * FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK");
						while ($row = mysqli_fetch_array($result)) {
							if ($row["quantite"] < 4 && $row["quantite"] != null && $row["alerte"] == 1) {
						?>
								<div class="col-lg-3">
									<div class="panel">
										<div class="panel-header">
											<button type="button" class="delete close" data-target="#myModalAlertDelete" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" title="Supprimer">&times;</button>
										</div>
										<div class="panel-body">
											<h3 class="text-center"><?php echo $row["nomFabricant"] ?>&nbsp;<?php echo $row["nomModele"] ?><br />&nbsp;<?php echo $row["nomTypeProduit"] ?> <br />Reste&nbsp;<?php echo $row["quantite"] ?></h3>
										</div>
									</div>
								</div>
						<?php
							}
						}
						?>
					</div>
					<hr />
					<div class="panel-body">
						<?php
						$result = mysqli_query($conn, "SELECT SUM(quantite), nomTypeProduit, alerteTypeProduit, ttypeproduitsPK FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK WHERE ttypeproduits.ttypeproduitsPK = ttypeproduitsFK GROUP BY nomTypeProduit;");
						while ($row = mysqli_fetch_array($result)) {
							if ($row["SUM(quantite)"] < 10 && $row["SUM(quantite)"] != null && $row["alerteTypeProduit"] == 1) {
						?>
								<div class="col-lg-3">
									<div class="panel">
										<div class="panel-header">
											<button type="button" class="deletetype close" data-target="#myModalAlertTypeDelete" data-toggle="modal" data-id-type="<?php echo $row["ttypeproduitsPK"]; ?>" data-nom="<?php echo $row["nomTypeProduit"]; ?>" title="Supprimer">&times;</button>
										</div>
										<div class="panel-body">
											<h3 class="text-center"><?php echo $row["nomTypeProduit"] ?><br />Reste&nbsp;<?php echo $row["SUM(quantite)"] ?></h3>
										</div>
									</div>
								</div>
						<?php
							}
						}
						?>
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
				<input type="date" id="dateCles" onchange="dateCles()" value="<?php echo date('Y-m-d'); ?>">
			</h1>
		</div>
	</div>
	<!-- /.row -->

	<div class=" row">
		<div class="col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-body" id="produitSortieDate">
						<?php
						$result = mysqli_query($conn, "SELECT * FROM `tsorties` JOIN tcaracteristiquesproduits ON tsorties.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK WHERE DATE(dateSortie)=DATE(NOW())");
						while ($row = mysqli_fetch_array($result)) {
						?>
							<div class="col-lg-3">
								<div class="panel">
									<div class="panel-body">
										<h3 class="text-center">&nbsp;<?php echo $row["nomFabricant"] ?>&nbsp;<?php echo $row["nomModele"] ?><br /> <?php echo $row["quantiteSortie"] ?> équipés</h3>
									</div>
								</div>
							</div>
						<?php
						}
						?>
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

<!-- The Modal Alerte Delete-->
<div class="modal fade" id="myModalAlertDelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
					<h4 class="modal-title" id="afficherSupprimerAlerte"></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="tproduitsstockesPK_d" name="tproduitsstockesPK" class="form-control">
					<p>Êtes-vous sûr de vouloir retirer cette alerte ?</p>
					<p class="text-warning"><small>Pour la réactiver, rendez-vous à la page <a href="./stocks.php">stocks</a>.</small></p>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="delete" title="Supprimer">Supprimer</button>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- The Modal Alerte Type Delete-->
<div class="modal fade" id="myModalAlertTypeDelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
					<h4 class="modal-title" id="afficherSupprimerAlerteTypeProduit"></h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="ttypeproduitsPK_d" name="ttypeproduitsPK_d" class="form-control">
					<p>Êtes-vous sûr de vouloir retirer cette alerte ?</p>
					<p class="text-warning"><small>Pour la réactiver, rendez-vous à la page <a href="./typesProduits.php">Types de produits</a>.</small></p>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" id="delete-type" title="Supprimer">Supprimer</button>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
				</div>
			</form>
		</div>
	</div>
</div>

<script src="../js/script/dashboard-script.js"></script>

<?php include("../template/footer.php"); ?>
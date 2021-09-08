<?php include("../template/header.php"); ?>

<?php include("../template/dropdown.php"); ?>

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
		<li class="active">
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
				</span></a>
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
				<h1 class="page-header text-primary">
					Stocks
				</h1>
			</div>
		</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive table-hover col-lg-12">
					<table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
						<thead>
							<tr>
								<th tabindex="0" aria-controls="dataTables-example">Modèle</th>
								<th tabindex="1" aria-controls="dataTables-example">Type de produit</th>
								<th tabindex="2" aria-controls="dataTables-example">Emplacement</th>
								<th tabindex="3" aria-controls="dataTables-example">Quantité</th>
								<th tabindex="4" aria-controls="dataTables-example">Alerte</th>
								<th tabindex="5" aria-controls="dataTables-example">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$result = mysqli_query($conn, "SELECT * FROM tproduitsstockes JOIN tcaracteristiquesproduits ON tproduitsstockes.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN tlibelles ON tlibelles.tlibellesPK = tproduitsstockes.tlibellesFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK ORDER BY nomFabricant, nomTypeProduit, nomModele");
							while ($row = mysqli_fetch_array($result)) {
							?>
								<?php if ($row["quantite"] < 4 && $row["quantite"] != null && $row["alerte"] == 1) {  ?>
									<tr tproduitsstockes="<?php echo $row["tproduitsstockesPK"]; ?>" style="background-color: #ffbdbd;">
									<?php } else { ?>
									<tr tproduitsstockes="<?php echo $row["tproduitsstockesPK"]; ?>">
									<?php } ?>
									<td><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></td>
									<td><?php echo $row["nomTypeProduit"]; ?></td>
									<td><?php echo $row["nomEmplacement"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLibelle"]; ?></td>
									<td><?php echo $row["quantite"]; ?></td>
									<td>
										<?php if ($row["alerte"] == 1) { ?> <i class="fas fa-check"></i> <?php } else if ($row["alerte"] == 0) { ?>
											<i class="fas fa-times"></i> <?php } ?>
									</td>
									<td>
										<button class="add btn btn-warning" title="Ajouter" data-target="#myModaltentreeAdd" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>">
											<i class="fas fa-plus"></i>
										</button>&nbsp;
										<button class="view btn btn-success" title="Voir" data-target="#myModalStocksView" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-nom="<?php echo $row["nomModele"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>">
											<i class="far fa-eye"></i>
										</button>&nbsp;
										<button class="update btn btn-primary" title="Modifier" data-target="#myModalStocksUpdate" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-libelles="<?php echo $row["tlibellesFK"]; ?>" data-alerte="<?php echo $row["alerte"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>">
											<i class="fas fa-pen"></i>
										</button>&nbsp;
										<button class="sortie btn btn-danger" title="Sortir" data-target="#myModalStocksSortie" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>">
											<i class="fas fa-door-open"></i>
										</button>
										<button class="update-ns btn btn-secondary" title="Numéros de séries" data-target="#myModaltnumerosserieUpdate" data-toggle="modal" data-id="<?php echo $row["tproduitsstockesPK"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>">
											<i class="far fa-sticky-note"></i>
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

<!-- The Modal Type Produit view-->
<div class="modal fade" id="myModalStocksView">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
				<h4 class="modal-title" id="afficherViewNomStocks"></h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="doubleU" style="display: none;"></div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
						<thead>
							<tr>
								<th>Fabricant</th>
								<th>Nom</th>
								<th>Désignation</th>
								<th>Compatibilité</th>
							</tr>
						</thead>
						<tbody id="stocks_details">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- The Modal Entree Add-->
<div class="modal fade" id="myModaltentreeAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
				<h4 class="modal-title" id="afficherAddSortie"></h4>
			</div>
			<form id="tentrees_form">
				<!-- Modal body -->
				<div class="modal-body">
					<div id="doubleU" style="display: none;"></div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<tr>
								<th>D'où provient le produit ? <br />
									<small>Si le numéro de commande n'est pas connu, mettre "UG - DSI"<br />Pour ajouter une commande, rendez-vous sur la page <a href="commandes.php">commandes</a>.</small>

								</th>
								<td>
									<select id="typeEntree" name="typeEntree" class="form-control" onchange="typeEntreeFunction()">
										<option disabled selected value> -- Sélectionnez une option -- </option>
										<option value="1">Une commande</option>
										<option value="2">Une UG</option>
									</select>
								</td>
							</tr>
							<tr id="trTypeEntree"></tr>
							<tr id="trQuantite"></tr>
							<tr id="trTechnicien"></tr>
						</table>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" id="tproduitsstockesFK_a" name="tproduitsstockesFK_a">
					<button type="button" class="btn btn-warning" id="btn-add" title="Ajouter">Ajouter</button>
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- The Modal libellé Update-->
<div class="modal fade" id="myModalStocksUpdate">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Annuler">&times;</button>
				<h4 class="modal-title" id="afficherModifierProduit"></h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="doubleU" style="display: none;"></div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
						<tr>
							<th>Emplacement</th>
							<td>
								<select class="form-control" id="tlibellesFK_u" name="tlibellesFK_u" required>
									<?php
									$result = mysqli_query($conn, "SELECT * FROM tlibelles JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK");
									while ($row = mysqli_fetch_array($result)) {
									?>
										<option value="<?php echo $row["tlibellesPK"]; ?>"><?php echo $row["nomEmplacement"]; ?> - <?php echo $row["nomLibelle"]; ?></option>
									<?php
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Alerter en cas de stocks bas ?</th>
							<td>
								<input type="radio" id="alerte_u_oui" name="alerte_u" value="1" checked>&nbsp;Oui
								<input type="radio" id="alerte_u_non" name="alerte_u" value="0">&nbsp;Non
							</td>
						</tr>
					</table>
				</div>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<input type="hidden" id="tproduitsstockesPK_u" name="tproduitsstockesPK_u" name="type">
				<button type="submit" class="btn btn-primary" id="update" title="Modifier">
					<span class="fas fa-pen"></span> Modifier
				</button>
				<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
			</div>
		</div>
	</div>
</div>

<!-- The Modal stocks sortie-->
<div class="modal fade" id="myModalStocksSortie">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Annuler">&times;</button>
				<h4 class="modal-title" id="afficherSortirProduit"></h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="doubleU" style="display: none;"></div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
						<form id="tsortie_form">
							<tr>
								<th>Raison de la sortie</th>
								<td>
									<input class="form-control" id="raisonSortie_s" name="raisonSortie_s" size="40px" placeholder="Champ non obligatoire"><b></b>
								</td>
							</tr>
							<tr>
								<th>Technicien</th>
								<td>
									<select class="form-control" id="ttechnicienFK_s" name="ttechnicienFK_s" value="" required>
										<?php
										$result = mysqli_query($conn, "SELECT * FROM ttechnicien ORDER BY nomTechnicien, prenomTechnicien");
										while ($row = mysqli_fetch_array($result)) {
										?>
											<option value="<?php echo $row["ttechnicienPK"]; ?>"><?php echo $row["prenomTechnicien"]; ?>&nbsp;<?php echo $row["nomTechnicien"]; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Lieu de sortie</th>
								<td>
									<select class="form-control" id="tlieusortieFK_s" name="tlieusortieFK_s" value="" required>
										<?php
										$result = mysqli_query($conn, "SELECT * FROM tlieusortie JOIN tunitegestion ON tlieusortie.tunitegestionFK = tunitegestion.tunitegestionPK ORDER BY nomUniteGestion, nomLieuSortie");
										while ($row = mysqli_fetch_array($result)) {
										?>
											<option value="<?php echo $row["tlieusortiePK"]; ?>"><?php echo $row["nomUniteGestion"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLieuSortie"]; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Quantité</th>
								<td>
									<input type="number" class="form-control" id="quantiteSortie_s" name="quantiteSortie_s" min="1" size="40px" value="" required><b></b>
								</td>
							</tr>
						</form>
					</table>
					<!-- Modal footer -->
					<div class="modal-footer">
						<input type="hidden" id="tproduitsstockesPK_s" name="tproduitsstockesPK_s" name="type">
						<button type="submit" class="btn btn-danger" id="btn-sortie" title="Sortie">
							<span class="fas fa-door-open"></span> Sortir
						</button>
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- The Modal Numéro Série Update -->
<div class="modal fade" id="myModaltnumerosserieUpdate">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
				<h4 class="modal-title" id="afficherNsProduit"></h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="doubleU" style="display: none;"></div>
				<div class="table-responsive">
					<form id="tnumerosseries_update">
						<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
							<tbody id="numeroseries_details"></tbody>
						</table>
					</form>
					<!-- Modal footer -->
					<div class="modal-footer">
						<input type="hidden" id="tproduitsstockesPK_u" name="tproduitsstockesPK_u" name="type">
						<button type="submit" class="btn btn-warning" onclick="showHiddenContentNs()" title="Ajouter">
							<i class="fas fa-plus"></i>
						</button>
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
					</div>
					<div class="modal-footer" id="addns" class="ad-ns">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="../js/script/stocks-script.js"></script>

<?php include("../template/footer.php"); ?>
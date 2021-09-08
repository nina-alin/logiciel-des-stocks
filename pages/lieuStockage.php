<?php include("../template/header.php"); ?>

<ul class="dropdown-menu dropdown-user">
	<li><a href="../pages/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
	<li><a href="../pages/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
	<li><a href="../pages/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
	<li> <a href="../pages/techniciens.php"><i class="fas fa-wrench"></i>&nbsp;Techniciens</a></li>
	<li class="active"> <a href="../pages/lieuStockage.php"><i class="fas fa-box-open"></i>&nbsp;Lieux de stockage</a></li>
	<li><a href="../pages/emplacements.php"><i class="fas fa-warehouse"></i>&nbsp;Emplacements</a></li>
	<li><a href="../pages/lieuSortie.php"><i class="fas fa-door-closed"></i>&nbsp;Lieux de sortie</a></li>
	<li><a href="../pages/uniteGestion.php"><i class="fas fa-paper-plane"></i>&nbsp;Unités de gestion</a></li>
	<li><a href="../pages/plateforme.php"><i class="fas fa-mouse-pointer"></i>&nbsp;Plateformes</a></li>
	<li class="divider"></li>
	<li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
</ul>
</li>
</ul>
<?php include("../template/sidebar.php"); ?>

</nav>

<div id="page-wrapper">

	<div class="container-fluid">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-11">
				<h1 class="page-header text-primary">
					Lieux de stockage
				</h1>
			</div>
			<br /><br />
			<div class="col-1">
				<button class="btn btn-warning" data-target="#myModalLibelleAdd" data-toggle="modal" title="Ajouter">
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
						<tbody>
							<?php
							$result = mysqli_query($conn, "SELECT * FROM tlibelles INNER JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK ORDER BY nomEmplacement, nomLibelle");
							while ($row = mysqli_fetch_array($result)) {
							?>
								<tr tlibellesPK="<?php echo $row["tlibellesPK"]; ?>">
									<td><?php echo $row["nomLibelle"]; ?></td>
									<td><?php echo $row["nomEmplacement"]; ?></td>
									<td>
										<button class="view btn btn-success" data-target="#myModalLibelleView" data-toggle="modal" data-id="<?php echo $row["tlibellesPK"]; ?>" data-nom-libelle="<?php echo $row["nomLibelle"]; ?>" data-nom-emplacement="<?php echo $row["nomEmplacement"]; ?>" title="Voir">
											<i class="far fa-eye"></i>
										</button>&nbsp;
										<button class="update btn btn-primary" data-target="#myModalLibelleUpdate" data-toggle="modal" data-libelle-id=<?php echo $row["tlibellesPK"]; ?> data-nom-libelle=<?php echo $row["nomLibelle"]; ?> data-emplacement-id=<?php echo $row["templacementsPK"]; ?> title="Modifier">
											<i class="fas fa-pen"></i>
										</button>&nbsp;
										<button class="delete btn btn-danger" data-target="#myModalLibelleDelete" data-toggle="modal" data-id="<?php echo $row["tlibellesPK"]; ?>" title="Supprimer">
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
<div class="modal fade" id="myModalLibelleAdd">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
				<h4 class="modal-title">Ajouter un libellé</h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="doubleU" style="display: none;"></div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
						<form id="libelle_form">
							<tr>
								<th>Emplacement</th>
								<td>
									<select class="form-control" id="templacementsFK_a" name="templacementsFK_a" value="" required>
										<?php
										$result = mysqli_query($conn, "SELECT * FROM templacements");
										while ($row = mysqli_fetch_array($result)) {
										?>
											<option value="<?php echo $row["templacementsPK"]; ?>"><?php echo $row["nomEmplacement"]; ?></option>
										<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<th>Nom</th>
								<td><input class="form-control" id="nomLibelle_a" name="nomLibelle_a" size="40px" value="" required><b></b></td>
							</tr>
						</form>
					</table>
				</div>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<input type="hidden" value="1" name="type">
				<button type="submit" class="btn btn-warning" id="btn-add" title="Ajouter">
					<span class="fas fa-plus"></span> Ajouter
				</button>
				<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
			</div>
		</div>
	</div>
</div>

<!-- The Modal libellé view-->
<div class="modal fade" id="myModalLibelleView">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
				<h4 class="modal-title" id="afficherViewNomLibelle"></h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="doubleU" style="display: none;"></div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
						<thead>
							<tr>
								<th>Fabricant</th>
								<th>Modèle</th>
								<th>Désignation</th>
								<th>Quantité</th>
							</tr>
						</thead>
						<tbody id="libelle_details">
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
				<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
				<h4 class="modal-title" id="afficherUpdateNomLibelle"></h4>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<div id="doubleU" style="display: none;"></div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
						<tr>
							<th>Emplacement</th>
							<td>
								<select class="form-control" id="templacementsFK_u" name="templacementsFK_u" required>
									<?php
									$result = mysqli_query($conn, "SELECT * FROM templacements");
									while ($row = mysqli_fetch_array($result)) {
									?>
										<option value="<?php echo $row["templacementsPK"]; ?>"><?php echo $row["nomEmplacement"]; ?></option>
									<?php
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Nom</th>
							<td><input class="form-control" id="nomLibelle_u" name="nom" size="40px" value="<?php echo $nomLibelle ?>" required><b></b></td>
						</tr>
					</table>
				</div>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<input type="hidden" id="tlibellesPK_u" name="tlibellesPK" name="type">
				<button type="submit" class="btn btn-primary" id="update" title="Modifier">
					<span class="fas fa-pen"></span> Modifier
				</button>
				<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
			</div>
		</div>
	</div>
</div>

<!-- The Modal libellé Delete-->
<div class="modal fade" id="myModalLibelleDelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
					<h4 class="modal-title">Supprimer un libellé</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="tlibellesPK_d" name="tlibellesPK" class="form-control">
					<p>Êtes-vous sûr de vouloir supprimer ce libellé ?</p>
					<p class="text-warning"><small>Cette action ne peut pas être annulée.</small></p>
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

<script src="../js/script/lieuStockage-script.js"></script>

<?php include("../template/footer.php"); ?>
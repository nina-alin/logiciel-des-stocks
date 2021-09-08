<?php include("../template/header.php"); ?>

<ul class="dropdown-menu dropdown-user">
    <li><a href="../pages/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
    <li class="active"><a href="../pages/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
    <li><a href="../pages/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
    <li> <a href="../pages/techniciens.php"><i class="fas fa-wrench"></i>&nbsp;Techniciens</a></li>
    <li> <a href="../pages/lieuStockage.php"><i class="fas fa-box-open"></i>&nbsp;Lieux de stockage</a></li>
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
                    Fabricants
                </h1>
            </div>
            <br /><br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalFabricantsAdd" data-toggle="modal" title="Ajouter">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive table-hover col-lg-12">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                        <thead>
                            <tr>
                                <th tabindex="0" aria-controls="dataTables-example">Nom</th>
                                <th tabindex="1" aria-controls="dataTables-example">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM tfabricants ORDER BY nomFabricant");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr tlibellesPK="<?php echo $row["tfabricantsPK"]; ?>">
                                    <td><?php echo $row["nomFabricant"]; ?></td>
                                    <td>
                                        <button class="view btn btn-success" data-target="#myModalFabricantsView" data-toggle="modal" data-id="<?php echo $row["tfabricantsPK"]; ?>" data-nom="<?php echo $row["nomFabricant"]; ?>" title="Voir">
                                            <i class="far fa-eye"></i>
                                        </button>&nbsp;
                                        <button class="update btn btn-primary" data-target="#myModalFabricantsUpdate" data-toggle="modal" data-id="<?php echo $row["tfabricantsPK"]; ?>" data-nom="<?php echo $row["nomFabricant"]; ?>" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" data-target="#myModalFabricantsDelete" data-toggle="modal" data-id="<?php echo $row["tfabricantsPK"]; ?>" title="Supprimer">
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

<!-- The Modal Fabricants Add-->
<div class="modal fade" id="myModalFabricantsAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Annuler">&times;</button>
                <h4 class="modal-title">Ajouter un fabricant</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <form id="fabricants_form">
                            <tr>
                                <th>Nom</th>
                                <td>
                                    <input class="form-control" id="nomFabricant" name="nomFabricant" size="40px" value="" required><b></b>
                                </td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="hidden" value="1" name="type">
                <button type="button" class="btn btn-warning" id="btn-add" title="Ajouter">Ajouter</button>
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
            </div>
        </div>
    </div>
</div>

<!-- The Modal Fabricant view-->
<div class="modal fade" id="myModalFabricantsView">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title" id="afficherNomFabricant"></h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Modèle</th>
                                <th>Type de produit</th>
                                <th>Quantité</th>
                                <th>Emplacement</th>
                            </tr>
                        </thead>
                        <tbody id="fabricants_details">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Fabricant Update-->
<div class="modal fade" id="myModalFabricantsUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update_form">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Modifier un fabricant</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <input type="hidden" id="tfabricantsPK_u" name="tfabricantsPK" class="form-control" required>
                            <tr>
                                <th>Nom</th>
                                <td>
                                    <input type="text" id="nomFabricant_u" name="nom" class="form-control" value="<?php echo '$nomFabricant'; ?>" required>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="update" title="Modfier">Modifier</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal Type Produit Delete-->
<div class="modal fade" id="myModalFabricantsDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer un fabricant</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tfabricantsPK_d" name="tfabricantsPK" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer ce fabricant ?</p>
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

<script src="../js/script/fabricants-script.js"></script>

<?php include("../template/footer.php"); ?>
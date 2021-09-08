<?php include("../template/header.php"); ?>

<ul class="dropdown-menu dropdown-user">
    <li class="active"><a href="../pages/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
    <li><a href="../pages/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
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

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-11">
                <h1 class="page-header text-primary">
                    Modèles des produits
                </h1>
            </div>
            <br /><br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalCaracteristiqueProduitAdd" data-toggle="modal" title="Ajouter">
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
                                <th tabindex="0" aria-controls="dataTables-example">Désignation</th>
                                <th tabindex="1" aria-controls="dataTables-example">Type de produit</th>
                                <th tabindex="2" aria-controls="dataTables-example">Compatibilité</th>
                                <th tabindex="3" aria-controls="dataTables-example">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM tcaracteristiquesproduits JOIN tfabricants ON tfabricants.tfabricantsPK = tcaracteristiquesproduits.tfabricantsFK JOIN ttypeproduits ON ttypeproduits.ttypeproduitsPK = tcaracteristiquesproduits.ttypeproduitsFK ORDER BY nomFabricant, nomTypeProduit, nomModele");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr ttcaracteristiquesproduitsPK="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>">
                                    <td><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></td>
                                    <td><?php echo $row["nomTypeProduit"]; ?></td>
                                    <td><?php echo $row["compatibilite"]; ?></td>
                                    <td>
                                        <button class="update btn btn-primary" data-target="#myModalCaracteristiquesProduitsUpdate" data-toggle="modal" data-id="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>" data-id-fabricant="<?php echo $row["tfabricantsFK"]; ?>" data-nom-fabricant="<?php echo $row["nomFabricant"]; ?>" data-nom-modele="<?php echo $row["nomModele"]; ?>" data-id-typeproduit="<?php echo $row["ttypeproduitsFK"]; ?>" data-compatibilite="<?php echo $row["compatibilite"]; ?>" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" data-target="#myModalCaracteristiquesProduitsDelete" data-toggle="modal" data-id="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>" title="Supprimer">
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
<div class="modal fade" id="myModalCaracteristiqueProduitAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Ajouter un produit</h4>
            </div>
            <form id="caracteristiquesProduits_form">
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Fabricant</th>
                                <td>
                                    <select class="form-control" id="tfabricantsFK_a" name="tfabricantsFK_a" value="" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tfabricants");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tfabricantsPK"]; ?>"><?php echo $row["nomFabricant"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Nom</th>
                                <td>
                                    <input class="form-control" id="nomModele_a" name="nomModele_a" size="40px" value="" required><b></b>
                                </td>
                            </tr>
                            <tr>
                                <th>Désignation</th>
                                <td>
                                    <select class="form-control" id="ttypeproduitsFK_a" name="ttypeproduitsFK_a" value="" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM ttypeproduits ORDER BY nomTypeProduit");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["ttypeproduitsPK"]; ?>"><?php echo $row["nomTypeProduit"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Compatibilite</th>
                                <td>
                                    <input class="form-control" id="compatibilite_a" name="compatibilite_a" size="40px" value=""><b></b>
                                </td>
                            </tr>
                            <tr>
                                <th>Futur lieu de stockage</th>
                                <td>
                                    <select class="form-control" id="tlibellesFK_a" name="tlibellesFK_a" value="" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tlibelles JOIN templacements ON tlibelles.templacementsFK = templacements.templacementsPK ORDER BY nomEmplacement, nomLibelle");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tlibellesPK"]; ?>"><?php echo $row["nomEmplacement"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLibelle"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" value="1" name="type">
                    <button type="button" class="btn btn-warning" id="btn-add" title="Ajouter">Ajouter</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal Caracteristique Produit Update-->
<div class="modal fade" id="myModalCaracteristiquesProduitsUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update_form">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title" id="afficherUpdateCaracteristiquesProduits"></h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Fabricant</th>
                                <td>
                                    <select class="form-control" id="tfabricantsFK_u" name="tfabricantsFK_u" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tfabricants");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tfabricantsPK"]; ?>"><?php echo $row["nomFabricant"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Nom du modèle</th>
                                <td><input class="form-control" id="nomModele_u" name="nomModele_u" size="40px" value="<?php echo '$nomModele'; ?>" required><b></b></td>
                            </tr>
                            <tr>
                                <th>Type de produit</th>
                                <td>
                                    <select class="form-control" id="ttypeproduitsFK_u" name="ttypeproduitsFK_u" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM ttypeproduits");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["ttypeproduitsPK"]; ?>"><?php echo $row["nomTypeProduit"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Compatibilité</th>
                                <td><input class="form-control" id="compatibilite_u" name="compatibilite_u" size="40px" value="<?php echo '$compatibilite'; ?>"><b></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="tcaracteristiquesproduitsPK_u" name="tcaracteristiquesproduitsPK_u" name="type">
                    <button type="submit" class="btn btn-primary" id="update" title="Modifier">
                        <span class="fas fa-pen"></span> Modifier
                    </button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal Caracteristique Produit Delete-->
<div class="modal fade" id="myModalCaracteristiquesProduitsDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer un modèle de produit</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tcaracteristiquesproduitsPK_d" name="tcaracteristiquesproduitsPK_d" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer ce modèle ?</p>
                    <p class="text-warning"><small>Cette action ne peut pas être annulée.</small></p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete" title="Summprimer">Supprimer</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/script/caracteristiquesProduits-script.js"></script>

<?php include("../template/footer.php"); ?>
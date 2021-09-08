<?php include("../template/header.php"); ?>

<ul class="dropdown-menu dropdown-user">
    <li><a href="../pages/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
    <li><a href="../pages/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
    <li><a href="../pages/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
    <li class="active"> <a href="../pages/techniciens.php"><i class="fas fa-wrench"></i>&nbsp;Techniciens</a></li>
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
                    Techniciens
                </h1>
            </div>
            <br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalTechnicienAdd" data-toggle="modal" title="Ajouter">
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
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Fonction</th>
                                <th>Toujours dans le service</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM ttechnicien ORDER BY nomTechnicien, prenomTechnicien");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr ttechnicienPK="<?php echo $row["ttechnicienPK"]; ?>">
                                    <td><?php echo $row["prenomTechnicien"]; ?></td>
                                    <td><?php echo $row["nomTechnicien"]; ?></td>
                                    <td><?php echo $row["fonction"]; ?></td>
                                    <td><?php
                                        if ($row["toujoursService"] == 1) {
                                            echo "Oui";
                                        } else if ($row["toujoursService"] == 0) {
                                            echo "Non";
                                        } ?>
                                    <td>
                                        <button class="view btn btn-success" title="Voir" data-target="#myModalTechnicienView" data-toggle="modal" data-id="<?php echo $row["ttechnicienPK"]; ?>" data-nom="<?php echo $row["nomTechnicien"]; ?>" data-prenom="<?php echo $row["prenomTechnicien"]; ?>">
                                            <i class="far fa-eye"></i>
                                        </button>&nbsp;
                                        <button class="update btn btn-primary" title="Modifier" data-target="#myModalTechnicienUpdate" data-toggle="modal" data-id="<?php echo $row["ttechnicienPK"]; ?>" data-nom="<?php echo $row["nomTechnicien"]; ?>" data-prenom="<?php echo $row["prenomTechnicien"]; ?>" data-fonction="<?php echo $row["fonction"]; ?>" data-service="<?php echo $row["toujoursService"]; ?>">
                                            <i class="fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" title="Supprimer" data-target="#myModalTechnicienDelete" data-toggle="modal" data-id="<?php echo $row["ttechnicienPK"]; ?>">
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
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
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
                                <th>Prénom</th>
                                <td>
                                    <input class="form-control" id="prenomTechnicien" name="prenomTechnicien" size="40px" value="" required><b></b>
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
                                    <input type="radio" id="toujoursService_a" name="toujoursService_a" value="1" checked>&nbsp;Oui
                                    <input type="radio" id="toujoursService_a" name="toujoursService_a" value="0">&nbsp;Non
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

<!-- The Modal Type Produit view-->
<div class="modal fade" id="myModalTechnicienView">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title" id="afficherViewTechnicien"></h4>
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
                                <th>Lieu de stockage</th>
                            </tr>
                        </thead>
                        <tbody id="technicien_details">
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
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Modifier un technicien</h4>
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
                                        <input class="form-control" id="nomTechnicien_u" name="nomTechnicien_u" size="40px" value="" required><b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Prénom</th>
                                    <td>
                                        <input class="form-control" id="prenomTechnicien_u" name="prenomTechnicien_u" size="40px" value="" required><b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fonction</th>
                                    <td>
                                        <input class="form-control" id="fonction_u" name="fonction_u" size="40px" value="" required><b></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Est-il toujours dans le service ?</th>
                                    <td>
                                        <input type="radio" id="toujoursService_u_oui" name="toujoursService_u" value="1">&nbsp;Oui
                                        <input type="radio" id="toujoursService_u_non" name="toujoursService_u" value="0">&nbsp;Non
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="ttechnicienPK_u" name="ttechnicienPK" name="type">
                    <button type="button" class="btn btn-primary" id="update" title="Modifier">Modifier</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
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
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer un technicien</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ttechnicienPK_d" name="technicienPK" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer ce technicien ?</p>
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

<script src="../js/script/techniciens-script.js"></script>

<?php include("../template/footer.php"); ?>
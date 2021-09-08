<?php include("../template/header.php"); ?>

<ul class="dropdown-menu dropdown-user">
    <li><a href="../pages/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
    <li><a href="../pages/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
    <li class="active"><a href="../pages/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
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
                    Types de produits
                </h1>
            </div>
            <br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalTypeProduitAdd" data-toggle="modal" title="Ajouter">
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
                                <th>Alerte</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM ttypeproduits ORDER BY nomTypeProduit");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr ttypeproduitsPK="<?php echo $row["ttypeproduitsPK"]; ?>">
                                    <td><?php echo $row["nomTypeProduit"]; ?></td>
                                    <td>
                                        <?php if ($row["alerteTypeProduit"] == 1) { ?> <i class="fas fa-check"></i> <?php } else if ($row["alerteTypeProduit"] == 0) { ?>
                                            <i class="fas fa-times"></i> <?php } ?>
                                    </td>
                                    <td>
                                        <button class="view btn btn-success" title="Voir" data-target="#myModalTypeProduitView" data-toggle="modal" data-id="<?php echo $row["ttypeproduitsPK"]; ?>" data-nom="<?php echo $row["nomTypeProduit"]; ?>">
                                            <i class="far fa-eye"></i>
                                        </button>&nbsp;
                                        <button class="update btn btn-primary" title="Modifier" data-target="#myModalTypeProduitUpdate" data-toggle="modal" data-id="<?php echo $row["ttypeproduitsPK"]; ?>" data-nom="<?php echo $row["nomTypeProduit"]; ?>" data-alerte="<?php echo $row["alerteTypeProduit"]; ?>">
                                            <i class="fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" title="Supprimer" data-target="#myModalTypeProduitDelete" data-toggle="modal" data-id="<?php echo $row["ttypeproduitsPK"]; ?>">
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
<div class="modal fade" id="myModalTypeProduitAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Ajouter un type de produits</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <form id="typeProduits_form">
                            <tr>
                                <th>Nom</th>
                                <td>
                                    <input class="form-control" id="nomTypeProduit" name="nomTypeProduit" size="40px" value="" required><b></b>
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
<div class="modal fade" id="myModalTypeProduitView">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title" id="afficherNomTypeProduit"></h4>
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
                                <th>Quantité</th>
                                <th>Emplacement</th>
                            </tr>
                        </thead>
                        <tbody id="typeProduits_details">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal Type Produit Update-->
<div class="modal fade" id="myModalTypeProduitUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update_form">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title" id="afficherUpdateNomTypeProduit"></h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <input type="hidden" id="ttypeproduitsPK_u" name="ttypeproduitsPK" class="form-control" required>
                            <tr>
                                <th>Nom du type de produit</th>
                                <td>
                                    <input type="text" id="nomTypeProduit_u" name="nom" class="form-control" value="<?php echo '$nomTypeProduit'; ?>" required>
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
                    <button type="button" class="btn btn-primary" id="update" title="Modifier">Modifier</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal Type Produit Delete-->
<div class="modal fade" id="myModalTypeProduitDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer un type de produits</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ttypeproduitsPK_d" name="ttypeproduitsPK" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer ce type de produits ?</p>
                    <p class="text-warning"><small>Cette action ne peut pas être annulée.</small></p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="delete" title="Fermer">Supprimer</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/script/typesProduits-script.js"></script>

<?php include("../template/footer.php"); ?>
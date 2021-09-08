<?php include("../template/header.php"); ?>

<ul class="dropdown-menu dropdown-user">
    <li><a href="../pages/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
    <li><a href="../pages/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
    <li><a href="../pages/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
    <li> <a href="../pages/techniciens.php"><i class="fas fa-wrench"></i>&nbsp;Techniciens</a></li>
    <li> <a href="../pages/lieuStockage.php"><i class="fas fa-box-open"></i>&nbsp;Lieux de stockage</a></li>
    <li><a href="../pages/emplacements.php"><i class="fas fa-warehouse"></i>&nbsp;Emplacements</a></li>
    <li><a href="../pages/lieuSortie.php"><i class="fas fa-door-closed"></i>&nbsp;Lieux de sortie</a></li>
    <li><a href="../pages/uniteGestion.php"><i class="fas fa-paper-plane"></i>&nbsp;Unités de gestion</a></li>
    <li class="active"><a href="../pages/plateforme.php"><i class="fas fa-mouse-pointer"></i>&nbsp;Plateformes</a></li>
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
                    Plateformes
                </h1>
            </div>
            <br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalPlateformeAdd" data-toggle="modal" title="Ajouter">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM tplateforme ORDER BY nomPlateforme");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr tplateformePK="<?php echo $row["tplateformePK"]; ?>">
                                    <td><?php echo $row["nomPlateforme"]; ?></td>
                                    <td>
                                        <button class="update btn btn-primary" data-target="#myModalPlateformeUpdate" data-toggle="modal" data-id="<?php echo $row["tplateformePK"]; ?>" data-nom="<?php echo $row["nomPlateforme"]; ?>" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" data-target="#myModalPlateformeDelete" data-toggle="modal" data-id="<?php echo $row["tplateformePK"]; ?>" title="Supprimer">
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

<!-- The Modal Emplacement Add-->
<div class="modal fade" id="myModalPlateformeAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Ajouter une Plateforme</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <form id="tplateforme_form">
                            <tr>
                                <th>Nom</th>
                                <td>
                                    <input class="form-control" id="nomPlateforme" name="nomPlateforme" size="40px" value="" required><b></b>
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

<!-- The Modal Emplacement Update-->
<div class="modal fade" id="myModalPlateformeUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="update_form">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Annuler">&times;</button>
                    <h4 class="modal-title">Modifier une plateforme</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Nom</th>
                                <td>
                                    <input class="form-control" id="nomPlateforme_u" name="nomPlateforme_u" size="40px" value="" required><b></b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="tplateformePK_u" name="tplateformePK_u" name="type">
                    <button type="button" class="btn btn-primary" id="update" title="Modifier">Modifier</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal Emplacement Delete-->
<div class="modal fade" id="myModalPlateformeDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer une unité de gestion</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tplateformePK_d" name="tplateformePK_d" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer cette unité de gestion ?</p>
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

<script src="../js/script/plateforme-script.js"></script>

<?php include("../template/footer.php"); ?>
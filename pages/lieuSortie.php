<?php include("../template/header.php"); ?>

<ul class="dropdown-menu dropdown-user">
    <li><a href="../pages/caracteristiquesProduits.php"><i class="fas fa-microchip"></i>&nbsp;Modèles de produits</a></li>
    <li><a href="../pages/fabricants.php"><i class="fab fa-phabricator"></i>&nbsp;Fabricants</a></li>
    <li><a href="../pages/typesProduits.php"><i class="fas fa-laptop"></i>&nbsp;Types de produits</a></li>
    <li> <a href="../pages/techniciens.php"><i class="fas fa-wrench"></i>&nbsp;Techniciens</a></li>
    <li> <a href="../pages/lieuStockage.php"><i class="fas fa-box-open"></i>&nbsp;Lieux de stockage</a></li>
    <li><a href="../pages/emplacements.php"><i class="fas fa-warehouse"></i>&nbsp;Emplacements</a></li>
    <li class="active"><a href="../pages/lieuSortie.php"><i class="fas fa-door-closed"></i>&nbsp;Lieux de sortie</a></li>
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
            <div class="col-lg-8">
                <h1 class="page-header text-primary">
                    Lieux de sortie
                </h1>
            </div>
            <div class="col-lg-3">
                <br /><br /><br />
                <i class="fas fa-search"></i>&nbsp;&nbsp;<input type="text" id="myInput" onkeyup="searchFunction()" placeholder="Rechercher..">
            </div>
            <br /><br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalLieuSortieAdd" data-toggle="modal" title="Ajouter">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>Lieu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM tlieusortie INNER JOIN tunitegestion ON tlieusortie.tunitegestionFK = tunitegestion.tunitegestionPK ORDER BY nomUniteGestion, nomLieuSortie");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr tlieusortiePK="<?php echo $row["tlieusortiePK"]; ?>">
                                    <td><?php echo $row["nomUniteGestion"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLieuSortie"]; ?></td>
                                    <td>
                                        <button class="view btn btn-success" data-target="#myModalLieuSortieView" data-toggle="modal" data-id="<?php echo $row["tlieusortiePK"]; ?>" data-nom-lieu="<?php echo $row["nomLieuSortie"]; ?>" data-nom-ug="<?php echo $row["nomUniteGestion"]; ?>" title="Voir">
                                            <i class="far fa-eye"></i>
                                        </button>&nbsp;
                                        <button class="update btn btn-primary" data-target="#myModalLieuSortieUpdate" data-toggle="modal" data-id="<?php echo $row["tlieusortiePK"]; ?>" data-nom-lieu=<?php echo $row["nomLieuSortie"]; ?> data-ug-id="<?php echo $row["tunitegestionFK"]; ?>" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" data-target="#myModalLieuSortieDelete" data-toggle="modal" data-id="<?php echo $row["tlieusortiePK"]; ?>" title="Supprimer">
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
<div class="modal fade" id="myModalLieuSortieAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Ajouter un lieu de sortie</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <form id="lieuSortie_form">
                            <tr>
                                <th>Unité de gestion</th>
                                <td>
                                    <select class="form-control" id="tunitegestionFK_a" name="tunitegestionFK_a" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tunitegestion");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tunitegestionPK"]; ?>"><?php echo $row["nomUniteGestion"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Nom</th>
                                <td><input class="form-control" id="nomLieuSortie_a" name="nomLieuSortie_a" size="40px" required><b></b></td>
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
<div class="modal fade" id="myModalLieuSortieView">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title" id="afficherViewNomLieuSortie"></h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Désignation</th>
                                <th>Type de produit</th>
                                <th>Raison de sortie</th>
                                <th>Quantité</th>
                                <th>Technicien</th>
                            </tr>
                        </thead>
                        <tbody id="lieuSortie_details">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal libellé Update-->
<div class="modal fade" id="myModalLieuSortieUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title" id="afficherUpdateNomLieuSortie"></h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <tr>
                            <th>Unité de gestion</th>
                            <td>
                                <select class="form-control" id="tunitegestionFK_u" name="tunitegestionFK_u" required>
                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM tunitegestion");
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?php echo $row["tunitegestionPK"]; ?>"><?php echo $row["nomUniteGestion"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Nom</th>
                            <td><input class="form-control" id="nomLieuSortie_u" name="nom" size="40px" value="<?php echo '$nomLieuSortie'; ?>" required><b></b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="hidden" id="tlieusortiePK_u" name="tlieusortiePK_u" name="type">
                <button type="submit" class="btn btn-primary" id="update" title="Modifier">
                    <span class="fas fa-pen"></span> Modifier
                </button>
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
            </div>
        </div>
    </div>
</div>

<!-- The Modal libellé Delete-->
<div class="modal fade" id="myModalLieuSortieDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer un lieu de sortie</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tlieusortiePK_d" name="tlieusortiePK" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer ce lieu de sortie ?</p>
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

<script src="../js/script/lieuSortie-script.js"></script>

<?php include("../template/footer.php"); ?>
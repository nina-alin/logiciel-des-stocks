<?php include("../template/header.php");
include("../template/dropdown.php"); ?>

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
        <li>
            <a href="stocks.php">Stocks</a>
        </li>
        <li>
            <a href="sorties.php">Dernières sorties</a>
        </li>
        <li class="active">
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
            <div class="col-lg-10">
                <h1 class="page-header text-primary">
                    Réforme
                </h1>
            </div>
            <br /><br />
            <button class="btn btn-success" data-target="#myModalReformeExport" data-toggle="modal" title="Exporter">
                <i class="fas fa-file-export"></i>
            </button>
            <button class="btn btn-warning" data-target="#myModalReformeAdd" data-toggle="modal" title="Ajouter">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive table-hover col-lg-12">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                        <thead>
                            <tr>
                                <th tabindex="0" aria-controls="dataTables-example">Fabricant</th>
                                <th tabindex="1" aria-controls="dataTables-example">Produit</th>
                                <th tabindex="2" aria-controls="dataTables-example">Technicien</th>
                                <th tabindex="3" aria-controls="dataTables-example">Date de réforme</th>
                                <th tabindex="4" aria-controls="dataTables-example">Numéro de série</th>
                                <th tabindex="5" aria-controls="dataTables-example">État de fonctionnement</th>
                                <th tabindex="6" aria-controls="dataTables-example">Motif de réforme</th>
                                <th tabindex="7" aria-controls="dataTables-example">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM treforme JOIN tcaracteristiquesproduits ON treforme.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN ttypeproduits ON tcaracteristiquesproduits.ttypeproduitsFK = ttypeproduits.ttypeproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN ttechnicien ON treforme.ttechnicienFK = ttechnicien.ttechnicienPK JOIN tnumerosseries ON tnumerosseries.tnumerosseriesPK = treforme.tnumerosseriesFK");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr treformePK="<?php echo $row["treformePK"]; ?>">
                                    <td><?php echo $row["nomFabricant"]; ?></td>
                                    <td><?php echo $row["nomModele"]; ?></td>
                                    <td><?php echo $row["prenomTechnicien"]; ?>&nbsp;<?php echo $row["nomTechnicien"]; ?></td>
                                    <td><?php setlocale(LC_TIME, "fr_FR", "French");
                                        echo strftime("%d/%m/%G", strtotime($row["dateReforme"]));
                                        ?></td>
                                    <td><?php echo $row["numeroSerie"]; ?></td>
                                    <td><?php echo $row["etatFonctionnement"]; ?></td>
                                    <td><?php echo $row["motifReforme"]; ?></td>
                                    <td>
                                        <button class="update btn btn-primary" data-target="#myModalReformeUpdate" data-toggle="modal" data-id="<?php echo $row["treformePK"]; ?>" data-id-caracteristiques="<?php echo $row["tcaracteristiquesproduitsFK"]; ?>" data-fonctionnement="<?php echo $row["etatFonctionnement"]; ?>" data-id-technicien="<?php echo $row["ttechnicienFK"]; ?>" data-numero="<?php echo $row["tnumerosseriesFK"]; ?>" data-reforme="<?php echo $row["motifReforme"]; ?>" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" data-target="#myModalReformeDelete" data-toggle="modal" data-id="<?php echo $row["treformePK"]; ?>" title="Supprimer">
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
<div class="modal fade" id="myModalReformeAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Ajouter un produit à la réforme</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <form id="reforme_form">
                            <tr>
                                <th>Produit</th>
                                <td>
                                    <select class="form-control" id="tcaracteristiquesproduitsFK_a" name="tcaracteristiquesproduitsFK_a" value="" onchange="changerGlobalId_Add()" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tcaracteristiquesproduits JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK ORDER BY nomFabricant, nomModele");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>"><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>État de fonctionnement</th>
                                <td><input class="form-control" id="etatFonctionnement_a" name="etatFonctionnement_a" size="40px" type="text"><b></b></td>
                            </tr>
                            <tr>
                                <th>Technicien</th>
                                <td>
                                    <select class="form-control" id="ttechnicienFK_a" name="ttechnicienFK_a" value="" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM ttechnicien WHERE toujoursService=1");
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
                                <th>Motif de réforme</th>
                                <td><input class="form-control" id="motifReforme_a" name="motifReforme_a" size="40px" type="text"><b></b></td>
                            </tr>
                            <tr id="showNumeroSerie_Add"></tr>
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

<!-- The Modal libellé Update-->
<div class="modal fade" id="myModalReformeUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Modifier un produit envoyé à la réforme</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <form id="update_form">
                            <tr>
                                <th>Produit</th>
                                <td>
                                    <select class="form-control" id="tcaracteristiquesproduitsFK_u" name="tcaracteristiquesproduitsFK_u" value="" onchange="changerGlobalId_Update()" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tcaracteristiquesproduits JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tcaracteristiquesproduitsPK"]; ?>"><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th>État de fonctionnement</th>
                                <td><input class="form-control" id="etatFonctionnement_u" name="etatFonctionnement_u" size="40px" value="" type="text"><b></b></td>
                            </tr>
                            <tr>
                                <th>Technicien</th>
                                <td>
                                    <select class="form-control" id="ttechnicienFK_u" name="ttechnicienFK_u" value="" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM ttechnicien WHERE toujoursService=1");
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
                                <th>Motif de réforme</th>
                                <td><input class="form-control" id="motifReforme_u" name="motifReforme_u" size="40px" type="text"><b></b></td>
                            </tr>
                            <tr id="showNumeroSerie_Update"></tr>
                        </form>
                    </table>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="hidden" id="treformePK_u" name="treformePK_u" name="type">
                <button type="submit" class="btn btn-primary" id="update" title="Modifier">
                    <span class="fas fa-pen"></span> Modifier
                </button>
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
            </div>
        </div>
    </div>
</div>

<!-- The Modal libellé Delete-->
<div class="modal fade" id="myModalReformeDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer un produit envoyé à la réforme</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="treformePK_d" name="treformePK_d" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer ce produit ?</p>
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

<!-- The Modal Reforme Export -->
<div class="modal fade" id="myModalReformeExport">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Exporter la liste des produits réformés</h4>
            </div>
            <form id="reforme_export">
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Date de début</th>
                                <td>
                                    <input type="date" class="form-control" id="dateDebut" name="dateDebut" size="40px" value="" required><b></b>
                                </td>
                            </tr>
                            <tr>
                                <th>Date de fin</th>
                                <td>
                                    <input type="date" class="form-control" id="dateFin" name="dateFin" size="40px" value="" required><b></b>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="export" title="Exporter">
                        <span class="fas fa-file-export"></span> Exporter
                    </button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/script/reforme-script.js"></script>

<?php include("../template/footer.php"); ?>
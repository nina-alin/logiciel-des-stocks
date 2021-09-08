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
        <li class="active">
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
            <div class="col-lg-11">
                <h1 class="page-header text-primary">
                    Besoins en produits
                </h1>
            </div>
            <br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalBesoinsAdd" data-toggle="modal">
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
                                <th>Produit</th>
                                <th>Type de produit</th>
                                <th>Plateforme</th>
                                <th>Quantité</th>
                                <th>Demandeur</th>
                                <th>Référence</th>
                                <th>Date de la demande</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM tbesoins JOIN tcaracteristiquesproduits ON tbesoins.tcaracteristiquesproduitsFK = tcaracteristiquesproduits.tcaracteristiquesproduitsPK JOIN ttypeproduits ON tcaracteristiquesproduits.ttypeproduitsFK = ttypeproduits.ttypeproduitsPK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN ttechnicien ON tbesoins.ttechnicienFK = ttechnicien.ttechnicienPK JOIN tplateforme ON tbesoins.tplateformeFK = tplateforme.tplateformePK ORDER BY dateDemande DESC");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr tbesoinsPK="<?php echo $row["tbesoinsPK"]; ?>">
                                    <td><a href="<?php echo $row["lien"]; ?>"><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></a></td>
                                    <td><?php echo $row["nomTypeProduit"]; ?></td>
                                    <td><?php echo $row["nomPlateforme"]; ?></td>
                                    <td><?php echo $row["quantiteDemande"]; ?></td>
                                    <td><?php echo $row["prenomTechnicien"]; ?>&nbsp;<?php echo $row["nomTechnicien"]; ?></td>
                                    <td><?php echo $row["reference"]; ?></td>
                                    <td><?php setlocale(LC_TIME, "fr_FR", "French");
                                        echo strftime("%d/%m/%G", strtotime($row["dateDemande"]));
                                        ?></td>
                                    <td>
                                        <button class="delete btn btn-success" data-target="#myModalBesoinsDelete" data-toggle="modal" data-id="<?php echo $row["tbesoinsPK"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" title="Valider">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button class="refuser btn btn-danger" data-target="#myModalBesoinsRefuser" data-toggle="modal" data-id="<?php echo $row["tbesoinsPK"]; ?>" data-fabricant="<?php echo $row["nomFabricant"]; ?>" data-modele="<?php echo $row["nomModele"]; ?>" title="Refuser">
                                            <i class="fas fa-times"></i>
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

<!-- The Modal besoin Add-->
<div class="modal fade" id="myModalBesoinsAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title">Ajouter un besoin de produit</h4>
            </div>
            <form id="plateforme">
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Produit</th>
                                <td>
                                    <select class="form-control" id="tcaracteristiquesproduitsFK_a" name="tcaracteristiquesproduitsFK_a" value="" required>
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
                                <th>Lien</th>
                                <td><input class="form-control" id="lien_a" name="lien_a" size="40px" value="" required><b></b></td>
                            </tr>
                            <tr>
                                <th>Demandeur</th>
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
                                <th>Plateforme</th>
                                <td>
                                    <select class="form-control" id="tplateformeFK_a" name="tplateformeFK_a" value="" required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tplateforme");
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row["tplateformePK"]; ?>"><?php echo $row["nomPlateforme"]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Quantité</th>
                                <td><input class="form-control" id="quantiteDemande_a" name="quantiteDemande_a" size="40px" value="" min=1 type="number" required><b></b></td>
                            </tr>
                            <tr>
                                <th>Référence</th>
                                <td><input class="form-control" id="reference_a" name="reference_a" size="40px" value=""><b></b></td>
                            </tr>
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
            </form>
        </div>
    </div>
</div>

<!-- The Modal libellé Delete-->
<div class="modal fade" id="myModalBesoinsDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title" id="afficherAccepterDemande"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tbesoinsPK_d" name="tbesoinsPK_d" class="form-control">
                    <p>Êtes-vous sûr de vouloir valider cette demande ? Cela aura pour effet de la supprimer.</p>
                    <p class="text-warning"><small>Cette action ne peut pas être annulée. L'informaticien ayant émis la demande recevra un mail.</small></p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="delete" title="Supprimer">Valider</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal besoin refus -->
<div class="modal fade" id="myModalBesoinsRefuser">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title" id="afficherRefuserDemande"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tbesoinsPK_r" name="tbesoinsPK_r" class="form-control">
                    <p>Êtes-vous sûr de vouloir refuser cette demande ? Cela aura pour effet de la supprimer.</p>
                    <p class="text-warning"><small>Cette action ne peut pas être annulée. L'informaticien ayant émis la demande recevra un mail.</small></p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="refuser" title="Supprimer">Refuser</button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/script/besoins-script.js"></script>

<?php include("../template/footer.php"); ?>
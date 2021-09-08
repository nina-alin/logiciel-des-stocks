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
        <li class="active">
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
            <div class="col-lg-11">
                <h1 class="page-header text-primary">
                    Commandes
                </h1>
            </div>
            <br /><br />
            <div class="col-1">
                <button class="btn btn-warning" data-target="#myModalCommandeAdd" data-toggle="modal" title="Ajouter">
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
                                <th tabindex="0" aria-controls="dataTables-example">Numéro de commande</th>
                                <th tabindex="1" aria-controls="dataTables-example">Date</th>
                                <th tabindex="2" aria-controls="dataTables-example">La commande est-elle arrivée ?</th>
                                <th tabindex="3" aria-controls="dataTables-example"> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM tcommandes ORDER BY dateCommande DESC");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <tr tcommandesPK="<?php echo $row["tcommandesPK"]; ?>">
                                    <td><?php echo $row["numeroCommande"]; ?></td>
                                    <td><?php setlocale(LC_TIME, "fr_FR", "French");
                                        echo strftime("%d/%m/%G", strtotime($row["dateCommande"]));
                                        ?></td>
                                    <td><?php if ($row["arrivee"] == 1) { ?>
                                            Oui
                                        <?php } else if ($row["arrivee"] == 0) { ?>
                                            Non
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ($row["arrivee"] == 1) { ?>
                                            <button class="view btn btn-success" data-target="#myModalCommandeView" data-toggle="modal" data-id="<?php echo $row["tcommandesPK"]; ?>" data-numero="<?php echo $row["numeroCommande"]; ?>" title="Voir">
                                                <i class="far fa-eye"></i>
                                            </button>&nbsp;
                                        <?php } ?>
                                        <button class="update btn btn-primary" data-target="#myModalCommandeUpdate" data-toggle="modal" data-id="<?php echo $row["tcommandesPK"]; ?>" data-numero="<?php echo $row["numeroCommande"]; ?>" data-date="<?php echo $row["dateCommande"]; ?>" data-arrivee="<?php echo $row["arrivee"]; ?>" title="Modifier">
                                            <i class=" fas fa-pen"></i>
                                        </button>&nbsp;
                                        <button class="delete btn btn-danger" data-target="#myModalCommandeDelete" data-toggle="modal" data-id="<?php echo $row["tcommandesPK"]; ?>" title="Supprimer">
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

<!-- The Modal Commande Add-->
<div class="modal fade" id="myModalCommandeAdd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Annuler">&times;</button>
                <h4 class="modal-title">Ajouter une commande</h4>
            </div>
            <form id="commande_form">
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Numéro de commande</th>
                                <td><input class="form-control" id="numeroCommande_a" name="numeroCommande_a" size="40px" value="" type="number" required><b></b></td>
                            </tr>
                            <tr>
                                <th>Date de commande</th>
                                <td><input type="date" class="form-control" id="dateCommande_a" name="dateCommande_a" value="" required><b></b></td>
                            </tr>
                            <tr>
                                <th>La commande est-elle arrivée ?</th>
                                <td>
                                    <input type="radio" id="arrivee_a" name="arrivee_a" value="1" checked required>&nbsp;Oui
                                    <input type="radio" id="arrivee_a" name="arrivee_a" value="0" required>&nbsp;Non
                                </td>
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

<!-- The Modal commande view-->
<div class="modal fade" id="myModalCommandeView">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title" id="afficherViewNumeroCommande"></h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="doubleU" style="display: none;"></div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Fabricant</th>
                                <th>Nom des produits</th>
                                <th>Quantité</th>
                                <th>Technicien</th>
                            </tr>
                        </thead>
                        <tbody id="produitsCommandeList">
                        </tbody>
                    </table>
                </div>
                <small>Pour ajouter des nouveaux produits à cette commande, rendez-vous à la page <a href="stocks.php">stocks</a>.</small>
            </div>
        </div>
    </div>
</div>

<!-- The Modal libellé Update-->
<div class="modal fade" id="myModalCommandeUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                <h4 class="modal-title" id="afficherUpdateNumeroCommande"></h4>
            </div>
            <form id="update_form">
                <!-- Modal body -->
                <div class="modal-body">
                    <div id="doubleU" style="display: none;"></div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                            <tr>
                                <th>Numéro de commande</th>
                                <td><input class="form-control" id="numeroCommande_u" name="numeroCommande_u" size="40px" value="" type="number" required><b></b></td>
                            </tr>
                            <tr>
                                <th>Date de commande</th>
                                <td><input type="date" class="form-control" id="dateCommande_u" name="dateCommande_u" value="" required><b></b></td>
                            </tr>
                            <tr>
                                <th>La commande est-elle arrivée ?</th>
                                <td>
                                    <input type="radio" id="arrivee_u" name="arrivee_u" value="1" required>&nbsp;Oui
                                    <input type="radio" id="arrivee_u" name="arrivee_u" value="0" required>&nbsp;Non
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" id="tcommandesPK_u" name="tcommandesPK_u" name="type">
                    <button type="submit" class="btn btn-primary" id="update" title="Modifier">
                        <span class="fas fa-pen"></span> Modifier
                    </button>
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler" title="Annuler">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- The Modal Commande Delete-->
<div class="modal fade" id="myModalCommandeDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" title="Fermer">&times;</button>
                    <h4 class="modal-title">Supprimer une commande</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tcommandesPK_d" name="tcommandesPK_d" class="form-control">
                    <p>Êtes-vous sûr de vouloir supprimer cette commande ?</p>
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

<script src="../js/script/commandes-script.js"></script>

<?php include("../template/footer.php"); ?>
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
        <li class="active">
            <a href="sorties.php">Dernières sorties</a>
        </li>
        <li>
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
            <div class="col-lg-12">
                <h1 class="page-header text-primary">
                    Dernières sorties
                </h1>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive table-hover col-lg-12">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th tabindex="0" aria-controls="dataTables-example">Désignation</th>
                                    <th tabindex="1" aria-controls="dataTables-example">Raison de sortie</th>
                                    <th tabindex="2" aria-controls="dataTables-example">Lieu de sortie</th>
                                    <th tabindex="3" aria-controls="dataTables-example">Quantité</th>
                                    <th tabindex="4" aria-controls="dataTables-example">Date de sortie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = mysqli_query($conn, "SELECT * FROM tsorties JOIN tcaracteristiquesproduits ON tcaracteristiquesproduits.tcaracteristiquesproduitsPK = tsorties.tcaracteristiquesproduitsFK JOIN tfabricants ON tcaracteristiquesproduits.tfabricantsFK = tfabricants.tfabricantsPK JOIN tlieusortie ON tsorties.tlieusortieFK = tlieusortie.tlieusortiePK JOIN ttypeproduits ON tcaracteristiquesproduits.ttypeproduitsFK = ttypeproduits.ttypeproduitsPK JOIN ttechnicien ON ttechnicien.ttechnicienPK = tsorties.ttechnicienFK JOIN tunitegestion ON tunitegestion.tunitegestionPK = tlieusortie.tunitegestionFK ORDER BY dateSortie");
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr tproduitsstockes="<?php echo $row["tsortiesPK"]; ?>">
                                        <td><?php echo $row["nomFabricant"]; ?>&nbsp;<?php echo $row["nomModele"]; ?></td>
                                        <td><?php echo $row["raisonSortie"]; ?></td>
                                        <td><?php echo $row["nomUniteGestion"]; ?>&nbsp;-&nbsp;<?php echo $row["nomLieuSortie"]; ?></td>
                                        <td><?php echo $row["quantiteSortie"]; ?></td>
                                        <td><?php setlocale(LC_TIME, "fr_FR", "French");
                                            echo strftime("%d/%m/%G", strtotime($row["dateSortie"]));
                                            ?></td>
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

<?php include("../template/footer.php"); ?>
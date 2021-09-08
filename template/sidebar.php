<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li>
            <a href="../pages/dashboard.php"> Dashboard <span class="badge badge-danger" style="background-color:red;">
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
            <a href="../pages/stocks.php">Stocks</a>
        </li>
        <li>
            <a href="../pages/sorties.php">Dernières sorties</a>
        </li>
        <li>
            <a href="../pages/reforme.php">Réforme</a>
        </li>
        <li>
            <a href="../pages/commandes.php">Commandes</a>
        </li>
        <li>
            <a href="../pages/besoins.php">Besoins en produits <span class="badge badge-primary" style="background-color:blue;">
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
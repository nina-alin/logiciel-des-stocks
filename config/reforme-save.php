<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $tnumerosseriesFK = $_POST['tnumerosseriesFK'];
        $etatFonctionnement = $_POST['etatFonctionnement'];
        $ttechnicienFK = $_POST['ttechnicienFK'];
        $tcaracteristiquesproduitsFK = $_POST['tcaracteristiquesproduitsFK'];
        $motifReforme = $_POST['motifReforme'];

        $etatFonctionnement = addslashes($etatFonctionnement);
        $motifReforme = addslashes($motifReforme);

        $sql = "INSERT INTO `treforme`(`tnumerosseriesFK`, `etatFonctionnement`, `ttechnicienFK`, `tcaracteristiquesproduitsFK`,`motifReforme`) VALUES ('$tnumerosseriesFK','$etatFonctionnement','$ttechnicienFK','$tcaracteristiquesproduitsFK','$motifReforme');";
        $sql .= "UPDATE tnumerosseries SET reforme=1 WHERE tnumerosseriesPK=$tnumerosseriesFK;";

        if (mysqli_multi_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// UPDATE
if (count($_POST) > 0) {

    if ($_POST['type'] == 2) {

        $treformePK = $_POST['treformePK'];
        $tcaracteristiquesproduitsFK = $_POST['tcaracteristiquesproduitsFK'];
        $etatFonctionnement = $_POST['etatFonctionnement'];
        $ttechnicienFK = $_POST['ttechnicienFK'];
        $tnumerosseriesFK = $_POST['tnumerosseriesFK'];
        $motifReforme = $_POST['motifReforme'];

        $motifReforme = addslashes($motifReforme);
        $etatFonctionnement = addslashes($etatFonctionnement);

        $sql = "UPDATE `treforme` SET `tnumerosseriesFK`='$tnumerosseriesFK',`etatFonctionnement`='$etatFonctionnement',`ttechnicienFK`='$ttechnicienFK',`tcaracteristiquesproduitsFK`='$tcaracteristiquesproduitsFK',`motifReforme`='$motifReforme' WHERE `treformePK`='$treformePK'";

        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// DELETE
if (count($_POST) > 0) {

    if ($_POST['type'] == 3) {

        $treformePK = $_POST['treformePK'];

        $sql = "DELETE FROM `treforme` WHERE treformePK=$treformePK";

        if (mysqli_query($conn, $sql)) {
            echo $treformePK;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// GET ADD 
if (count($_GET) > 0) {

    if ($_GET['type'] == 4) {

        $tproduitsstockesFK = $_GET['tcaracteristiquesproduitsFK'];

        $sql = "SELECT * FROM tnumerosseries WHERE tproduitsstockesFK=$tproduitsstockesFK AND reforme=0";

        // on affiche les numéros de séries reliés à ces produits
        $result = mysqli_query($conn, $sql);
        $output = '<th>Numéro de série</th><td><select class="form-control" id="tnumerosseriesFK_a" name="tnumerosseriesFK_a" value="" required>';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '
            <option value="' . $row["tnumerosseriesPK"] . '">' . $row["numeroSerie"] . '</option>
             ';
        }

        $output .= '</select></td>';

        echo $output;
    }
}

// GET UPDATE 
if (count($_GET) > 0) {

    if ($_GET['type'] == 5) {

        $tproduitsstockesFK = $_GET['tcaracteristiquesproduitsFK'];

        $sql = "SELECT * FROM tnumerosseries WHERE tproduitsstockesFK=$tproduitsstockesFK";

        $result = mysqli_query($conn, $sql);
        $output = '<th>Numéro de série</th><td><select class="form-control" id="tnumerosseriesFK_u" name="tnumerosseriesFK_u" value="" required>';

        while ($row = mysqli_fetch_array($result)) {
            $output .= '
            <option value="' . $row["tnumerosseriesPK"] . '">' . $row["numeroSerie"] . '</option>
             ';
        }

        $output .= '</select></td>';

        echo $output;
    }
}

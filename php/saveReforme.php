<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $numeroSerie = $_POST['numeroSerie'];
        $etatFonctionnement = $_POST['etatFonctionnement'];
        $ttechnicienFK = $_POST['ttechnicienFK'];
        $tcaracteristiquesproduitsFK = $_POST['tcaracteristiquesproduitsFK'];
        $sql = "INSERT INTO `treforme`(`numeroSerie`, `etatFonctionnement`, `ttechnicienFK`, `tcaracteristiquesproduitsFK`) VALUES ('$numeroSerie','$etatFonctionnement','$ttechnicienFK','$tcaracteristiquesproduitsFK')";
        if (mysqli_query($conn, $sql)) {
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
        $numeroSerie = $_POST['numeroSerie'];
        $sql = "UPDATE `treforme` SET `numeroSerie`='$numeroSerie',`etatFonctionnement`='$etatFonctionnement',`ttechnicienFK`='$ttechnicienFK',`tcaracteristiquesproduitsFK`='$tcaracteristiquesproduitsFK' WHERE `treformePK`='$treformePK'";
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

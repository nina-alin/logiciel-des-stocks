<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomUniteGestion = $_POST['nomUniteGestion'];

        // Encodage des guillemets / apostrophes
        $nomUniteGestion = addslashes($nomUniteGestion);

        $sql = "INSERT INTO `tunitegestion`(`nomUniteGestion`) VALUES ('$nomUniteGestion')";

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

        $tunitegestionPK = $_POST['tunitegestionPK'];
        $nomUniteGestion = $_POST['nomUniteGestion'];

        // Encodage des guillemets / apostrophes
        $nomUniteGestion = addslashes($nomUniteGestion);

        $sql = "UPDATE `tunitegestion` SET `nomUniteGestion` = '$nomUniteGestion' WHERE `tunitegestionPK` = $tunitegestionPK;";

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

        $tunitegestionPK = $_POST['tunitegestionPK'];

        $sql = "DELETE FROM `tunitegestion` WHERE tunitegestionPK=$tunitegestionPK ";

        if (mysqli_query($conn, $sql)) {
            echo $tunitegestionPK;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

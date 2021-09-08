<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomPlateforme = $_POST['nomPlateforme'];

        // Encodage des guillemets / apostrophes
        $nomPlateforme = addslashes($nomPlateforme);

        $sql = "INSERT INTO `tplateforme`(`nomPlateforme`) VALUES ('$nomPlateforme')";

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

        $tplateformePK = $_POST['tplateformePK'];
        $nomPlateforme = $_POST['nomPlateforme'];

        // Encodage des guillemets / apostrophes
        $nomPlateforme = addslashes($nomPlateforme);

        $sql = "UPDATE `tplateforme` SET `nomPlateforme` = '$nomPlateforme' WHERE `tplateformePK` = $tplateformePK;";

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

        $tplateformePK = $_POST['tplateformePK'];

        $sql = "DELETE FROM `tplateforme` WHERE tplateformePK=$tplateformePK ";

        if (mysqli_query($conn, $sql)) {
            echo $tplateformePK;
        } else {
            echo mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {

    if ($_POST['type'] == 1) {

        $nomEmplacement = $_POST['nomEmplacement'];

        // Encodage des guillemets / apostrophes
        $nomEmplacement = addslashes($nomEmplacement);

        $sql = "INSERT INTO `templacements`(`nomEmplacement`) VALUES ('$nomEmplacement')";

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

        $templacementsPK = $_POST['templacementsPK'];
        $nomEmplacement = $_POST['nomEmplacement'];

        // Encodage des guillemets / apostrophes
        $nomEmplacement = addslashes($nomEmplacement);

        $sql = "UPDATE `templacements` SET `nomEmplacement` = '$nomEmplacement' WHERE `templacementsPK` = $templacementsPK;";

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

        $templacementsPK = $_POST['templacementsPK'];

        $sql = "DELETE FROM `templacements` WHERE templacementsPK=$templacementsPK ";

        if (mysqli_query($conn, $sql)) {
            echo $templacementsPK;
        } else {
            echo mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

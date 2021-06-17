<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {
        $nomTechnicien = $_POST['nomTechnicien'];
        $fonction = $_POST['fonction'];
        $toujoursService = $_POST['toujoursService'];
        $sql = "INSERT INTO `ttechnicien`(`nomTechnicien`,`fonction`,`toujoursService`) 
		VALUES ('$nomTechnicien','$fonction','$toujoursService')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// UPDATE
if (count($_POST) > 0) {
    if ($_POST['type'] == 2) {
        $ttechnicienPK = $_POST['ttechnicienPK'];
        $nomTechnicien = $_POST['nomTechnicien'];
        $fonction = $_POST['fonction'];
        $toujoursService = $_POST['toujoursService'];
        $sql = "UPDATE `ttechnicien` SET `nomTechnicien` = '$nomTechnicien',`fonction` = '$fonction',`toujoursService` = '$toujoursService' WHERE `ttechnicien`.`ttechnicienPK` = $ttechnicienPK;";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(array("statusCode" => 200));
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

// DELETE
if (count($_POST) > 0) {
    if ($_POST['type'] == 3) {
        $ttechnicienPK = $_POST['ttechnicienPK'];
        $sql = "DELETE FROM `ttechnicien` WHERE ttechnicienPK=$ttechnicienPK ";
        if (mysqli_query($conn, $sql)) {
            echo $ttechnicienPK;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

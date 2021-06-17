<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {
        $nomMarque = $_POST['nomMarque'];
        $sql = "INSERT INTO `tmarques`(`nomMarque`) 
		VALUES ('$nomMarque')";
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
        $tmarquesPK = $_POST['tmarquesPK'];
        $nomMarque = $_POST['nomMarque'];
        $sql = "UPDATE `tmarques` SET `nomMarque` = '$nomMarque' WHERE `tmarques`.`tmarquesPK` = $tmarquesPK;";
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
        $tmarquesPK = $_POST['tmarquesPK'];
        $sql = "DELETE FROM `tmarques` WHERE tmarquesPK=$tmarquesPK ";
        if (mysqli_query($conn, $sql)) {
            echo $tmarquesPK;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

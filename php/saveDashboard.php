<?php

include 'connect.php';

// DELETE
if (count($_POST) > 0) {
    if ($_POST['type'] == 3) {
        $tproduitsstockesPK = $_POST['tproduitsstockesPK'];
        $sql = "UPDATE `tproduitsstockes` SET `alerte`=0 WHERE  `tproduitsstockesPK`=$tproduitsstockesPK";
        if (mysqli_query($conn, $sql)) {
            echo $tproduitsstockesPK;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}

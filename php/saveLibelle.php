<?php

include 'connect.php';

// POST
if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {
        $nomLibelle = $_POST['nomLibelle'];
        $templacementFK = $_POST['templacementFK'];
        $sql = "INSERT INTO `tlibelles`( `nomLibelle`, `templacementFK`) 
		VALUES ('$nomLibelle','$templacementFK')";
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
        $tlibellesPK = $_POST['tlibellePK'];
        $nomLibelle = $_POST['nomLibelle'];
        $templacementFK = $_POST['templacementFK'];
        $sql = "UPDATE `tlibelles` SET `tlibellesPK`='$tlibellesPK',`nomLibelle`='$nomLibelle',`templacementFK`='$templacementFK' WHERE tlibellesPK=$tlibellesPK";
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
        $tlibellePK = $_POST['tlibellePK'];
        $sql = "DELETE FROM `tlibelles` WHERE tlibellesPK=$tlibellesPK ";
        if (mysqli_query($conn, $sql)) {
            echo $tlibellesPK;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}


/*if (count($_POST) > 0) {
    if ($_POST['type'] == 4) {
        $id = $_POST['id'];
        $sql = "DELETE FROM crud WHERE id in ($id)";
        if (mysqli_query($conn, $sql)) {
            echo $id;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}*/
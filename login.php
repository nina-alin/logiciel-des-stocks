<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Nina Alin">

    <title>Logiciel des stocks</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>
<style>
    /* Bordered form */
    form {
        border: 3px solid #f1f1f1;
    }

    /* Full-width inputs */
    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* Set a style for all buttons */
    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    /* Add a hover effect for buttons */
    button:hover {
        opacity: 0.8;
    }

    /* Extra style for the cancel button (red) */
    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    /* Center the avatar image inside this container */
    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    /* Avatar image */
    img.avatar {
        width: 10%;
        border-radius: 50%;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* The "Forgot password" text */
    span.psw {
        float: right;
        padding-top: 16px;
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }

        .cancelbtn {
            width: 100%;
        }
    }
</style>
<?php
/*
Script Name: ldapLogin.php
Author: Riontino Raffaele
Author URI: https://www.lelezapp.it/
Description: example script for ldap authentication in PHP
Version: 1.0
*/

$ldapDomain = "@crous-lille.fr";             // set here your ldap domain
$ldapHost = "ldap://10.247.192.202";     // set here your ldap host
$ldapPort = "389";                         // ldap Port (default 389)
$ldapUser  = "";                         // ldap User (rdn or dn)
$ldapPassword = "";                     // ldap associated Password  

$successMessage = "";
$errorMessage = "";

// connect to ldap server
$ldapConnection = ldap_connect($ldapHost, $ldapPort)
    or die("Could not connect to Ldap server.");

if (isset($_POST["ldapLogin"])) {

    if ($ldapConnection) {

        if (isset($_POST["user"]) && $_POST["user"] != "")
            $ldapUser = addslashes(trim($_POST["user"]));
        else
            $errorMessage = "Invalid User value!!";

        if (isset($_POST["password"]) && $_POST["password"] != "")
            $ldapPassword = addslashes(trim($_POST["password"]));
        else
            $errorMessage = "Invalid Password value!!";

        if ($errorMessage == "") {
            // binding to ldap server
            ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
            ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);
            $ldapbind = @ldap_bind($ldapConnection, $ldapUser . $ldapDomain, $ldapPassword);

            // verify binding
            if ($ldapbind) {
                /* ldap_close($ldapConnection);    // close ldap connection
                $successMessage = "Login done correctly!!";*/
                session_start();
                $_SESSION['username'] = $ldapUser;
                echo 'Vous êtes connecté !';
                header("Location: dashboard.php");
            } else
                $errorMessage = "Invalid credentials!";
        }
    }
}
?>
<html>

<body data-rsssl=1 data-rsssl=1>
    <?php
    if ($errorMessage != "") echo "<h3 style='color:blue;'>$errorMessage</h3>";
    if ($successMessage != "") echo "<h3 style='color:blue;'>$successMessage</h3>";
    ?>
    <form action="" method="post">
        <div class="imgcontainer">
            <img src="https://www.univ-lille3.fr/visuels/2016/printemps/logo-crous.png" alt="logo" class="avatar">
            <h3>Logiciel des stocks</h3>
        </div>

        <div class="container">
            <label for="user"><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrer le nom d'utilisateur" name="user" value="" maxlength="50" required>

            <label for="password"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="password" value="" maxlength="50" required>

            <button type="submit" name="ldapLogin" value="Ldap Login">Connexion</button>
        </div>
    </form>
</body>

</html>
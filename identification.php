<?php
ini_set('session.save_path', dirname('/var/www/html/session/session'));
ini_set('session.cookie_domain', '.crous-lille.fr');
@session_start();

//$index_principal=TRUE;
$_SESSION['Connected'] = FALSE;
$_SESSION['isStocksAdmin'] = FALSE;

require_once('libs/ad.php');

function stopError()
{
    echo '
	<div class="row">
		<div class="col-lg-9">
			<h1 class="page-header">Identification</h1>
				<div class="alert alert-danger">
                    IDENTIFICATION REFUS&Eacute;E : Les informations transmises n\'ont pas permis de vous authentifier.
                    Redémarrez votre navigateur.
                </div>
			</div>
		</div>
	</div>
	';
}

function nonAutorise()
{
    echo '
	<div class="row">
		<div class="col-lg-9">
			<h1 class="page-header">Identification</h1>
				<div class="alert alert-danger">
                    IDENTIFICATION REFUS&Eacute;E : Vous n\'êtes pas autorisé à accéder au logiciel des stocks. Contactez la DSI.
                </div>
			</div>
		</div>
	</div>
	';
}

if (!isset($_SESSION['user_email']) || is_null($_SESSION['user_email']) || $_SESSION['user_email'] == "") {
    stopError();
    exit();
}

/*
 *  Authentification
 */

$user = new ad();
//var_dump($user->authenticate_o365());
//exit();
if ($user->authenticate_o365()) {
    if ($user->getEntriesOf($_SESSION['user_email'])) {

        $_SESSION['Connected'] = TRUE;
        $_SESSION['isStocksAdmin'] = FALSE;

        $_SESSION['nom'] = $user->getNomPrenom();
        $_SESSION['nom'] = utf8_encode($_SESSION['nom']);

        if (!isset($_SESSION['nom']) || is_null($_SESSION['nom']) || $_SESSION['nom'] == "")
            $_SESSION['nom'] = explode("@", $_SESSION['user_email'])[0];

        $_SESSION['mail'] = $user->getAdressMail();

        if ($user->checkGroup('CN=grp-dsi,OU=DSI,OU=SERVICES CENTRAUX,DC=crous-lille,DC=fr')) {
            $_SESSION['isStocksAdmin'] = TRUE;
        }

        if (!$_SESSION['isStocksAdmin']) {
            nonAutorise();
        } else {
            header('location:./');
        }
    } else {
        stopError();
    }
} else {
    stopError();
}

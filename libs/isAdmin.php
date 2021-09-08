<?php
/*
 * Controle si StocksAdmin
 */
ini_set('session.save_path', dirname('/var/www/html/session/session'));
ini_set('session.cookie_domain', '.crous-lille.fr');
@session_start();
if (!isset($_SESSION['isStocksAdmin']) || empty($_SESSION['isStocksAdmin'])) {
	$_SESSION['isStocksAdmin'] = FALSE;
}

if ($_SESSION['isStocksAdmin'] == FALSE) {
	echo ("<script language=\"javascript\">
				alert('Acc\u00e8s refus\u00e9 \u00e0 cette page');
				location.href='http://ent.crous-lille.fr';
		   </script>");
}

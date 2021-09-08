<?php
session_destroy();
header("Location: https://login.microsoftonline.com/common/oauth2/logout?ui_locales=fr-FR&mkt=fr-FR");

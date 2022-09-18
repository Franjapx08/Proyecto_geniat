<?php

/* errores */
ini_set('desiplay_errors', 1);
ini_set('log_errors', 1);

require_once "Controllers/RoutesController.php";

$index = new RoutesController();
$index->index();
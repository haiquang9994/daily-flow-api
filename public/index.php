<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

use Pho\Http\HttpProgram;

require dirname(__DIR__).'/bootstrap/load.php';
require dirname(__DIR__).'/bootstrap/http.php';

$pho_container = $app->buildContainer();
$app->run(HttpProgram::class);

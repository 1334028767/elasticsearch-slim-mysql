<?php
use App\Controller\SendController;
$app->group("/send",function() use ($app){
    $app->get('', SendController::class . ':SendAction');
});
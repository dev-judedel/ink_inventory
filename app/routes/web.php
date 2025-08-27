<?php
$router->group('/ink', function($r) {
    $r->get('/', 'InkInventoryController@index');
    $r->post('/', 'InkInventoryController@store');
    $r->get('/reorder', 'InkInventoryController@reorder');
    $r->get('/{id}', 'InkInventoryController@show');
    $r->post('/{id}/receive', 'InkInventoryController@receive');
    $r->post('/{id}/issue', 'InkInventoryController@issue');
    $r->post('/{id}/adjust', 'InkInventoryController@adjust');
});
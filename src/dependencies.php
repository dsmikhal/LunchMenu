<?php
/** DIC configuration */

$container = $app->getContainer();

/** view renderer */
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

/** monolog */
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['fridge'] = function ($c) {
    $settings = $c->get('settings')['fridge'];
    $ingredients = json_decode(file_get_contents($settings['file_path']), true);
    return $ingredients;
};

$container['recipes'] = function ($c) {
    $settings = $c->get('settings')['recipes'];
    $recipes = json_decode(file_get_contents($settings['file_path']), true);
    return $recipes;
};
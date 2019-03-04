<?php
/**
 * Returns array of settings back to the App
 *
 * @return array
 */
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Fridge data
        'fridge' => [
            'file_path' => __DIR__ . '/../src/data/ingredients.json',
        ],

        //Recipes
        'recipes' => [
            'file_path' => __DIR__ . '/../src/data/recipes.json',
        ],
    ],
];

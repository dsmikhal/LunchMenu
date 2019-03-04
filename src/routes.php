<?php

require_once __DIR__ . '/../src/helpers/Lunch.php';

use Slim\Http\Request;
use Slim\Http\Response;
use Menu\Lunch;

// Routes
$app->get('/lunch', function (Request $request, Response $response) {
    $this->logger->addInfo("Lunch menu");

    $menu = new Menu\Lunch($this->fridge, $this->recipes);

    if ($menu->findAvailableRecipes()) {
        $menuLunch = $menu->getAvailRecipes();
    } else {
        $menuLunch = [];
    }

    return $this->renderer->render(
        $response,
        'lunch.phtml',
        [
            'menu' => $menuLunch,
            'fridge' => count($menu->getFreshIngredientsList()),
            'recipes' => count($menu->getRecipes())
        ]
    );
}
);

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Framework '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
}
);
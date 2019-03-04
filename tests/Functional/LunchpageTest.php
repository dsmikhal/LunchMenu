<?php

namespace Tests\Functional;

class LunchpageTest extends BaseTestCase
{
    /**
     * Test that the Lunch route returns a rendered response containing the text 'Today's Menu' and at least one recipe found
     */
    public function testGetLunchpageTable()
    {
        $response = $this->runApp('GET', '/lunch',null,'test4');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Today\'s Menu', (string)$response->getBody());
        $this->assertNotContains('Total 0 recipes found', (string)$response->getBody());
    }

    /**
     * Test that the /lunch route won't accept a post request
     */
    public function testPostHomepageNotAllowed()
    {
        $response = $this->runApp('POST', '/lunch', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }

    /**
     * Test if Fresh Ingredients List empty:
     *  Zero recipes found,
     *  User notified there are no Ingredients
     */
    public function testEmptyIngredientsList()
    {
        $response = $this->runApp('GET', '/lunch', null, 'test1');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('You do not have fresh ingredients', (string)$response->getBody());
        $this->assertContains('Total 0 recipes found', (string)$response->getBody());
    }

    /**
     * Test if Recipes List empty:
     *  Zero recipes found,
     *  User notified there are no Recipes knows to the system
     */
    public function testEmptyRecipesList()
    {
        $response = $this->runApp('GET', '/lunch', null, 'test2');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Your Recipes knowledge base is empty', (string)$response->getBody());
        $this->assertContains('Total 0 recipes found', (string)$response->getBody());
    }

    /**
     * Test if no available Recipes found, having some Ingredients and recipes:
     *  Zero recipes found,
     *  User notified there are not enough Ingredients
     */
    public function testEmptyMenuList()
    {
        $response = $this->runApp('GET', '/lunch', null, 'test3');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('You do not have enough ingredients', (string)$response->getBody());
        $this->assertContains('Total 0 recipes found', (string)$response->getBody());
    }

    /**
     * Test that Ham and Cheese Toastie comes first in a list, as has all Ingredients best-before in future
     */
    public function testGetLunchRecipesOrder1()
    {
        $response = $this->runApp('GET', '/lunch',null,'test4');

        $html_page = new \DOMDocument();
        $html_page->loadHTML((string)$response->getBody());
        $recipe = $html_page->getElementById('recipe-0');

        $this->assertContains('Ham and Cheese Toastie', $recipe->textContent);
        $this->assertNotContains('Hotdog', $recipe->textContent);
    }

    /**
     * Test that Ham and Cheese Toastie comes first in a list, as has all Ingredients best-before in future
     */
    public function testGetLunchRecipesOrder2()
    {
        $response = $this->runApp('GET', '/lunch',null,'test5');

        $html_page = new \DOMDocument();
        $html_page->loadHTML((string)$response->getBody());
        $recipe = $html_page->getElementById('recipe-0');

        $this->assertContains('Hotdog', $recipe->textContent);
        $this->assertNotContains('Ham and Cheese Toastie', $recipe->textContent);
    }
}
# Lunch Menu : Slim Framework 3 Application

## Description

Rezdy Engineering Tech Task

User Story:
As a User I would like to make a request to an API that will determine from a set of recipes what I can have for lunch today based on the contents of my fridge, so that I can quickly decide what I’ll be having to eat and the ingredients required to prepare the meal.

Acceptance Criteria
- GIVEN that I am an API client AND have made a ​GET​ request to the ​/lunch​ endpoint THEN I should receive a JSON response of the recipes that I can prepare based on the availability of the ingredients in my fridge
- GIVEN that I am an API client AND I have made a ​GET​ request to the ​/lunch​ endpoint AND an ingredient is past its ​use-by​ date THEN I should not receive any recipes containing this ingredient
- GIVEN that I am an API client AND I have made a ​GET​ request to the endpoint AND an ingredient is past its ​best-before​ date AND is still within its date THEN any recipe containing this ingredient should be sorted to the bottom of the JSON response object

## Technical design

Application has 2 data files in JSON format:
 - src/data/ingredients.json
 - src/data/recipes.json 

 Date format in ingredients.json file should be 'yyyy-mm-dd'

JSON files organised as a containers of data inside of the application via dependencies component in src/dependecies.php. 
The location of JSON files can be changed via settings at src/settings.php.
    
Main logic class located at src/helpers/LunchMenu.php 
 
## Solution architecture 

1. In a first place logic checks all the ingredients and only take a list of having use-by not in a past - Fresh ingredients.
2. Read all the Recipes and check every component to be on a list of fresh ingredients, and save a minimal best-before date across involved components on a Recipe.
3. Final Recipes list construct: 
 - If all ingredients found, and best-before is in a future - add recipe in a beginning of menu list.
 - If all ingredients found, and best-before is in a past - add recipe to the end of menu list.


## Testing plan

According to acceptance criteria in the task.

1. Check the main page return StatusCode 200
2. Test that API does not accept POST call
3. Test List of Recipes found is Empty for no Fresh ingredients at all
4. Test List of Recipes found is Empty if no Recipes knows to the system
5. Test List of Recipes found is Empty if not enough Fresh ingredients in a fridge
6. Check the order of the Recipes on a the list: Recipes with best-before date in a past comes last

## Install

This application uses the latest Slim 3 Framework with the PHP-View template renderer. It also uses the Monolog logger.

Make clone of repository to your local machine with

    git clone https://github.com/dsmikhal/LunchMenu.git [app-name]

## Install dependencies

Run this command from the directory you have located a clone of repository

    cd [app-name]
    php composer.phar update

## Setup environment

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can run these commands 

	php composer.phar start

Run this command in the application directory to run the test suite

	php composer.phar test


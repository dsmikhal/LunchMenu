<?php
namespace Menu;

/**
 *
 * @class LunchMenu
 * @category technical task
 * @package Menu\Lunch
 * @link https://dsmikhal@bitbucket.org/dsmikhal/lunchmenu.git
 *
 * @author  Dmitrii Mikhalchenko <dsmikhal@gmail.com>
 *
 */
class Lunch
{
    /**
     * @var array Contains list of ingredients
     */
    private $_ingredients = [];
    /**
     * @var array Full list of Recipes
     */
    private $_recipes = [];
    /**
     * @var array List of fresh ingredients available
     */
    private $_fresh_ingredients = [];
    /**
     * @var array  List of available Recipes
     */
    private $_avail_recipes = [];

    /**
     * LunchMenu constructor.
     *
     * @param array $ingredients
     * @param array $recipes
     *
     * @return void
     */
    public function __construct($ingredients = [],$recipes = [])
    {
        if (count($ingredients) > 0)
            $this->setIngredients($ingredients['ingredients']);
        if (count($recipes) > 0)
            $this->setRecipes($recipes['recipes']);
    }

    /**
     * Find Recipes available to cook
     *
     * @return array
     */
    public function findAvailableRecipes()
    {
        $avalable_ing = $this->getFreshIngredients();
        if (count($avalable_ing) == 0) {
            return false;
        } else {
            $this->setFreshIngredientsList($avalable_ing);
        }
        $available_recipes = [];
        $date_now = $this->getTodayStampDate();

        foreach ($this->getRecipes() as $recipe) {
            $found = 0;
            $min_before = strtotime('now');
            foreach ($recipe['ingredients'] as $ing) {

                if (array_key_exists($ing, $avalable_ing)) {
                    $found++;
                    $min_before = min($min_before, $this->getDateStamp($avalable_ing[$ing]['best-before']));
                }
            }
            if ($found == count($recipe['ingredients'])) {
                $recipe['best_before'] = $min_before;
                if ($min_before < $date_now) {
                    array_push($available_recipes, $recipe);
                } else {
                    array_unshift($available_recipes, $recipe);
                }
            }
        }

        $this->setAvailRecipes($available_recipes);

        if (count($available_recipes) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Find ingredients with end-by not passed
     *
     * @return array
     */
    protected function getFreshIngredients()
    {
        $date_now = $this->getTodayStampDate();
        $fresh_ingredients = [];
        foreach ($this->getIngredients() as $item) {
            if ($this->getDateStamp($item['use-by']) > $date_now) {

                if ($this->getDateStamp($item['best-before']) > $date_now) {
                    $item['best'] = true;
                } else {
                    $item['best'] = false;
                }

                $fresh_ingredients[$item['title']] = $item;
            }
        }
        return $fresh_ingredients;
    }

    /**
     * Get a timestamp for the date given
     *
     * @description Get timeStamp for string date given
     * @param string $datestr date string var
     *
     * @return int
     */
    protected function getDateStamp($datestr)
    {
        $datestr = str_replace('/', '-', $datestr);
        $date =  Date_create($datestr);
        $date->setTime(0, 0, 0);

        return $date->getTimestamp();
    }

    /**
     * Get timestamp for the current date
     *
     * @description Get timeStamp for current datetime
     *
     * @return false|int
     */
    protected function getTodayStampDate()
    {
        $date =  strtotime('now');
        return $date;
    }

    /**
     * Get private var
     *
     * @return array
     */
    public function getAvailRecipes()
    {
        return $this->_avail_recipes;
    }

    /**
     * Set private var
     *
     * @param array|mixed $ingredients List of available ingredients
     * @return void
     */
    public function setIngredients($ingredients)
    {
        $this->_ingredients = $ingredients;
    }

    /**
     * Set private var
     *
     * @param array|mixed $recipes List of available Recipes
     * @return void
     */
    public function setRecipes($recipes)
    {
        $this->_recipes = $recipes;
    }

    /**
     * Set private var
     *
     * @param array $avail_recipes List of Recipes with available ingredients
     * @return void
     */
    public function setAvailRecipes($avail_recipes)
    {
        $this->_avail_recipes = $avail_recipes;
    }

    /**
     * Get private var
     *
     * @return array
     */
    public function getIngredients()
    {
        return $this->_ingredients;
    }

    /**
     * Get private var
     *
     * @return array
     */
    public function getRecipes()
    {
        return $this->_recipes;
    }

    /**
     * Get private var
     *
     * @return array
     */
    public function getFreshIngredientsList()
    {
        return $this->_fresh_ingredients;
    }

    /**
     * Set a list of all fresh ingredients available
     *
     * @param $fresh_ingredients
     * @return void
     */
    public function setFreshIngredientsList($fresh_ingredients)
    {
        $this->_fresh_ingredients = $fresh_ingredients;
    }
}
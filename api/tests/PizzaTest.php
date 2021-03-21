<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Pizza;
use App\Models\Pizza\InvalidPropertyException;
use Database\Factories\PizzaFactory;

class PizzaTest extends TestCase
{
    // Make sure Database changes are rolled back after each test use DatabaseTransactions;

    private function staticPizzaData()
    {
        return [
            'name' => 'TestPizza',
            'price' => 5.99,
            'properties' => 'vegan,glutenfree'
        ];
    }

    /*
     * properties()
     */

    public function testProperties_shouldSortWhenCalledWithoutArguments()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->assertEquals([
            'glutenfree',
            'vegan'
        ], $pizza->properties());
    }

    public function testProperties_shouldSortWhenCalledWithTrue()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->assertEquals([
            'glutenfree',
            'vegan'
        ], $pizza->properties(true));
    }

    public function testProperties_shouldSortWhenCalledWithFalse()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->assertEquals([
            'vegan',
            'glutenfree'
        ], $pizza->properties(false));
    }


    /*
     * hasProperty()
     */

    public function testProperties_shouldReturnTrueWhenPropertyIsPresent()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->assertEquals(true, $pizza->hasProperty('vegan'));
    }

    public function testProperties_shouldReturnFalseWhenPropertyIsNotPresent()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->assertEquals(false, $pizza->hasProperty('spicy'));
    }


    /*
     * hasProperty()
     */

    public function testProperties_shouldReturnTrueWhenPropertyIsNotPresent()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->assertEquals(true, $pizza->addProperty('spicy'));
    }

    public function testProperties_shouldAddPropertyWhenIsNotPresent()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $propertyCount = count($pizza->properties());
        $pizza->addProperty('spicy');
        $pizza->refresh();

        $this->assertEquals($propertyCount + 1, count($pizza->properties()));
        $this->assertEquals(true, in_array('spicy', $pizza->properties()));
    }

    public function testProperties_shouldReturnFalseWhenPropertyIsPresent()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->assertEquals(false, $pizza->addProperty('vegan'));
    }

    public function testProperties_shouldNotAddPropertyWhenIsPresent()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $propertyCount = count($pizza->properties());
        $pizza->addProperty('vegan');
        $pizza->refresh();

        $this->assertEquals($propertyCount, count($pizza->properties()));
    }

    public function testProperties_shouldThrowExceptionWhenPropertyIsNotValid()
    {
        $pizza = Pizza::create($this->staticPizzaData());
        $this->expectException(InvalidPropertyException::class);
        $pizza->addProperty('random');
    }
}

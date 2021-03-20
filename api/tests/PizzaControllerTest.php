<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Pizza;

class PizzaControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $pizzaCount = Pizza::count();

        $response = $this->call('POST', '/pizzas', [
          'name' => 'TestPizza',
          'price' => 7.99,
          'properties' => 'vegan,vegetarian'
        ]);

        $response->dump();


        $this->assertEquals(201, $response->status());

        $this->assertEquals(
            count(Pizza::all()), $pizzaCount + 1
        );

        // Number of Pizza models should have been incremented
        $this->assertEquals(
            Pizza::count(), $pizzaCount + 1
        );
    }
}

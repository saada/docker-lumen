<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Pizza;
use Database\Factories\PizzaFactory;

class PizzaControllerTest extends TestCase
{
    // Make sure Database changes are rolled back after each test
    use DatabaseTransactions;

    private function testPizzaData($testPizza = null) {
        if ($testPizza === null) {
            $testPizza = (new PizzaFactory())->make();
        }
        return [
            'name' => $testPizza->name,
            'price' => $testPizza->price,
            'properties' => $testPizza->properties
        ];
    }

    private function callAuthenticated($method, $uri, $parameters = []) {
        return $this->call($method, $uri, $parameters, [], [], [
            'HTTP_AUTHORIZATION' => 'Basic ' . $_ENV['API_KEY']
        ]);
    }

    private function jsonAuthenticated($method, $uri, $parameters = []) {
        $this->call($method, $uri, $parameters, [], [], [
            'HTTP_AUTHORIZATION' => 'Basic ' . $_ENV['API_KEY']
        ]);

        return $this;
    }

    // Without Authentication


    /*
     * INDEX
     */

    public function testIndex_shouldReturnSuccessful()
    {
        $response = $this->callAuthenticated('GET', '/pizzas');
        $this->assertEquals(200, $response->status());
    }

    public function testIndex_shouldReturnAllPizzas()
    {
        $testPizzas = [
            (new PizzaFactory())->create(),
            (new PizzaFactory())->create(),
            (new PizzaFactory())->create()
        ];

        $response = $this->jsonAuthenticated('GET', '/pizzas');

        foreach ($testPizzas as $testPizza) {
            $response->seeJson([ 'id' => $testPizza->id ]);
            $response->seeJson([ 'name' => $testPizza->name ]);
        }
    }


    /*
     * SHOW
     */

    /* WITH VALID ID */

    public function testShow_withValidId_shouldReturnSuccessful()
    {
        $testPizza = (new PizzaFactory())->create();
        $response = $this->callAuthenticated('GET', '/pizzas/' . strval($testPizza->id));
        $this->assertEquals(200, $response->status());
    }

    /* WITH INVALID ID */

    public function testShow_withInvalidId_shouldReturnSuccessful()
    {
        $testPizza = (new PizzaFactory())->create();
        $invalidId = $testPizza->id + 1;
        $response = $this->callAuthenticated('GET', '/pizzas/' . strval($invalidId));
        $this->assertEquals(404, $response->status());
    }


    /*
     * CREATE 
     */

    /* WITH VALID DATA */

    public function testCreate_withData_shouldReturnCreated()
    {
        $response = $this->callAuthenticated('POST', '/pizzas', $this->testPizzaData());
        $this->assertEquals(201, $response->status());
    }

    public function testCreate_withData_shouldIncreasePizzaCount()
    {
        $pizzaCount = Pizza::count();
        $response = $this->callAuthenticated('POST', '/pizzas', $this->testPizzaData());
        $this->assertEquals(Pizza::count(), $pizzaCount + 1);
    }

    public function testCreate_withData_shouldReturnNewPizzaJson()
    {
        $testPizzaData = $this->testPizzaData();
        $response = $this->jsonAuthenticated('POST', '/pizzas', $testPizzaData);
        $response->seeJson($testPizzaData);
    }

    /* WITHOUT (VALID) DATA */

    public function testCreate_withoutData_shouldReturnBadRequest()
    {
        $response = $this->callAuthenticated('POST', '/pizzas');
        $this->assertEquals(422, $response->status());
    }

    public function testCreate_withoutData_shouldNotIncreasePizzaCount()
    {
        $pizzaCount = Pizza::count();
        $response = $this->callAuthenticated('POST', '/pizzas');
        $this->assertEquals(Pizza::count(), $pizzaCount);
    }

    public function testCreate_withoutData_shouldReturnValidationErrors()
    {
        // Without Data
        $response = $this->jsonAuthenticated('POST', '/pizzas');
        $response = $response->seeJson([
            'name' => ['The name field is required.'],
            'price' => ['The price field is required.']
        ]);
    }

    public function testCreate_withInvalidData_shouldReturnValidationErrors()
    {
        // Without name
        $response = $this->jsonAuthenticated('POST', '/pizzas', [ 'price' => 7.99 ]);
        $response = $response->seeJson([
            'name' => ['The name field is required.'],
        ]);

        // Without price
        $response = $this->jsonAuthenticated('POST', '/pizzas', [ 'name' => 'Hawai' ]);
        $response = $response->seeJson([
            'price' => ['The price field is required.'],
        ]);
    }


    /*
     * UPDATE
     */

    /* WITH VALID ID */

    public function testUpdate_withValidId_shouldReturnSuccessful()
    {
        $testPizza = (new PizzaFactory())->create();
        $response = $this->callAuthenticated('PUT', '/pizzas/' . strval($testPizza->id));
        $this->assertEquals(200, $response->status());
    }

    public function testUpdate_withValidId_shouldUpdateRecord()
    {
        $testPizza = (new PizzaFactory())->create();
        $someOtherData = $this->testPizzaData();
        $response = $this->callAuthenticated('PUT', '/pizzas/' . strval($testPizza->id), [
            'name' => $someOtherData['name'],
            'price' => $someOtherData['price'],
            'properties' => $someOtherData['properties']
        ]);

        $testPizza->refresh();
        $this->assertEquals($testPizza->name, $someOtherData['name']);
        $this->assertEquals($testPizza->price, $someOtherData['price']);
        $this->assertEquals($testPizza->properties, $someOtherData['properties']);
    }

    /* WITH INVALID ID */

    public function testUpdate_withValidId_shouldReturnNotFound()
    {
        $testPizza = (new PizzaFactory())->create();
        $invalidId = $testPizza->id + 1;
        $response = $this->callAuthenticated('PUT', '/pizzas/' . strval($invalidId));
        $this->assertEquals(404, $response->status());
    }


    /*
     * DELETE
     */

    /* WITH VALID ID */

    public function testDelete_withValidId_shouldReturnNoContent()
    {
        $testPizza = (new PizzaFactory())->create();
        $response = $this->callAuthenticated('DELETE', '/pizzas/' . strval($testPizza->id));
        $this->assertEquals(204, $response->status());
    }

    public function testDelete_withValidId_shouldDeletePizza()
    {
        $testPizza = (new PizzaFactory())->create();
        $testPizzaId = $testPizza->id;
        $this->callAuthenticated('DELETE', '/pizzas/' . strval($testPizza->id));

        $this->assertEquals(null, Pizza::find($testPizza->id));
    }

    /* WITH INVALID ID */

    public function testDelete_withInvalidId_shouldReturnNotFound()
    {
        $testPizza = (new PizzaFactory())->create();
        $invalidId = $testPizza->id + 1;
        $response = $this->callAuthenticated('DELETE', '/pizzas/' . strval($invalidId));
        $this->assertEquals(404, $response->status());
    }
}

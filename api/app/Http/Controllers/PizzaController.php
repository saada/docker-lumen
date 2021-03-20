<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() {
      return response()->json(Pizza::all());
    }

    public function show($id)
    {
      // return Pizza::findOrFail($id);
      return response()->json(Pizza::find($id));
    }

    public function create(Request $request)
    {
      $pizza = Pizza::create($request->all());

      return response()->json($pizza, 201);
    }

    public function update($id, Request $request)
    {
      $pizza = Pizza::findOrFail($id);
      $pizza->update($request->all());

      return response()->json($pizza, 200);
    }

    public function delete($id)
    {
      Pizza::findOrFail($id)->delete();
      return response('', 204);
    }
}

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
        return response()->json(Pizza::findOrFail($id));
    }

    public function create(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => 'required',
            'price' => 'required'
        ]);
        $pizza = Pizza::create($request->all());

        if ($validated) {
            return response()->json($pizza, 201);
        } else {
            return response()->json($errors, 422);
        }
    }

    public function update($id, Request $request)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->update($request->all());

        return response()->json($pizza, 200);
    }

    public function destroy($id)
    {
        Pizza::findOrFail($id)->delete();
        return response('', 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Pizza\InvalidPropertyException;
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

        if ($validated) {
            $pizza = Pizza::create($request->all());
            return response()->json($pizza, 201);
        } else {
            return response()->json($errors, 422);
        }
    }

    public function update($id, Request $request)
    {
        $pizza = Pizza::findOrFail($id);
        $validated = $this->validate($request, [
            'name' => 'required',
            'price' => 'required'
        ]);

        if ($validated) {
            $pizza->update($request->all());
            return response()->json($pizza, 200);
        } else {
            return response()->json($errors, 422);
        }
    }

    public function destroy($id)
    {
        Pizza::findOrFail($id)->delete();
        return response('', 204);
    }

    public function addProperty($id, $property)
    {
        $pizza = Pizza::findOrFail($id);

        try {
            if ($pizza->addProperty($property)) {
                return response()->json($pizza, 200);
            } else {
                return response()->json('', 204);
            }
        } catch(InvalidPropertyException $e) {
            return response()->json($e, 422);
        }
    }
}

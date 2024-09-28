<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // List all cars
    public function index()
    {
        $cars = Car::all();
        return view('admin.cars.index', compact('cars'));
    }

    // Show the form for creating a new car
    public function create()
    {
        return view('admin.cars.create');
    }

    // Store a newly created car
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'car_type' => 'required|string',
            'daily_rent_price' => 'required|numeric',
            'availability' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Upload image
        $path = $request->file('image')->store('public/cars');

        Car::create([
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'car_type' => $validated['car_type'],
            'daily_rent_price' => $validated['daily_rent_price'],
            'availability' => $validated['availability'],
            'image' => $path,
        ]);

        return redirect()->route('admin.cars.index')->with('success', 'Car added successfully');
    }

    // Show the form for editing the car
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    // Update the car
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'car_type' => 'required|string',
            'daily_rent_price' => 'required|numeric',
            'availability' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $car = Car::findOrFail($id);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/cars');
            $car->update(['image' => $path]);
        }

        $car->update($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully');
    }

    // Delete the car
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully');
    }
}

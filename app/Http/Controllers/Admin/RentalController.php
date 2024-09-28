<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // List all rentals
    public function index()
    {
        $rentals = Rental::with('user', 'car')->get();
        return view('admin.rentals.index', compact('rentals'));
    }

    // Show a single rental
    public function show($id)
    {
        $rental = Rental::with('user', 'car')->findOrFail($id);
        return view('admin.rentals.show', compact('rental'));
    }

    // Delete a rental
    public function destroy($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->delete();

        return redirect()->route('admin.rentals.index')->with('success', 'Rental deleted successfully');
    }
}

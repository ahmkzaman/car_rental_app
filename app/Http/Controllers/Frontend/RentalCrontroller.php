<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    /**
     * Display a listing of the user's rentals.
     */
    public function index()
    {
        $rentals = Rental::where('user_id', Auth::id())->with('car')->get();

        return view('frontend.rentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new rental.
     */
    public function create($carId)
    {
        $car = Car::findOrFail($carId);
        return view('frontend.rentals.create', compact('car'));
    }

    /**
     * Store a newly created rental in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check car availability for the selected dates
        $car = Car::findOrFail($request->car_id);
        $existingRental = Rental::where('car_id', $car->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();

        if ($existingRental) {
            return redirect()->back()->with('error', 'Car is not available for the selected dates.');
        }

        $totalCost = $car->daily_rent_price * (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;

        Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
        ]);

        return redirect()->route('rentals.index')->with('success', 'Car booked successfully.');
    }

    /**
     * Display the specified rental.
     */
    public function show($id)
    {
        $rental = Rental::where('id', $id)->where('user_id', Auth::id())->with('car')->firstOrFail();

        return view('frontend.rentals.show', compact('rental'));
    }

    /**
     * Remove the specified rental from storage.
     */
    public function destroy($id)
    {
        $rental = Rental::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if (now()->lt($rental->start_date)) {
            $rental->delete();
            return redirect()->route('rentals.index')->with('success', 'Rental canceled successfully.');
        }

        return redirect()->route('rentals.index')->with('error', 'You cannot cancel a rental that has already started.');
    }
}

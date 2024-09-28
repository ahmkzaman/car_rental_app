@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Manage Rentals</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border">Rental ID</th>
                    <th class="py-2 px-4 border">Customer Name</th>
                    <th class="py-2 px-4 border">Car Details</th>
                    <th class="py-2 px-4 border">Rental Period</th>
                    <th class="py-2 px-4 border">Total Cost</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($rentals as $rental)
                <tr>
                    <td class="py-2 px-4 border">{{ $rental->id }}</td>
                    <td class="py-2 px-4 border">{{ $rental->customer->name }}</td>
                    <td class="py-2 px-4 border">{{ $rental->car->name }} ({{ $rental->car->brand }})</td>
                    <td class="py-2 px-4 border">{{ $rental->start_date }} - {{ $rental->end_date }}</td>
                    <td class="py-2 px-4 border">${{ $rental->total_cost }}</td>
                    <td class="py-2 px-4 border">{{ $rental->status }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('admin.rentals.show', $rental->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                            View
                        </a>
                        <form action="{{ route('admin.rentals.destroy', $rental->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

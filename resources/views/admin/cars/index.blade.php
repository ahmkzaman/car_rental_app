@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Manage Cars</h1>
    <a href="{{ route('admin.cars.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
        Add New Car
    </a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border">Car Name</th>
                    <th class="py-2 px-4 border">Brand</th>
                    <th class="py-2 px-4 border">Model</th>
                    <th class="py-2 px-4 border">Year</th>
                    <th class="py-2 px-4 border">Daily Rent Price</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cars as $car)
                <tr>
                    <td class="py-2 px-4 border">{{ $car->name }}</td>
                    <td class="py-2 px-4 border">{{ $car->brand }}</td>
                    <td class="py-2 px-4 border">{{ $car->model }}</td>
                    <td class="py-2 px-4 border">{{ $car->year }}</td>
                    <td class="py-2 px-4 border">${{ $car->daily_rent_price }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('admin.cars.edit', $car->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">
                            Edit
                        </a>
                        <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="inline-block">
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

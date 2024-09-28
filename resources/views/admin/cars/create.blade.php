@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Add New Car</h1>
    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Car Name</label>
            <input type="text" name="name" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Brand</label>
            <input type="text" name="brand" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Model</label>
            <input type="text" name="model" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Year of Manufacture</label>
            <input type="number" name="year" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Car Type</label>
            <input type="text" name="type" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Daily Rent Price</label>
            <input type="text" name="daily_rent_price" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Availability</label>
            <select name="availability" class="w-full px-3 py-2 border rounded">
                <option value="available">Available</option>
                <option value="not available">Not Available</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Car Image</label>
            <input type="file" name="image" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add Car
            </button>
        </div>
    </form>
</div>
@endsection

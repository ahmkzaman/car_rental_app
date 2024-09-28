@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Manage Customers</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border">Customer Name</th>
                    <th class="py-2 px-4 border">Email</th>
                    <th class="py-2 px-4 border">Phone</th>
                    <th class="py-2 px-4 border">Address</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td class="py-2 px-4 border">{{ $customer->name }}</td>
                    <td class="py-2 px-4 border">{{ $customer->email }}</td>
                    <td class="py-2 px-4 border">{{ $customer->phone }}</td>
                    <td class="py-2 px-4 border">{{ $customer->address }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                            View
                        </a>
                        <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline-block">
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

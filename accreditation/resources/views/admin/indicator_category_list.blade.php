<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Indicator Category') }}
        </h2>
    </x-slot>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="p-6">
        <form method="POST" action="add_indicator_category">
            @csrf
            <div class="row align-items-end">
                <div class="col">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" value="{{ old('category_name') }}" required autofocus>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary">Add Category</button>
                </div>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories AS $category)
                <tr>
                    <td>{{$category->category_name}}</td>
                    <td><a href="/edit_indicator_category/{{$category->id}}"><button class="btn btn-outline-success">Edit</button></a></td>
                    <td><a href="/delete_indicator_category/{{$category->id}}"><button class="btn btn-outline-danger" onclick="return confirm('Do you want to delete this data?')">Delete</button></a></td>
                </tr>
                @empty
                <tr>
                    <center><td colspan="3">No Data Yet</td></center>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
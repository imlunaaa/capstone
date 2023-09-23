<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Indicator Category') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <form method="POST" action="/edit_indicator_category/{{$category->id}}">
            @csrf
            <div class="row align-items-end">
                <div class="col">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" value="{{ $category->category_name }}" required autofocus>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-outline-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
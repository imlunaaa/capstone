<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Sub Indicator') }}
        </h2>
    </x-slot>
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
        <a href="{{  URL::previous() }}"><button class="btn btn-outline-secondary">Go Back</button></a>
        <form method="POST" action="/edit_sub_indicator/{{$subindicator->id}}">
            @csrf
            <input type="hidden" name="parameter_id" value="{{$parameter_id}}">
            <label for="subindicator">Sub Indicator</label>
            <input id="subindicator" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subindicator" value="{{ $subindicator->sub_indicator_name }}" required autofocus>
            <div id="subindicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please enter Sub indicator name.
            </div>
            
            <label for="subindicatordesc">Sub Indicator Description</label>
            <textarea id="subindicatordesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subindicatordesc" required autofocus>{{ $subindicator->sub_indicator_desc }}</textarea>
            <div id="subindicatordescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please enter Sub Indicator Description.
            </div>
            <div class="py-3">
                <button type="submit" class="btn btn-outline-warning">Save Changes</button>
            </div>
            
        </form> 
    </div>
</x-app-layout>
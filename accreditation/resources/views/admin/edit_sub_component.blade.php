<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Sub Indicator Component') }}
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
        <form method="POST" action="/edit_sub_component/{{$subcomponent->id}}">
            @csrf
            <input type="hidden" name="parameter_id" value="{{$parameter_id}}">
            <label for="subcomponent">Sub Indicator Component Name</label>
            <input id="subcomponent" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subcomponent" value="{{ $subcomponent->component_name }}" required autofocus>
            @error('subcomponent')
            <div id="subindicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please enter sub indicator component name.
            </div>
            @enderror
            
            <label for="subcomponentdesc">Sub Indicator Component Description</label>
            <textarea id="subcomponentdesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subcomponentdesc" required autofocus>{{ $subcomponent->component_desc }}</textarea>
            <div id="subcomponentdescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please enter Sub Indicator Component Description.
            </div>
        
            <div class="py-3">
                <button type="submit" class="btn btn-outline-warning">Save Changes</button>
            </div>
      </form> 
    </div>
</x-app-layout>
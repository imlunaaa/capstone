<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Indicator') }}
        </h2>
    </x-slot>
    <div class="p-6">
    	<a href="{{  URL::previous() }}"><button class="btn btn-outline-secondary">Go Back</button></a>
    	<form method="POST" action="/edit_indicator/{{ $indicator[0]->id }}">
              <div>
                    @csrf
                    <input type="hidden" name="parameter_id" value="{{$id}}">
                    <label for="category">Indicator Category</label>
                    <select name="category" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required autofocus>
                        <option selected disabled value="">Select Option</option>
                        @forelse($categories AS $category)
                            <option value="{{$category->id}}" {{$category->id == $indicator[0]->indicator_category_id ? 'selected' : ''}}>{{$category->category_name}}</option>
                        @empty
                            <option selected disabled value="">No Data</option>
                        @endforelse
                    </select>
                    <label for="indicator">Indicator</label>
                    <input id="indicator" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="indicator" value="{{ $indicator[0]->indicator_name }}" required autofocus>
                    @error('indicator')
                    <div id="indicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter indicator.
                    </div>
                    @enderror
                    <div id="indicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter indicator.
                    </div>
                    
                    <label for="indicatordesc">Indicator Description</label>
                    <textarea id="indicatordesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="indicatordesc" required autofocus>{{ $indicator[0]->indicator_desc }}</textarea>
                    <div id="indicatordescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter Indicator Description.
                    </div>
                
              </div>
                <button type="submit" class="btn btn-outline-primary">Save Indicator</button>
          </form>
    </div>
</x-app-layout>
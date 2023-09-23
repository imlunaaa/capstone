<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Parameter') }}
        </h2>
    </x-slot>
    <div class="p-6">
        <a href="/parameter_list"><button class="btn btn-outline-secondary">Go Back</button></a>
        <div class="p-4">
            <form method="POST" action="/edit_parameter/<?php echo $parameter[0]->id; ?>">
              <div>
                    @csrf
                    <label for="area">Area</label>
                    <select name="area" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;">
                        <option selected disabled value="">Select Option</option>
                        @forelse($areas as $area)
                            @php
                                $areaid = $area->id;
                                $id = $parameter[0]->area_id;
                            @endphp

                            <option value="{{$area->id}}" {{$areaid == $id ? 'selected' : ''}}> {{$area->area_name}}</option>
                        @empty
                        @endforelse
                    </select>
                    <div id="areaError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an area.
                    </div>
                    <label for="parameter">Parameter</label>
                    <input id="parameter" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="parameter" value="<?php echo $parameter[0]->parameter; ?>" required autofocus>
                    <div id="parameterError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter parameter.
                    </div>
                    <label for="parametertitle">Parameter Title</label>
                    <input id="parametertitle" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="parametertitle" value="<?php echo $parameter[0]->parameter_title; ?>" required autofocus>
                    <div id="parametertitleError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter Parameter title.
                    </div>
                
              </div>
              <button type="submit" class="btn btn-outline-primary">Save Changes</button>
          </form>
        </div>
    </div>
</x-app-layout>
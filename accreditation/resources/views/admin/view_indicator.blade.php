<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Indicators') }}
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
    <div class="p-4">
    	<a href="/manage_parameter/{{$param->area_id}}"><button class="btn btn-outline-secondary">Go Back</button></a>
    	<div>
    		<center><b class="fs-5">Parameter {{$param->parameter}} : {{$param->parameter_title}}</b></center>
    	</div>
        <div class="row justify-content-between">
            <div class="col-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIndicatorModal">Add Indicator</button>
            </div> 
        </div>

        <!--Indicator Modal -->
        <div class="modal fade" id="addIndicatorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Indicator to Parameter {{$param->parameter}} : {{$param->parameter_title}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('indicator_list') }}">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="parameter_id" value="{{$id}}">
                            <label for="category">Indicator Category</label>
                            <select name="category" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required autofocus>
                                <option selected disabled value="">Select Option</option>
                                @forelse($categories AS $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @empty
                                    <option selected disabled value="">No Data</option>
                                @endforelse
                            </select>

                            <label for="indicator">Indicator</label>
                            <input id="indicator" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="indicator" value="{{ old('indicator') }}" required autofocus>
                            @error('indicator')
                            <div id="indicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                Please enter indicator.
                            </div>
                            @enderror
                            
                            <label for="indicatordesc">Indicator Description</label>
                            <textarea id="indicatordesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="indicatordesc" required autofocus>{{ old('indicatordesc') }}</textarea>
                            <div id="indicatordescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                Please enter Indicator Description.
                            </div>
                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary">Add Indicators</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if(sizeof($indicators))
            @forelse($categories AS $category)
                @if($category->category_name == 'NOT APPLICABLE')
                <br>
                    <div class="container"> 
                        <div class="accordion accordion-flush" id="accordionIndicator">
                            @forelse($indicators As $indicator)
                                @if($category->id == $indicator->indicator_category_id)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-indicator{{$indicator->id}}">
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#indicator-collapse{{$indicator->id}}" aria-expanded="true" aria-controls="#indicator-collapse{{$indicator->id}}">
                                            <div class="row align-items-center">
                                                <div class="col-md-auto">
                                                    <div class="p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical "></i>
                                                    </div>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        <li>
                                                            <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#addSubIndicatorModal{{$indicator->id}}">
                                                                <i class="fa-solid fa-plus"></i> Add Sub Indicator
                                                            </a>
                                                        </li>
                                                        <a class="dropdown-item" href="/edit_indicator/{{$indicator->id}}">
                                                            <li><i class="fa-solid fa-pen-to-square"></i> Edit</li>
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('delete_indicator', ['id' => $indicator->id]) }}">
                                                            <li>
                                                                <i class="fa-solid fa-trash "></i> Delete
                                                            </li>
                                                        </a>
                                                    </ul>
                                                </div>
                                                <div class="col-md-auto">
                                                    {{$indicator->indicator_name}}
                                                </div>
                                                <div class="col">
                                                    {{$indicator->indicator_desc}}
                                                </div>
                                            </div>
                                          </button>
                                        </h2>

                                        <div id="indicator-collapse{{$indicator->id}}" class="accordion-collapse collapse" aria-labelledby="heading-indicator{{$indicator->id}}">
                                            <div class="row">
                                                <div class="col-sm-1"></div> 
                                                <div class="col">
                                                    <div class="accordion accordion-flush" id="accordionSubIndicator">
                                                        @forelse($subindicators AS $subindicator)
                                                            @if($subindicator->indicator_id == $indicator->id)
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="heading-subindicator{{$subindicator->id}}">
                                                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subindicator-collapse{{$subindicator->id}}" aria-expanded="true" aria-controls="collapseTwo">
                                                                       <div class="row">
                                                                            <div class="col-md-auto">
                                                                                <div class="p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="fa-solid fa-ellipsis-vertical "></i>
                                                                                </div>
                                                                                <ul class="dropdown-menu dropdown-menu-dark">
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#addSubComponentModal{{$subindicator->id}}">
                                                                                            <i class="fa-solid fa-plus"></i> Add Component
                                                                                        </a>
                                                                                    </li>
                                                                                    <a class="dropdown-item" href="/edit_sub_indicator/{{$subindicator->id}}/{{$id}}">
                                                                                        <li><i class="fa-solid fa-pen-to-square"></i> Edit</li>
                                                                                    </a>
                                                                                    <a class="dropdown-item" href="{{ route('delete_sub_indicator', ['id' => $subindicator->id, 'action' => 'delete']) }}">
                                                                                        <li><i class="fa-solid fa-trash "></i> Delete</li>
                                                                                    </a>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-md-auto">
                                                                                {{$subindicator->sub_indicator_name}}: {{$subindicator->sub_indicator_desc}}
                                                                            </div>
                                                                        </div>
                                                                      </button>
                                                                    </h2>
                                                                    <hr style="width: 100%" class="mx-auto">
                                                                    <div id="subindicator-collapse{{$subindicator->id}}" class="accordion-collapse collapse" aria-labelledby="heading-subindicator{{$subindicator->id}}" data-bs-parent="#accordionSubIndicator">
                                                                        @forelse($subcomponents AS $subcomponent)
                                                                            @if($subcomponent->sub_indicator_id == $subindicator->id)
                                                                            <div class="accordion-body">
                                                                                <div class="row">
                                                                                    <div class="col-sm-1"></div>
                                                                                    <div class="col-md-auto">
                                                                                        <div class="p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                            <i class="fa-solid fa-ellipsis-vertical "></i>
                                                                                        </div>
                                                                                        <ul class="dropdown-menu dropdown-menu-dark">
                                                                                            <a class="dropdown-item" href="/edit_sub_component/{{$subindicator->id}}/{{$id}}">
                                                                                                <li>
                                                                                                    <i class="fa-solid fa-pen-to-square"></i> Edit 
                                                                                                </li>
                                                                                            </a>
                                                                                            <a class="dropdown-item" href="/delete_sub_component/{{$subcomponent->id}}">
                                                                                                <li>
                                                                                                    <i class="fa-solid fa-trash "></i> Delete
                                                                                                </li>
                                                                                            </a>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="col-md-auto">
                                                                                        {{$subcomponent->component_name}}: {{$subcomponent->component_desc}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr style="width: 75%" class="mx-auto">
                                                                             @endif
                                                                        @empty
                                                                            <center class="fs-5 p-3">No Sub indicator Component</center>
                                                                        @endforelse
                                                                    </div>
                                                                </div>
                                                               

                                                                <!-- Sub Component Modal -->
                                                                <div class="modal fade" id="addSubComponentModal{{$subindicator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                          <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Sub Component to {{$subindicator->sub_indicator_name}}</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                                                            </div>
                                                                            <form method="POST" action="{{ Route('add_sub_component') }}">
                                                                                <div class="modal-body">
                                                                                    @csrf
                                                                                    <p>Make sure to use the sub indicator name in naming the sub indicator component</p>
                                                                                    <p>(ex.) {{$subindicator->sub_indicator_name}}, named the sub indicator component {{$subindicator->sub_indicator_name}}.1</p>
                                                                                    <input type="hidden" name="parameter_id" value="{{$id}}">
                                                                                    <input type="hidden" name="sub_indicator_id" value="{{$subindicator->id}}">
                                                                                    <label for="subcomponent">Sub Indicator Component Name</label>
                                                                                    <input id="subcomponent" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subcomponent" value="{{ old('subcomponent') }}" required autofocus>
                                                                                    @error('subcomponent')
                                                                                    <div id="subindicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                                                        Please enter sub indicator component name.
                                                                                    </div>
                                                                                    @enderror
                                                                                    
                                                                                    <label for="subcomponentdesc">Sub Indicator Component Description</label>
                                                                                    <textarea id="subcomponentdesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subcomponentdesc" required autofocus>{{ old('subcomponentdesc') }}</textarea>
                                                                                    <div id="subcomponentdescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                                                        Please enter Sub Indicator Component Description.
                                                                                    </div>
                                                                                
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-outline-primary">Add Sub Indicator Component</button>
                                                                                </div>
                                                                            </form> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <center class="fs-5 p-3">No Sub indicator</center>
                                                        @endforelse
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sub Indicator Modal -->
                                    <div class="modal fade" id="addSubIndicatorModal{{$indicator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Sub Indicator to {{$indicator->indicator_name}}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ Route('add_sub_indicator') }}">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <p>Make sure to use the indicator name in naming the sub indicator</p>
                                                        <p>(ex.) {{$indicator->indicator_name}}, named the sub indicator {{$indicator->indicator_name}}.1</p>
                                                        <input type="hidden" name="parameter_id" value="{{$id}}">
                                                        <input type="hidden" name="indicator_id" value="{{$indicator->id}}">
                                                        <label for="subindicator">Sub Indicator</label>
                                                        <input id="subindicator" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subindicator" value="{{ old('subindicator') }}" required autofocus>
                                                        @error('indicator')
                                                        <div id="subindicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                            Please enter Sub indicator name.
                                                        </div>
                                                        @enderror
                                                        
                                                        <label for="subindicatordesc">Sub Indicator Description</label>
                                                        <textarea id="subindicatordesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subindicatordesc" required autofocus>{{ old('subindicatordesc') }}</textarea>
                                                        <div id="subindicatordescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                            Please enter Sub Indicator Description.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-outline-primary">Add Sub Indicators</button>
                                                    </div>
                                                </form> 
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                 <center class="fs-2 p-3">No Indicators yet</center>
                            @endforelse
                        </div>
                    </div>
                @else
                    @if($counter == 0)
                    <!-- INDICATOR LIST -->
                    <div class="pt-5">
                        <center><b>{{$category->category_name}}</b></center>
                    </div>
                    <div class="container"> 
                        <div class="accordion accordion-flush" id="accordionIndicator">
                            @forelse($indicators As $indicator)
                                @if($category->id == $indicator->indicator_category_id)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-indicator{{$indicator->id}}">
                                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#indicator-collapse{{$indicator->id}}" aria-expanded="true" aria-controls="#indicator-collapse{{$indicator->id}}">
                                            <div class="row align-items-center">
                                                <div class="col-md-auto">
                                                    <div class="p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis-vertical "></i>
                                                    </div>
                                                    <ul class="dropdown-menu dropdown-menu-dark">
                                                        <li>
                                                            <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#addSubIndicatorModal{{$indicator->id}}">
                                                                <i class="fa-solid fa-plus"></i> Add Sub Indicator
                                                            </a>
                                                        </li>
                                                        <a class="dropdown-item" href="/edit_indicator/{{$indicator->id}}">
                                                            <li><i class="fa-solid fa-pen-to-square"></i> Edit</li>
                                                        </a>
                                                        <a class="dropdown-item" href="{{ route('delete_indicator', ['id' => $indicator->id]) }}">
                                                            <li>
                                                                <i class="fa-solid fa-trash "></i> Delete
                                                            </li>
                                                        </a>
                                                    </ul>
                                                </div>
                                                <div class="col-md-auto">
                                                    {{$indicator->indicator_name}}
                                                </div>
                                                <div class="col">
                                                    {{$indicator->indicator_desc}}
                                                </div>
                                            </div>
                                          </button>
                                        </h2>

                                        <div id="indicator-collapse{{$indicator->id}}" class="accordion-collapse collapse" aria-labelledby="heading-indicator{{$indicator->id}}">
                                            <div class="row">
                                                <div class="col-sm-1"></div> 
                                                <div class="col">
                                                    <div class="accordion accordion-flush" id="accordionSubIndicator">
                                                        @forelse($subindicators AS $subindicator)
                                                            @if($subindicator->indicator_id == $indicator->id)
                                                                <div class="accordion-item">
                                                                    <h2 class="accordion-header" id="heading-subindicator{{$subindicator->id}}">
                                                                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subindicator-collapse{{$subindicator->id}}" aria-expanded="true" aria-controls="collapseTwo">
                                                                       <div class="row">
                                                                            <div class="col-md-auto">
                                                                                <div class="p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <i class="fa-solid fa-ellipsis-vertical "></i>
                                                                                </div>
                                                                                <ul class="dropdown-menu dropdown-menu-dark">
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#addSubComponentModal{{$subindicator->id}}">
                                                                                            <i class="fa-solid fa-plus"></i> Add Component
                                                                                        </a>
                                                                                    </li>
                                                                                    <a class="dropdown-item" href="/edit_sub_indicator/{{$subindicator->id}}/{{$id}}">
                                                                                        <li><i class="fa-solid fa-pen-to-square"></i> Edit</li>
                                                                                    </a>
                                                                                    <a class="dropdown-item" href="{{ route('delete_sub_indicator', ['id' => $subindicator->id, 'action' => 'delete']) }}">
                                                                                        <li><i class="fa-solid fa-trash "></i> Delete</li>
                                                                                    </a>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="col-md-auto">
                                                                                {{$subindicator->sub_indicator_name}}: {{$subindicator->sub_indicator_desc}}
                                                                            </div>
                                                                        </div>
                                                                      </button>
                                                                    </h2>
                                                                    <hr style="width: 100%" class="mx-auto">
                                                                    <div id="subindicator-collapse{{$subindicator->id}}" class="accordion-collapse collapse" aria-labelledby="heading-subindicator{{$subindicator->id}}" data-bs-parent="#accordionSubIndicator">
                                                                        @forelse($subcomponents AS $subcomponent)
                                                                            @if($subcomponent->sub_indicator_id == $subindicator->id)
                                                                            <div class="accordion-body">
                                                                                <div class="row">
                                                                                    <div class="col-sm-1"></div>
                                                                                    <div class="col-md-auto">
                                                                                        <div class="p-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                            <i class="fa-solid fa-ellipsis-vertical "></i>
                                                                                        </div>
                                                                                        <ul class="dropdown-menu dropdown-menu-dark">
                                                                                            <a class="dropdown-item" href="/edit_sub_component/{{$subindicator->id}}/{{$id}}">
                                                                                                <li>
                                                                                                    <i class="fa-solid fa-pen-to-square"></i> Edit 
                                                                                                </li>
                                                                                            </a>
                                                                                            <a class="dropdown-item" href="/delete_sub_component/{{$subcomponent->id}}">
                                                                                                <li>
                                                                                                    <i class="fa-solid fa-trash "></i> Delete
                                                                                                </li>
                                                                                            </a>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="col-md-auto">
                                                                                        {{$subcomponent->component_name}}: {{$subcomponent->component_desc}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <hr style="width: 75%" class="mx-auto">
                                                                             @endif
                                                                        @empty
                                                                            <center class="fs-5 p-3">No Sub indicator Component</center>
                                                                        @endforelse
                                                                    </div>
                                                                </div>
                                                               

                                                                <!-- Sub Component Modal -->
                                                                <div class="modal fade" id="addSubComponentModal{{$subindicator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                          <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Sub Component to {{$subindicator->sub_indicator_name}}</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                                                            </div>
                                                                            <form method="POST" action="{{ Route('add_sub_component') }}">
                                                                                <div class="modal-body">
                                                                                    @csrf
                                                                                    <p>Make sure to use the sub indicator name in naming the sub indicator component</p>
                                                                                    <p>(ex.) {{$subindicator->sub_indicator_name}}, named the sub indicator component {{$subindicator->sub_indicator_name}}.1</p>
                                                                                    <input type="hidden" name="parameter_id" value="{{$id}}">
                                                                                    <input type="hidden" name="sub_indicator_id" value="{{$subindicator->id}}">
                                                                                    <label for="subcomponent">Sub Indicator Component Name</label>
                                                                                    <input id="subcomponent" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subcomponent" value="{{ old('subcomponent') }}" required autofocus>
                                                                                    @error('subcomponent')
                                                                                    <div id="subindicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                                                        Please enter sub indicator component name.
                                                                                    </div>
                                                                                    @enderror
                                                                                    
                                                                                    <label for="subcomponentdesc">Sub Indicator Component Description</label>
                                                                                    <textarea id="subcomponentdesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subcomponentdesc" required autofocus>{{ old('subcomponentdesc') }}</textarea>
                                                                                    <div id="subcomponentdescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                                                        Please enter Sub Indicator Component Description.
                                                                                    </div>
                                                                                
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-outline-primary">Add Sub Indicator Component</button>
                                                                                </div>
                                                                            </form> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @empty
                                                            <center class="fs-5 p-3">No Sub indicator</center>
                                                        @endforelse
                                                     </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sub Indicator Modal -->
                                    <div class="modal fade" id="addSubIndicatorModal{{$indicator->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Adding Sub Indicator to {{$indicator->indicator_name}}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ Route('add_sub_indicator') }}">
                                                    <div class="modal-body">
                                                        @csrf
                                                        <p>Make sure to use the indicator name in naming the sub indicator</p>
                                                        <p>(ex.) {{$indicator->indicator_name}}, named the sub indicator {{$indicator->indicator_name}}.1</p>
                                                        <input type="hidden" name="parameter_id" value="{{$id}}">
                                                        <input type="hidden" name="indicator_id" value="{{$indicator->id}}">
                                                        <label for="subindicator">Sub Indicator</label>
                                                        <input id="subindicator" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subindicator" value="{{ old('subindicator') }}" required autofocus>
                                                        @error('indicator')
                                                        <div id="subindicatorError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                            Please enter Sub indicator name.
                                                        </div>
                                                        @enderror
                                                        
                                                        <label for="subindicatordesc">Sub Indicator Description</label>
                                                        <textarea id="subindicatordesc" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="subindicatordesc" required autofocus>{{ old('subindicatordesc') }}</textarea>
                                                        <div id="subindicatordescError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                                                            Please enter Sub Indicator Description.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-outline-primary">Add Sub Indicators</button>
                                                    </div>
                                                </form> 
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                 <center class="fs-2 p-3">No Indicators yet</center>
                            @endforelse
                        </div>
                    </div>
                    @endif
                @endif
            @empty
                //category loop
                <div></div>
            @endforelse
        @else
            <center class="fs-2 p-3">No Indicators yet</center>
        @endif
    </div>
</x-app-layout>
<script type="text/javascript">
    const indicatorInput = document.getElementById('indicator');
    const indicatorError = document.getElementById('indicatorError');
    indicatorInput.addEventListener('blur', () => {
        validateIndicator();

    });
    function validateIndicator() {
        const indicatorValue = indicatorInput.value.trim();

        if (indicatorValue === '') {
            indicatorInput.style.borderColor = 'red'; // Change border color to red
            indicatorError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        indicatorInput.style.borderColor = '#ccc'; // Reset border color
        indicatorError.style.display = 'none'; // Hide error message
        return true;
    }

    const indicatordescInput = document.getElementById('indicatordesc');
    const indicatordescError = document.getElementById('indicatordescError');
   indicatordescInput.addEventListener('blur', () => {
        validateIndicatordesc();

    });
    function validateIndicatordesc() {
        const indicatordescValue = indicatordescInput.value.trim();

        if (indicatordescValue === '') {
            indicatordescInput.style.borderColor = 'red'; // Change border color to red
            indicatordescError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        indicatordescInput.style.borderColor = '#ccc'; // Reset border color
        indicatordescError.style.display = 'none'; // Hide error message
        return true;
    }
</script>
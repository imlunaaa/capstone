<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Parameter {{$param[0]->parameter}} Indicators
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
        <a href="/parameters"><button class="btn btn-outline-secondary">Go Back</button></a>
        <div>
            <center><b class="fs-5">Parameter {{$param[0]->parameter}} : {{$param[0]->parameter_title}}</b></center>
        </div>

        @if(sizeof($indicators))
            @forelse($categories AS $category)
                @if($category->category_name == 'NOT APPLICABLE')
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
                                                        <a class="dropdown-item" href="/view_files_indicator/{{$indicator->id}}/{{$id}}">
                                                            <li>
                                                                <i class="fa-solid fa-file "></i> View Files
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

                                        <div id="indicator-collapse{{$indicator->id}}" class="accordion-collapse collapse" aria-labelledby="heading-indicator{{$indicator->id}}" >
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
                                                                                <a class="dropdown-item" href="/view_files_subindicator/{{$subindicator->id}}/{{$id}}">
                                                                                    <li>
                                                                                        <i class="fa-solid fa-file "></i> View Files
                                                                                    </li>
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
                                                                                        <a class="dropdown-item" href="">
                                                                                            <li>
                                                                                                <i class="fa-solid fa-file "></i>  View Files
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
                                                        @endif
                                                    @empty
                                                        <center class="fs-5 p-3">No Sub indicator</center>
                                                    @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                            <div>
                                <center class="fs-2 p-3">No Indicators yet</center>
                            </div> 
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
                                                        <a class="dropdown-item" href="/view_files_indicator/{{$indicator->id}}/{{$id}}">
                                                            <li>
                                                                <i class="fa-solid fa-file "></i> View Files
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

                                        <div id="indicator-collapse{{$indicator->id}}" class="accordion-collapse collapse" aria-labelledby="heading-indicator{{$indicator->id}}" >
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
                                                                                <a class="dropdown-item" href="/view_files_subindicator/{{$subindicator->id}}/{{$id}}">
                                                                                    <li>
                                                                                        <i class="fa-solid fa-file "></i> View Files
                                                                                    </li>
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
                                                                                        <a class="dropdown-item" href="">
                                                                                            <li>
                                                                                                <i class="fa-solid fa-file "></i>  View Files
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
                                                        @endif
                                                    @empty
                                                        <center class="fs-5 p-3">No Sub indicator</center>
                                                    @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                            <div>
                                <center class="fs-2 p-3">No Indicators yet</center>
                            </div>
                                 
                            @endforelse
                        </div>
                    </div>
                    @endif
                @endif
            @empty
                <div></div>
            @endforelse
        @else
            <center class="fs-2 p-3">No Indicators yet</center>
        @endif
    </div>
</x-app-layout>
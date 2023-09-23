<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Parameters') }}: {{$areas->area_name}} {{$areas->area_title}}
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
        <a href="/view_areas/{{$areas->instrument_id}}"><button class="btn btn-outline-secondary">Go Back</button></a>
        <div class="row justify-content-between">
            <div class="col-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampusModal">Add Parameter</button>
            </div>
            <!-- <div class="col-4">
                <form method="get" action="/parameter_list">
                   <select name="area" style="margin-top: 0.25rem; width: 50%; border: 1px solid #ccc;">
                        <option selected disabled value="0">Filter Area</option>
                        <option value="">All</option>

                    </select> 
                    <input type="submit" name="" value="Filter" class="btn btn-outline-primary">
                </form>
            </div> -->
        </div>
    <!-- Modal -->
    <div class="modal fade" id="addCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Parameter</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('parameter_list') }}">
              <div class="modal-body">
                    @csrf
                    <!-- <label for="area">Area</label>
                    <select name="area" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;">
                        <option selected disabled value="">Select Option</option>
                    </select> -->
                    <input type="hidden" name="area" value="{{$areas->id}}">
                    <div id="areaError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an area.
                    </div>
                    <label for="parameter">Parameter</label>
                    <input id="parameter" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="parameter" value="{{ old('parameter') }}" required autofocus>
                    <div id="parameterError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter parameter.
                    </div>
                    <label for="parametertitle">Parameter Title</label>
                    <input id="parametertitle" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="parametertitle" value="{{ old('parametertitle') }}" required autofocus>
                    <div id="parametertitleError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter Parameter title.
                    </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Add Parameter</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Area Name</th>
                <th>Parameter</th>
                <th>Parameter Title</th>
                <th>Area Title</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parameters As $parameter)
                <tr>
                    <td>{{$parameter->area->area_name}}</td>
                    <td>{{$parameter->parameter}}</td>
                    <td>{{Str::limit($parameter->parameter_title, 50)}}</td>
                    <td>{{$parameter->area->area_title}}</td>
                    <td><a href="/view_indicator/{{$parameter->paramID}}"><button class="btn btn-outline-primary">View  Indicators</button></a></td>
                    <td><a href="/edit_parameter/{{$parameter->paramID}}"><button class="btn btn-outline-success">Edit</button></a></td>
                    <td><a href="/parameter_list/{{$parameter->paramID}}" onclick="return confirm('You are about delete this data')"><button class="btn btn-outline-danger">Delete</button></a></td>
                </tr>
            @empty
             <tr>
                 <td colspan="5">No data yet</td>
             </tr>
            @endforelse
        </tbody>
    </table>
     {{ $parameters->links() }}
</div>
</x-app-layout>
<script type="text/javascript">
    const parameterInput = document.getElementById('parameter');
    const parameterError = document.getElementById('parameterError');
    parameterInput.addEventListener('blur', () => {
        validateParameter();

    });
    function validateParameter() {
        const parameterValue = parameterInput.value.trim();

        if (parameterValue === '') {
            parameterInput.style.borderColor = 'red'; // Change border color to red
            parameterError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        parameterInput.style.borderColor = '#ccc'; // Reset border color
        parameterError.style.display = 'none'; // Hide error message
        return true;
    }

    const parametertitleInput = document.getElementById('parametertitle');
    const parametertitleError = document.getElementById('parametertitleError');
    parametertitleInput.addEventListener('blur', () => {
        validateParametertitle();

    });
    function validateParametertitle() {
        const parametertitleValue = parametertitleInput.value.trim();

        if (parametertitleValue === '') {
            parametertitleInput.style.borderColor = 'red'; // Change border color to red
            parametertitleError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        parametertitleInput.style.borderColor = '#ccc'; // Reset border color
        parametertitleError.style.display = 'none'; // Hide error message
        return true;
    }
    const dropdown = document.getElementById('area');
    const dropdownError = document.getElementById('areaError');

    dropdown.addEventListener('blur', () => {
        validateDropdown();
    });

    function validateDropdown() {
        const selectedOption = dropdown.value;

        if (selectedOption === "") {
            dropdown.style.borderColor = 'red';
            dropdownError.style.display = 'block';
            return false;
        }

        dropdown.style.borderColor = '#ccc';
        dropdownError.style.display = 'none';
        return true;
    }


</script>
    
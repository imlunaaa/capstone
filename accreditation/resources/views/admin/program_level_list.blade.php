<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Program level') }}
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
        <div class="row justify-content-between">
            <div class="col-4">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampusModal">Add Program</button>
            </div>
            <div class="col-4">
                <form method="get" action="/program_level_list">
                   <select name="area" style="margin-top: 0.25rem; width: 50%; border: 1px solid #ccc;">
                        <option selected disabled value="0">Filter Campus</option>
                        <option value="">All</option>
                        @forelse($campuses as $campus)
                        <option value="{{$campus->id}}" {{ $request->area == $campus->id ? 'selected' : '' }}>{{$campus->name}}</option>
                        @empty
                        @endforelse
                    </select> 
                   
                    
                    <input type="submit" name="" value="Filter" class="btn btn-outline-primary">
                </form>
                
            </div>
        </div>
    <!-- Modal -->
    <div class="modal fade" id="addCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Parameter</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('program_level_list') }}">
              <div class="modal-body">
                    @csrf
                    <label for="campus">Campus</label>
                    <select name="campus" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required>
                        <option selected disabled>Select Campus</option>
                        @forelse($campuses as $campus)
                        <option value="{{$campus->id}}" {{ old('campus') == $campus->id ? "selected" : "" }}>{{$campus->name}}</option>
                        @empty
                        @endforelse
                    </select>
                    <div id="campusError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an campus.
                    </div>

                    <label for="Program">Program</label>
                    <select name="program" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required>
                        <option selected disabled>Select Program</option>
                        @forelse($programs as $program)
                        <option value="{{$program->id}}" {{ old('program') == $program->id ? "selected" : "" }}>{{$program->program}}</option>
                        @empty
                        @endforelse
                    </select>
                    <div id="programError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an program.
                    </div>

                    <label class="form-label">Level</label>
                    <input type="number" name="level" class="form-control" min="1" max="5" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required value="{{old('level')}}">
                    <div id="levelError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter level.
                    </div>

                    <label for="validity_from">Validity From</label>
                    <input type="date" name="validity_from" id="validity_from" class="form-control" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required value="{{old('validity_from')}}">
                    <div id="validity_fromError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an date.
                    </div>

                    <label for="validity_to">Validity To</label>
                    <input type="date" name="validity_to" id="validity_to" class="form-control" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required value="{{old('validity_to')}}">
                    <div id="validity_toError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please select an date.
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" id="submit" class="btn btn-outline-primary">Add Program</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Program</th>
                <th>Campus</th>
                <th>Level</th>
                <th>Level Validity From</th>
                <th>Level Validity To</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programLevels as $programLevel)
            <tr>
                <td>{{$programLevel->prog}}</td>
                <td>{{$programLevel->cname}}</td>
                <td>{{$programLevel->level}}</td>
                <td>{{$programLevel->validity_from}}</td>
                <td>{{$programLevel->validity_to}}</td>
                <td><a href="/edit_program_level/{{$programLevel->plID}}"><button class="btn btn-outline-success">Edit</button></a></td>
                <td><a href="/program_level_list/{{$programLevel->plID}}"><button class="btn btn-outline-danger" onclick="return confirm('Delete this data?')">Delete</button></a></td>
            </tr>
            @empty
                <tr>
                    <td colspan="7"><center>No data yet</center></td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{$programLevels->links()}}
</div>
</x-app-layout>
<script type="text/javascript">

    let min = new Date().toISOString().split("T")[0];

    document.getElementById("validity_from").setAttribute("min", min);
    document.getElementById("validity_to").setAttribute("min", min);

    const campusInput = document.getElementById('campus');
    const campusError = document.getElementById('campusError');
    campusInput.addEventListener('blur', () => {
        validateCampus();

    });
    function validateCampus() {
        const campusValue = campusInput.value.trim();

        if (campusValue == null) {
            campusInput.style.borderColor = 'red'; // Change border color to red
            campusError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        campusInput.style.borderColor = '#ccc'; // Reset border color
        campusError.style.display = 'none'; // Hide error message
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
    
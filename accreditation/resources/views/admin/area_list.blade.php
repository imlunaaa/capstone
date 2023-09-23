<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Area') }} of {{$instrument->program}}
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
        <a href="/instrument_list"><button class="btn btn-outline-secondary">Go Back</button></a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampusModal">Add Area</button>
    <!-- Modal -->
    <div class="modal fade" id="addCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Area</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('area_list') }}">
              <div class="modal-body">
                    @csrf
                    <input type="hidden" name="instrument_id" value="{{$instrument->ins_id}}">
                    <label for="areaname">Area Name</label>
                    <input id="areaname" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="areaname" value="{{ old('areaname') }}" required autofocus>
                    <div id="areanameError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter area.
                    </div>
                    <label for="areatitle">Area Title</label>
                    <input id="areatitle" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="areatitle" value="{{ old('areatitle') }}" required autofocus>
                    <div id="areatitleError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter area name.
                    </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Add Area</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Area Name</th>
                <th>Area Title</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($areas As $area)
                <tr>
                    <td>{{$area->area_name}}</td>
                    <td>{{$area->area_title}}</td>
                    <td><a href="/manage_parameter/{{$area->id}}"><button class="btn btn-outline-primary">View Parameters</button></a></td>
                    <td><a href="/edit_area/{{$area->id}}"><button class="btn btn-outline-success">Edit</button></a></td>
                    <td><a href="area_list/{{$area->id}}" onclick="return confirm('You are about delete this data')"><button class="btn btn-outline-danger">Delete</button></a></td>
                </tr>
            @empty
             <tr>
                 <td colspan="4">No data yet</td>
             </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
<script type="text/javascript">
    const areaInput = document.getElementById('areaname');
    const areaError = document.getElementById('areanameError');
    areaInput.addEventListener('blur', () => {
        validateArea();

    });
    function validateArea() {
        const areaValue = areaInput.value.trim();

        if (areaValue === '') {
            areaInput.style.borderColor = 'red'; // Change border color to red
            areaError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        areaInput.style.borderColor = '#ccc'; // Reset border color
        areaError.style.display = 'none'; // Hide error message
        return true;
    }

    const areatitleInput = document.getElementById('areatitle');
    const areatitleError = document.getElementById('areatitleError');
    areatitleInput.addEventListener('blur', () => {
        validateAreatitle();

    });
    function validateAreatitle() {
        const areatitleValue = areatitleInput.value.trim();

        if (areatitleValue === '') {
            areatitleInput.style.borderColor = 'red'; // Change border color to red
            areatitleError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        areatitleInput.style.borderColor = '#ccc'; // Reset border color
        areatitleError.style.display = 'none'; // Hide error message
        return true;
    }
</script>
    
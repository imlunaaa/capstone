<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Campuses') }}
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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampusModal">Add Campus</button>
    <!-- Modal -->
    <div class="modal fade" id="addCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Campus</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('campus_list') }}">
              <div class="modal-body">
                    @csrf
                    <label for="campus">Campus</label>
                    <input id="campus" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="campus" value="{{ old('campus') }}" required autofocus>
                    <div id="campusError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter campus name.</div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Add Campus</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Campus</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($campuses As $campus)
                <tr>
                    <td>{{$campus->name}}</td>
                    <td><a href="edit_campus/{{$campus->id}}"><button class="btn btn-outline-success">Edit</button></a></td>
                    <td><a href="campus_list/{{$campus->id}}" onclick="return confirm('You are about delete this data')"><button class="btn btn-outline-danger">Delete</button></a></td>
                </tr>
            @empty
             <tr>
                 <td colspan="3">No data yet</td>
             </tr>
            @endforelse
        </tbody>
    </table>
    </div>

</x-app-layout>
<script type="text/javascript">
    const campusInput = document.getElementById('campus');
    const campusError = document.getElementById('campusError');
    campusInput.addEventListener('blur', () => {
        validateCampus();

    });
    function validateCampus() {
        const campusValue = campusInput.value.trim();

        if (campusValue === '') {
            campusInput.style.borderColor = 'red'; // Change border color to red
            campusError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        campusInput.style.borderColor = '#ccc'; // Reset border color
        campusError.style.display = 'none'; // Hide error message
        return true;
    }
</script>
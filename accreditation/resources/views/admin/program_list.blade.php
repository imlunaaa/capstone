<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Programs') }}
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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampusModal">Add Program</button>
    <!-- Modal -->
    <div class="modal fade" id="addCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Progam</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('program_list') }}">
              <div class="modal-body">
                    @csrf
                    <label for="program">Program</label>
                    <input id="program" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="program" value="{{ old('program') }}" required autofocus>
                    <div id="programError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter program name.</div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Add Program</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Program</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs As $program)
                <tr>
                    <td>{{$program->program}}</td>
                    <td><a href="edit_program/{{$program->id}}"><button class="btn btn-outline-success">Edit</button></a></td>
                    <td><a href="program_list/{{$program->id}}" onclick="return confirm('You are about delete this data')"><button class="btn btn-outline-danger">Delete</button></a></td>
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
    const programInput = document.getElementById('program');
    const programError = document.getElementById('programError');
    programInput.addEventListener('blur', () => {
        validateProgram();

    });
    function validateProgram() {
        const programValue = programInput.value.trim();

        if (programValue === '') {
            programInput.style.borderColor = 'red'; // Change border color to red
            programError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        programInput.style.borderColor = '#ccc'; // Reset border color
        programError.style.display = 'none'; // Hide error message
        return true;
    }
</script>
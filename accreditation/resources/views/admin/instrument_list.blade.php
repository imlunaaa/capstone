<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Instruments') }}
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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCampusModal">Add Instrument</button>
        <!-- Modal -->
        <div class="modal fade" id="addCampusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Instrument</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form method="POST" action="{{ route('instrument_list') }}">
                  <div class="modal-body">
                        @csrf
                        <label for="Program">Program</label>
                        <select name="program" class="form-select  @error('program') is-invalid @enderror">
                            <option selected disabled>Select Program</option>
                            @forelse($programs as $program)
                            <option value="{{$program->id}}" {{ @old('program') == $program->id ? 'selected':'' }}>{{$program->program}}</option>
                            @empty
                            @endforelse
                        </select>
                        <div id="programError" class="invalid-feedback">
                            @error('program') <p>Please select a program.</p> @enderror
                        </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Add Instrument</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Program</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($instruments As $instrument)
                    <tr>
                        <td>{{$instrument->ins_id}}</td>
                        <td>{{$instrument->program}}</td>
                        <td><a href="view_areas/{{$instrument->ins_id}}"><button class="btn btn-outline-primary">View Areas</button></a></td>
                        <td><a href="area_list/{{$instrument->ins_id}}" onclick="return confirm('You are about delete this data')"><button class="btn btn-outline-danger">Delete</button></a></td>
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
<script>
    $(document).ready(function(){
        @if ($errors->any())
            $('#addCampusModal').modal('show');
        @endif
    });
    
</script>
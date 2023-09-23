<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Accreditation') }}
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

    <!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif -->
    <div class="p-4">
        @if(Auth::user()->user_type == "admin")
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAccreditationModal">Create Accreditation</button>
        @endif
        <div class="row row-cols-2 g-2 my-3">
            @forelse($accreditations AS $accreditation)
            <div class="col">
                @if(Auth::user()->user_type == "admin")
                <a href="#">
                @endif
                <a href="/manage_parameters/">
                    <div class="card text-bg-light mb-3 shadow p-3 bg-body rounded" >
                        <div class="card-header bg-transparent fs-3">{{ $accreditation->accreditation_name}}: Level {{ $accreditation->prog_level}}</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $accreditation->accreditation_name}}</h5>
                            <p class="card-text">Campus: <b>{{ $accreditation->cname }}</b></p>
                            <p class="card-text">Program: <b>{{ $accreditation->prog }}</b></p>
                            <p class="card-text">Accreditation type: <b>{{ $accreditation->accreditation_type }}</b></p>
                            <p class="card-text">Internal Accreditation: 
                                <b>{{ \Carbon\Carbon::parse($accreditation->internal_accreditation_date_start)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($accreditation->internal_accreditation_date_end)->format('M d, Y') }}</b>
                            </p>
                            <p class="card-text">External Accreditation: 
                                <b>{{ \Carbon\Carbon::parse($accreditation->external_accreditation_date_start)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($accreditation->external_accreditation_date_end)->format('M d, Y') }}</b>
                            </p>
                        </div>
                        
                        <div class="card-footer bg-transparent text-end">
                            <a href="/manage_member/{{$accreditation->id}}"><button class="btn btn-outline-primary">View Members</button></a>
                            @if(Auth::user()->user_type == "admin")
                            <a href=""><button class="btn btn-outline-success">Edit</button></a>
                            <a href="/manage_accreditation/{{$accreditation->id}}"><button class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete</button></a>
                            @endif
                        </div>
                        
                    </div>
                </a>
            </div>
        
            @empty
            <div class="col-12">
                <div class="fs-2"><center>No Accreditation at the moment</center></div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addAccreditationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Create Accreditation</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="{{ route('add_accreditation') }}">
              <div class="modal-body">
                    <div class="row p-2">
                        @csrf
                        <label for="accreditation_name" class="form-label">Accreditation Name</label>
                        <input type="text" class="form-control @error('accreditation_name') is-invalid @enderror" id="accreditation_name" name="accreditation_name" value="{{ old('accreditation_name') }}" autofocus>
                        <div id="accreditation_nameError" class="invalid-feedback">
                            @error('accreditation_name') {{$message}} @enderror
                        </div>

                        <label for="program" class="form-label">Program</label>
                        <select name="program" class="form-select @error('program') is-invalid @enderror">
                            <option selected disabled>Select Option</option>
                            @foreach($programLevels AS $programLevel)
                            <option value="{{$programLevel->plID}}"  {{ @old('program') == $programLevel->plID ? 'selected' :'' }}>{{$programLevel->cname}} : {{$programLevel->prog}} - Level {{$programLevel->level}}</option>
                            @endforeach
                        </select>
                        <div id="programError" class="invalid-feedback">
                            @error('program') {{$message}} @enderror
                        </div>

                        <label for="acc_type" class="form-label">Accreditation Type</label>
                        <select name="acc_type" class="form-select @error('acc_type') is-invalid @enderror">
                            <option selected disabled value="">Select option</option>
                            <option value="New" {{ @old('acc_type') == 'New' ? 'selected':'' }}>New</option>
                            <option value="Old" {{ @old('acc_type') == 'Old' ? 'selected':'' }}>Old</option>
                        </select>
                        <div id="acc_typeError" class="invalid-feedback">
                            @error('acc_type') {{$message}} @enderror
                        </div>

                        <center><h4 class="fs-4">Internal Accreditation</h4></center>
                        <label for="inter_date_start" class="form-label">Internal Accreditaion Start Date</label>
                        <input id="inter_date_start" class="form-control @error('inter_date_start') is-invalid @enderror" type="date" name="inter_date_start" value="{{ old('inter_date_start') }}" autofocus>
                        <div id="inter_date_startError"  class="invalid-feedback">
                            @error('inter_date_start') {{$message}} @enderror
                        </div>

                        <label for="inter_date_end" class="form-label">Internal Accreditaion End Date</label>
                        <input id="inter_date_end" class="form-control @error('inter_date_end') is-invalid @enderror" type="date" name="inter_date_end" value="{{ old('inter_date_end') }}"  autofocus>
                        <div id="inter_date_endError"  class="invalid-feedback">
                            @error('inter_date_end') {{$message}} @enderror
                        </div>


                        <center><h4 class="fs-4">Enternal Accreditation</h4></center>
                        <label for="exter_date_start" class="form-label">External Accreditaion Start Date</label>
                        <input id="exter_date_start" class="form-control @error('exter_date_start') is-invalid @enderror" type="date" name="exter_date_start" value="{{ old('exter_date_start') }}" autofocus>
                        <div id="exter_date_startError" class="invalid-feedback">
                            @error('exter_date_start') {{$message}} @enderror
                        </div>

                        <label for="exter_date_end" class="form-label">External Accreditaion End Date</label>
                        <input id="exter_date_end" class="form-control @error('exter_date_end') is-invalid @enderror" type="date" name="exter_date_end" value="{{ old('exter_date_end') }}" autofocus>
                        <div id="exter_date_endError" class="invalid-feedback">
                            @error('exter_date_end') {{$message}} @enderror
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary">Create Accreditation</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function(){
        @if ($errors->any())
            $('#addAccreditationModal').modal('show');
        @endif
    });
    
</script>
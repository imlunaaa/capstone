<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Program Level') }}
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
    <a href="/program_level_list"><button class="btn btn-outline-secondary">Go Back</button></a>
    <div class="p-6">
    	<form method="POST" action="/edit_program_level/{{$programLevel[0]->id}}">
            @csrf
            <label for="campus">Campus</label>
            <select name="campus" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required>
                <option selected disabled>Select Campus</option>
                @forelse($campuses as $campus)
                <option value="{{$campus->id}}" {{$campus->id == $programLevel[0]->campus_id ? 'selected' : ''}}>{{$campus->name}}</option>
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
                <option value="{{$program->id}}" {{$program->id == $programLevel[0]->program_id ? 'selected' : ''}}>{{$program->program}}</option>
                @empty
                @endforelse
            </select>
            <div id="programError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please select an program.
            </div>

            <label class="form-label">Level</label>
            <input type="number" name="level" class="form-control" min="1" max="5" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required value="{{$programLevel[0]->level}}">
            <div id="levelError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please enter level.
            </div>

            <label for="validity_from">Validity From</label>
            <input type="date" name="validity_from" id="validity_from" class="form-control" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required value="{{$programLevel[0]->validity_from}}">
            <div id="validity_fromError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please select an date.
            </div>

            <label for="validity_to">Validity To</label>
            <input type="date" name="validity_to" id="validity_to" class="form-control" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" required value="{{$programLevel[0]->validity_to}}">
            <div id="validity_toError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                Please select an date.
            </div>
            <button type="submit" name="submit" id="submit" class="btn btn-outline-warning">Save Changes</button>
        </form>
    </div>
</x-app-layout>
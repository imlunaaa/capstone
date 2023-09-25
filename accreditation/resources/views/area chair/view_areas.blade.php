<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Area') }} of of {{$instrument->program}}
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
        <a href=""><button class="btn btn-outline-secondary">Go Back</button></a>
    <table class="table">
        <thead>
            <tr>
                <th>Area Name</th>
                <th>Area Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($areas As $area)
                <tr>
                    <td>{{$area->area_name}}</td>
                    <td>{{$area->area_title}}</td>
                    <td><a href="/view_parameters/{{$area->aid}}"><button class="btn btn-outline-primary">View Parameters</button></a></td>
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
    
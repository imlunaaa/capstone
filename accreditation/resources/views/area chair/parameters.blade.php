<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parameters') }}
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
        <table class="table">
        <thead>
            <tr>
                <th>Area Name</th>
                <th>Parameter</th>
                <th>Parameter Title</th>
                <th>Area Title</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parameters As $parameter)
                <tr>
                    <td>{{$parameter->area->area_name}}</td>
                    <td>{{$parameter->parameter}}</td>
                    <td>{{Str::limit($parameter->parameter_title, 50)}}</td>
                    <td>{{$parameter->area->area_title}}</td>
                    <td><a href="/view_indicator_areachair/{{$parameter->paramID}}"><button class="btn btn-outline-primary">View  Indicators</button></a></td>
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
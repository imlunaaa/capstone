<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Parameter {{ $parameter->parameter }} Files: {{ $parameter->parameter_title }}
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
    <div class="p-6">
        <a href="{{  URL::previous() }}"><button class="btn btn-outline-secondary">Go Back</button></a>
        <div class="row p-2">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">Upload Form</div>
                    <div class="card-body">
                        <form method="POST" action="/upload_files_indicator" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="indicator_id" value="{{$indicator_id}}">
                            <input type="hidden" name="parameter_id" value="{{$parameter_id}}">
                            <input type="file" name="files[]" class="form-control @error('files') is-invalid @enderror" value="{{@old('files')}}" multiple><br>
                            <input type="submit" class="btn btn-outline-success" value="Upload">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>File Type</th>
                            <th>Uploaded At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>{{$file->file_name}}</td>
                                <td>{{$file->file_type}}</td>
                                <td>{{date('M d, Y h:i A', strtotime($file->created_at))}} ({{\Carbon\Carbon::parse($file->created_at)->diffForHumans()}})</td>
                                <td><a target='_blank' href="/view_indicator_file/{{$file->id}}"><button class="btn btn-outline-primary">View</button></a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><center>No Files Yet</center></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
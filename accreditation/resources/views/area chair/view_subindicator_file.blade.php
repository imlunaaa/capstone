<x-app-layout>
	<div class="container mx-auto">
		<a href="{{  URL::previous() }}"><button class="btn btn-outline-secondary">Go Back</button></a>
		<iframe height="500px" width="100%" src="{{asset($file->file_location)}}" ></iframe>
	</div>
</x-app-layout>
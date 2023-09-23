<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Area Chair/Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in as Area Chair/Member!") }}
                </div>
            </div>
        </div>
    </div>
    <div class="p-6">
        <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ asset('storage/pdf/document.pdf') }}" frameborder="0" style="width:100%;min-height:640px;"></iframe>
        <div id="pspdfkit" style="height: 100vh"></div>
    </div>
    <script src="{{ asset('assets/pspdfkit.js') }}"></script>
    <script>

        // PSPDFKit.load({
        //     container: "#pspdfkit",
        //     document: "{{ asset('storage/pdf/document.pdf') }}" // Add the path to your document here.
        // })
        // .then(function(instance) {
        //     console.log("PSPDFKit loaded", instance);
        // })
        // .catch(function(error) {
        //     console.error(error.message);
        // });
        
    </script>

</x-app-layout>

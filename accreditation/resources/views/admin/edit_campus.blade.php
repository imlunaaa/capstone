<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Campus') }}
        </h2>
    </x-slot>
    <a href="/campus_list"><button class="btn btn-outline-secondary">Go Back</button></a>
    <div class="p-6">
    	<form action="/edit_campus/<?php echo $campus[0]->id; ?>" method="post">
    		@csrf
	        <label for="campus">Campus</label>
	        <input id="campus" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="campus" value="<?php echo $campus[0]->name; ?>" required autofocus>
	        <div id="campusError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter campus name.</div>
	        <input type="submit" name="" value="Save Changes" class="btn btn-outline-success">
    	</form>
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

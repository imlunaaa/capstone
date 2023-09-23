<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Campus') }}
        </h2>
    </x-slot>
    <a href="/program_list"><button class="btn btn-outline-secondary">Go Back</button></a>
    <div class="p-6">
    	<form action="/edit_program/<?php echo $program[0]->id; ?>" method="post">
    		@csrf
	        <label for="program">Campus</label>
	        <input id="program" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="program" value="<?php echo $program[0]->program; ?>" required autofocus>
	        <div id="programError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter program name.</div>
	        <input type="submit" name="" value="Save Changes" class="btn btn-outline-success">
    	</form>
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
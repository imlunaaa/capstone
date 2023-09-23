<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Area') }}
        </h2>
    </x-slot>
    <div class="p-6">
        <a href="{{  URL::previous() }}"><button class="btn btn-outline-secondary">Go Back</button></a>
        <div class="p-4">
            <form method="POST" action="/edit_area/<?php echo $area[0]->id; ?>">
              <div>
                    @csrf
                    <label for="areaname">Area Name</label>
                    <input id="areaname" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="areaname" value="<?php echo $area[0]->area_name; ?>" required autofocus>
                    <div id="areanameError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter area.
                    </div>
                    <label for="areatitle">Area Title</label>
                    <input id="areatitle" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="areatitle" value="<?php echo $area[0]->area_title; ?>" required autofocus>
                    <div id="areatitleError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">
                        Please enter area name.
                    </div>
              </div>
                <button type="submit" class="btn btn-outline-primary">Save changess</button>
          </form>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
    const areaInput = document.getElementById('areaname');
    const areaError = document.getElementById('areanameError');
    areaInput.addEventListener('blur', () => {
        validateArea();

    });
    function validateArea() {
        const areaValue = areaInput.value.trim();

        if (areaValue === '') {
            areaInput.style.borderColor = 'red'; // Change border color to red
            areaError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        areaInput.style.borderColor = '#ccc'; // Reset border color
        areaError.style.display = 'none'; // Hide error message
        return true;
    }

    const areatitleInput = document.getElementById('areatitle');
    const areatitleError = document.getElementById('areatitleError');
    areatitleInput.addEventListener('blur', () => {
        validateAreatitle();

    });
    function validateAreatitle() {
        const areatitleValue = areatitleInput.value.trim();

        if (areatitleValue === '') {
            areatitleInput.style.borderColor = 'red'; // Change border color to red
            areatitleError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        areatitleInput.style.borderColor = '#ccc'; // Reset border color
        areatitleError.style.display = 'none'; // Hide error message
        return true;
    }
</script>
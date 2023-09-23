<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="py-12">
        <form method="POST" action="/edit_user/{{$user->id}}" class="p-4">
            @csrf
            <div>
                <label for="firstname">Firstname</label>
                <input id="firstname" style="margin-top: 0.25rem; width: 100%; border: 1px solid #ccc;" type="text" name="firstname" value="{{$user->firstname }}" required autofocus>
                <div id="firstnameError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter a firstname.</div>
            </div>


            <div>
                <label for="lastname">Lastname</label>
                <input id="lastname" style="margin-top: 0.25rem; width: 100%;" type="text" name="lastname" value="{{ $user->lastname }}" required autofocus>
                <div id="lastnameError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter a lastname.</div>
            </div>
            <div style="margin-top: 1rem;">
                <label for="campus">Campus</label>
                <select name="campus">
                    <option selected disabled>Select Campus</option>
                    @forelse($campuses as $campus)
                    <option value="{{$campus->id}}" {{$campus->id == $user->campus_id ? 'selected' : ''}}>{{$campus->name}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div style="margin-top: 1rem;">
                <label for="Program">Program</label>
                <select name="program">
                    <option selected disabled>Select Program</option>
                    @forelse($programs as $program)
                    <option value="{{$program->id}}" {{$program->id == $user->program_id ? 'selected' : ''}}>{{$program->program}}</option>
                    @empty
                    @endforelse
                </select>
            </div>

            <!-- <label for="areachair">Area Chair</label>
            <input type="checkbox" id="areachair" name="areachair" value="1" {{$user->isAreachair == 1 ? 'checked' : ''}}><br>
            <label for="areamember">Area Member</label>
            <input type="checkbox" id="areamember" name="areamember" value="1" {{$user->isAreamember == 1 ? 'checked' : ''}}><br>
            <label for="external">External</label>
            <input type="checkbox" id="external" name="external" value="1" {{$user->isExternal == 1 ? 'checked' : ''}}><br>
            <label for="internal">Internal</label>
            <input type="checkbox" id="internal" name="internal" value="1" {{$user->isIntenal == 1 ? 'checked' : ''}}><br> -->

            <!-- <div style="margin-top: 1rem;">
                <label for="email">Email</label>
                <input id="email" style="margin-top: 0.25rem; width: 100%;" type="email" name="email" value="{{ $user->email }}" disabled>
                <div id="emailError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter a email address.</div>
            </div> -->

           <!--  <div style="margin-top: 1rem;">
                <label for="password">Password</label>
                <input id="password" style="margin-top: 0.25rem; width: 100%;" type="password" name="password" required>
                <div id="passError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter a password.</div>
            </div>

            <div style="margin-top: 1rem;">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" style="margin-top: 0.25rem; width: 100%;" type="password" name="password_confirmation" required>
                <div id="cpassError" style="color: red; font-size: 0.75rem; margin-top: 0.25rem; display: none;">Please enter a password.</div>
            </div> -->

            <div style="display: flex; align-items: center; justify-content: flex-end; margin-top: 1rem;">
                <button style="margin-left: 0.5rem; padding: 0.5rem 1rem; background-color: #6366F1; color: #FFF; border: none; border-radius: 0.375rem; cursor: pointer;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

<script type="text/javascript">
    const form = document.getElementById('registrationForm');
    const firstnameInput = document.getElementById('firstname');
    const firstnameError = document.getElementById('firstnameError');
    const lastnameInput = document.getElementById('lastname');
    const lastnameError = document.getElementById('lastnameError');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const passInput = document.getElementById('password');
    const passError = document.getElementById('passError');
    const cpassInput = document.getElementById('password_confirmation');
    const cpassError = document.getElementById('cpassError');

    // Add event listener to trigger validation on focus out
    firstnameInput.addEventListener('blur', () => {
        validateFirstname();

    });
    lastnameInput.addEventListener('blur', () => {
        validateLastname();
        
    });

    // Add event listener to trigger validation on form submission
    form.addEventListener('submit', (event) => {
        if (!validateFirstname() || !validateLastname() ) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    function validateFirstname() {
        const firstnameValue = firstnameInput.value.trim();

        if (firstnameValue === '') {
            firstnameInput.style.borderColor = 'red'; // Change border color to red
            firstnameError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        firstnameInput.style.borderColor = '#ccc'; // Reset border color
        firstnameError.style.display = 'none'; // Hide error message
        return true;
    }
    function validateLastname() {
        const lastnameValue = lastnameInput.value.trim();

        if (lastnameValue === '') {
            lastnameInput.style.borderColor = 'red'; // Change border color to red
            lastnameError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        lastnameInput.style.borderColor = '#ccc'; // Reset border color
        lastnameError.style.display = 'none'; // Hide error message
        return true;
    }
    function validateEmail() {
        const value = emailInput.value.trim();

        if (value === '') {
            emailInput.style.borderColor = 'red'; // Change border color to red
            emailError.style.display = 'block'; // Show error message
            return false;
        }

        // Clear any existing error message or class
        emailInput.style.borderColor = '#ccc'; // Reset border color
        emailError.style.display = 'none'; // Hide error message
        return true;
    }

    // function validatePass() {
    //     const value = passInput.value.trim();

    //     if (value == '') {
    //         passInput.style.borderColor = 'red'; // Change border color to red
    //         passError.style.display = 'block'; // Show error message
    //         return false;
    //     }
    //     if (value.length < 6) {
    //         passInput.style.borderColor = 'red'; // Change border color to red
    //         passError.style.display = 'block'; // Show error message
    //         passError.textContent = 'Password must be atleast 6 characters long';
    //         return false;
    //     }

    //     // Clear any existing error message or class
    //     passInput.style.borderColor = '#ccc'; // Reset border color
    //     passError.style.display = 'none'; // Hide error message
    //     return true;
    // }
    // function validateCpass() {
    //     const value = cpassInput.value.trim();
    //     const value2 = passInput.value.trim();

    //     if (value == '') {
    //         cpassInput.style.borderColor = 'red'; // Change border color to red
    //         cpassError.style.display = 'block'; // Show error message
    //         return false;
    //     }
    //     if (value != value2) {
    //         cpassInput.style.borderColor = 'red'; // Change border color to red
    //         cpassError.style.display = 'block'; // Show error message
    //         cpassError.textContent = 'Password does not match';
    //         return false;
    //     }

    //     // Clear any existing error message or class
    //     cpassInput.style.borderColor = '#ccc'; // Reset border color
    //     cpassError.style.display = 'none'; // Hide error message
    //     return true;
    // }

    // Add similar validation functions for other fields as needed
</script>


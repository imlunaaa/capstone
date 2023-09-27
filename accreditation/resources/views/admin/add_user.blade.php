<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>
    <div class="py-12">
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
        <!-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="bg shadow p-4 mb-4 bg-body">
                        <form method="POST" action="{{ route('add_user') }}">
                            @csrf
                            <h4 class="fs-4 text-center mb-4">Add User Form</h4>
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Firstname</label>
                                <input id="firstname" class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname" value="{{ old('firstname') }}" autofocus>
                                <div id="firstnameError" class="invalid-feedback">
                                    @error('firstname')<p>{{ $message }}</p>  @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname</label>
                                <input id="lastname" class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" value="{{ old('lastname') }}">
                                <div id="lastnameError" class="invalid-feedback">
                                    @error('lastname') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="campus" class="form-label">Campus</label>
                                <select name="campus" class="form-select @error('campus') is-invalid @enderror">
                                    <option selected disabled>Select Campus</option>
                                    @forelse($campuses as $campus)
                                    <option value="{{$campus->id}}" {{ @old('campus') == $campus->id ? 'selected':'' }}>{{$campus->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="campusError" class="invalid-feedback">
                                    @error('campus') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="Program">Program</label>
                                <select name="program" class="form-select @error('program') is-invalid @enderror">
                                    <option selected disabled>Select Program</option>
                                    @forelse($programs as $program)
                                    <option value="{{$program->id}}" {{ @old('program') == $program->id ? 'selected':'' }}>{{$program->program}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div id="programError" class="invalid-feedback">
                                    @error('program') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}">
                                <div id="emailError" class="invalid-feedback">
                                    @error('email') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password">
                                <div id="passError" class="invalid-feedback">
                                    @error('password') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation">
                                <div id="cpassError" class="invalid-feedback">
                                    @error('password_confirmation') <p>{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-outline-primary" type="submit">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    emailInput.addEventListener('blur', () => {
        validateEmail();
        
    });
    passInput.addEventListener('blur', () => {
        validatePass();
        
    });
    cpassInput.addEventListener('blur', () => {
        validateCpass();
        
    });

    // Add event listener to trigger validation on form submission
    form.addEventListener('submit', (event) => {
        if (!validateFirstname() || !validateLastname() || !validateEmail() || !validatePass() ||
!validateCpass()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });

    function validateFirstname() {
        const firstnameValue = firstnameInput.value.trim();
        if (firstnameValue === '') {
            firstnameInput.style.borderColor = 'red'; // Change border color to red
            firstnameError.style.display = 'block';
            firstnameError.innerHTML = "<p>Please enter a firstname</p>";

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
            lastnameError.style.display = 'block';
            lastnameError.innerHTML = "<p>Please enter a lastname</p>";
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
            emailError.innerHTML = "<p>Please enter a email address</p>";

            return false;
        }

        // Clear any existing error message or class
        emailInput.style.borderColor = '#ccc'; // Reset border color
        emailError.style.display = 'none'; // Hide error message
        return true;
    }

    function validatePass() {
        const value = passInput.value.trim();

        if (value == '') {
            passInput.style.borderColor = 'red'; // Change border color to red
            passError.style.display = 'block'; // Show error message
            passError.innerHTML = "<p>Please enter a password</p>";
            return false;
        }
        if (value.length < 6) {
            passInput.style.borderColor = 'red'; // Change border color to red
            passError.style.display = 'block'; // Show error message
            passError.textContent = 'Password must be atleast 6 characters long';
            return false;
        }

        // Clear any existing error message or class
        passInput.style.borderColor = '#ccc'; // Reset border color
        passError.style.display = 'none'; // Hide error message
        return true;
    }
    function validateCpass() {
        const value = cpassInput.value.trim();
        const value2 = passInput.value.trim();

        if (value == '') {
            cpassInput.style.borderColor = 'red'; // Change border color to red
            cpassError.style.display = 'block'; // Show error message
            cpassError.innerHTML = "<p>Please enter a password</p>";

            return false;
        }
        if (value != value2) {
            cpassInput.style.borderColor = 'red'; // Change border color to red
            cpassError.style.display = 'block'; // Show error message
            cpassError.textContent = 'Password does not match';
            return false;
        }

        // Clear any existing error message or class
        cpassInput.style.borderColor = '#ccc'; // Reset border color
        cpassError.style.display = 'none'; // Hide error message
        return true;
    }

    // Add similar validation functions for other fields as needed
</script>


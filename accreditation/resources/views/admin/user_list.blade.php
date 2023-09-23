<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users') }}
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
        <div class="row py-2">
            <div class="col-4">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search User">
            </div>
        </div>
        <table class="table"> 
            <thead>
                <tr>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Program</th>
                    <th>Campus</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="user_table">
                @forelse($users AS $user)
                @php
                    $roles = array();
                    if($user->isAdmin == 1):
                        array_push($roles, 'Admin');
                    endif;

                    if($user->isAreachair == 1):
                        array_push($roles, 'Area Chair');
                    endif;

                    if($user->isAreamember == 1):
                        array_push($roles, 'Area Member');
                    endif;

                    if($user->isExternal == 1):
                         array_push($roles, 'External Accreditor');
                    endif;

                    if($user->isInternal == 1):
                         array_push($roles, 'Internal Accreditor');
                    endif;

                    $role = implode(", ", $roles);

                @endphp
                <tr>
                    <td>{{$user->lastname}}</td>
                    <td>{{$user->firstname}}</td>
                    <td>{{$user->program}}</td>
                    <td>{{$user->campus_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->user_type}}</td>
                    <td><a href="/edit_user/{{$user->id}}"><button class="btn btn-outline-success">Edit</button></a></td>
                    <td><a href="/user_list/{{$user->id}}"><button class="btn btn-outline-danger" onclick="return confirm('You are about to delete this accont')">Delete</button></a></td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#search').keyup(function(){
        search_table_users($(this).val());
        });

        function search_table_users(value)
        {
            $('#user_table tr').each(function(){
                var found = 'false';
                $(this).each(function(){
                   if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)
                   {
                        found = 'true';
                   }
                });
                if(found == 'true')
                {
                    $(this).show();
                }
                else
                {
                    $(this).hide();
                }
            });
        }
    });
</script>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$accreditation->accreditation_name}}: {{ __('Members') }}
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
        <div class="row">
            <div class="col">
                <a href="/manage_accreditation">
                    <button class="btn btn-outline-secondary">
                        Go Back
                    </button>
                </a>
            </div>
            @if(Auth::user()->user_type == 'admin' || $roles->isCoordinator == 1)
            <div class="col text-end">
                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">Add Members</button>
            </div>
            @endif
            <!-- Modal -->
            <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Member</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="/add_member" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="row py-2">
                                <div class="col">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                                </div>
                            </div>
                            <table>
                                <tbody id="user_table" class="list-group list-group-flush">
                                    @forelse($users as $key => $user)
                                        <tr class="list-group-item list-group-item-action list-group-item-light">
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" name="members[]" class="form-check-input" value="{{$user->id}}" id="{{$user->id}}" >
                                                    <label class="form-check-label" for="{{$user->user_id}}"><b class="fs-5">{{$user->lastname}} {{$user->firstname}}</b> <span class="fs-6">({{$user->campus_name}})</span>
                                                    <p class="fs-6">{{$user->program}}</p>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <center><a href="/add_users"><i class="fa-solid fa-user-plus"></i> No users, Add Here</a></center>
                                    @endforelse
                                </tbody>
                            </table>
                            <input type="hidden" name="acc_id" value="{{$id}}">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary">Save changes</button>
                        </div>
                    </form>
                </div>
              </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-4">
                <input type="text" name="search_member" id="search_member" class="form-control" placeholder="Search Member">
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="members_table">
                @forelse($members AS $member)
                @php
                    $member_roles = array();

                    if($member->isMember == 1):
                        array_push($member_roles, 'Member');
                    endif;

                    if($member->isAdmin == 1):
                        array_push($member_roles, 'Admin');
                    endif;

                    if($member->isAreachair == 1):
                        array_push($member_roles, 'Area Chair');
                    endif;

                    if($member->isAreamember == 1):
                        array_push($member_roles, 'Area Member');
                    endif;

                    if($member->isExternal == 1):
                         array_push($member_roles, 'External Accreditor');
                    endif;

                    if($member->isInternal == 1):
                         array_push($member_roles, 'Internal Accreditor');
                    endif;
                    if($member->isCoordinator == 1):
                         array_push($member_roles, 'Coordinator');
                    endif;

                    $role = implode(", ", $member_roles);
                @endphp
                <tr>
                    <td>
                        <b>{{$member->lname}} {{$member->fname}}</b>
                    </td>
                    <td>@php echo $role @endphp </td>
                    <td>
                        @if(Auth::user()->user_type == 'user')
                        <a>
                        @else
                        <a href="/remove_member/{{$member->mid}}">
                        @endif
                            <button class="btn btn-outline-danger" @if(Auth::user()->user_type == 'user' && $roles->isCoordinator != 1) disabled @endif >
                                Remove <i class="fa-solid fa-user-minus"></i>
                            </button>
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#roleModal{{$member->mid}}" @if(Auth::user()->user_type == 'user' && $roles->isCoordinator != 1) disabled @endif >
                            Roles <i class="fa-solid fa-user"></i>
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="roleModal{{$member->mid}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><b>{{$member->lname}} {{$member->fname}}</b></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="/update_role/{{$member->mid}}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <div class="form-group py-2">
                                    <div class="form-check">
                                        <input type="checkbox" id="coordinator" name="coordinator" value="1" class="form-check-input @error('coordinator') is-invalid @enderror" {{$member->isCoordinator == 1 ? 'checked' : ''}}>
                                        <label for="coordinator" class="form-check-label">Coordinator</label>
                                    </div>
                                    <div id="coordinatorError"  class="invalid-feedback">
                                        @error('coordinator') <p>Please select a role.</p> @enderror
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" id="internal" name="internal" value="1" class="form-check-input @error('internal') is-invalid @enderror" {{$member->isInternal == 1 ? 'checked' : ''}}>
                                        <label for="internal" class="form-check-label">Internal Accreditor</label>
                                    </div>
                                    <div id="programError"  class="invalid-feedback">
                                        @error('internal') <p>Please select a role.</p> @enderror
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="checkbox" id="external" name="external" value="1" class="form-check-input @error('external') is-invalid @enderror" {{$member->isExternal == 1 ? 'checked' : ''}} >
                                        <label for="external" class="form-check-label">External Accreditor</label>
                                    </div>
                                    <div id="externalError"  class="invalid-feedback">
                                        @error('external') <p>Please select a role.</p> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                @if(Auth::user()->user_type == 'admin' || $roles->isCoordinator == 1)  
                                        <button type="submit" class="btn btn-outline-primary">Save changes</button>
                                @endif
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
                @empty
                    <tr>
                        <td colspan="3">
                            <center>
                               <i class="fa-solid fa-user-plus"></i> No members yet, 
                               <span data-bs-toggle="modal" data-bs-target="#addMemberModal" style="cursor:pointer;"><u>Add here </u></span>
                            </center>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div id="no_results" style="display: none;">
            <center>User doesn't exist</center>
        </div>
        <div class="py-4">

        </div>
        @if(Auth::user()->user_type == 'admin' || $roles->isCoordinator == 1)
        <div class="row">
            <div class="col-4 mx-auto">
                <center><p class="card-text fs-2">Select Area to Tackle</p></center>
                <button class="btn btn-outline-secondary w-100" data-bs-toggle="modal" data-bs-target="#areaModal">SELECT AREA</button>
            </div>
        </div>
        @endif
        @php
            $headerColors = ['bg-primary', 'bg-secondary', 'bg-info', 'bg-success', 'bg-warning', 'bg-danger'];
        @endphp
        <div class="row mx-auto">
            @forelse($acc_areas AS $index => $area)
            @php
                $colorClass = $headerColors[$index % count($headerColors)];
                $areaMembersInArea = $area_members->where('area_id', $area->aid); // Filter area_members for the current area
            @endphp
            <div class="col-lg-4 col-md-6 col-sm-12 p-2">
                <div class="card">
                    <div class="card-header bg {{$colorClass}} bg-opacity-50">
                        <div class="row">
                            <div class="col-11">
                                <b>{{ $area->area_name }}: {{ $area->area_title }}</b>
                            </div>
                            <div class="col-1 text-end">
                                @if(Auth::user()->user_type == 'admin' || $roles->isCoordinator == 1)
                                    <a href="/remove_area/{{$area->acc_areaId}}">
                                        <i class="fa-solid fa-xmark fa-lg"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="height: 400px; overflow-y:auto">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title">Area Chair/s</h5>
                            </div>
                            <div class="col-4">
                                @if(Auth::user()->user_type == 'admin' || $roles->isCoordinator == 1) 
                                <button class="btn btn-outline-primary"  data-bs-toggle="modal" data-bs-target="#addAreaMemberModal{{$area->aid}}" >Add Area Char</button>
                                @endif 
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($area_members as $member)
                                    @if($member->area_id == $area->aid && $member->member_type == 'chair' )
                                    <tr>
                                        <td><b>{{$member->lname}} {{$member->fname}}</b></td>
                                        <td>
                                        @if(Auth::user()->user_type == 'user' && $roles->isCoordinator != 1) 
                                            <a>
                                        @else 
                                            <a href="/remove_area_member/{{$member->amId}}">
                                        @endif 
                                                <button class="btn btn-outline-danger" @if(Auth::user()->user_type == 'user' && $roles->isCoordinator != 1) disabled @endif >Remove</button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr><td colspan="2">No Area Chair yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="m-3">
                            <hr>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col">
                                <h5 class="card-title">Area Member/s</h5>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($area_members as $member)
                                    @if($member->area_id == $area->aid && $member->member_type == 'member')
                                    <tr>
                                        <td><b>{{$member->lname}} {{$member->fname}}</b></td>
                                        <td>
                                            @if(Auth::user()->user_type == 'user' && $roles->isCoordinator != 1) <a>
                                            @else
                                                <a href="/remove_area_member/{{$member->amId}}">
                                            @endif 
                                            
                                                <button class="btn btn-outline-danger" @if(Auth::user()->user_type == 'user' && $roles->isCoordinator != 1) disabled @endif >Remove</button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                    <tr><td colspan="2">No Area member yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addAreaMemberModal{{$area->aid}}" tabindex="-1" aria-labelledby="addAreaMemberLabel{{$area->aid}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addAreaMemberLabel{{$area->aid}}">Add Member to {{ $area->area_name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('add_area_members')}}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <div class="row py-2">
                                    <div class="col">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Search">
                                    </div>
                                </div>
                                <label>Select Member Type</label>
                                <select name="member_type">
                                    <option value="chair">Area Chair</option>
                                    <option value="member">Area Member</option>
                                </select>
                                <table>
                                    <tbody id="user_table" class="list-group list-group-flush">
                                        @forelse($unfilteredUser as $user)
                                            @if (!$areaMembersInArea->contains('user_id', $user->id))
                                                <tr class="list-group-item list-group-item-action list-group-item-light">
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" name="members[]" class="form-check-input" value="{{$user->id}}" id="area{{$user->user_id}}{{$area->aid}}" >
                                                            <label class="form-check-label" for="area{{$user->user_id}}{{$area->aid}}"><b class="fs-5">{{$user->lastname}} {{$user->firstname}}</b> <span class="fs-6">({{$user->campus_name}})</span>
                                                            <p class="fs-6">{{$user->program}}</p>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <center><a href="/add_users"><i class="fa-solid fa-user-plus"></i> No users, Add Here</a></center>
                                        @endforelse
                                    </tbody>
                                </table>
                                <input type="hidden" name="area_id" value="{{$area->aid}}">
                                <input type="hidden" name="acc_id" value="{{$id}}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-4 py-5 mx-auto">
                </div>
            @endforelse
            <!-- AREAS Modal -->
            <div class="modal fade" id="areaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><b></b></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/add_area" method="POST">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="id" value="{{$id}}">
                            <div class="form-group py-2">
                                @forelse($areas as $area)
                                    <div class="form-check">
                                        <input type="checkbox" id="acc{{$area->aid}}area" name="area[]" value="{{$area->aid}}" class="form-check-input @error('{{$area->aid}}') is-invalid @enderror">
                                        <label for="acc{{$area->aid}}area" class="form-check-label">{{$area->area_name}}: {{$area->area_title}}</label>
                                    </div>
                                    <div id="coordinatorError"  class="invalid-feedback">
                                        @error('coordinator') <p>Please select a role.</p> @enderror
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            <input type="hidden" name="acc_id" value="{{$id}}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline-primary">Save changes</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
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

        $('#search_member').keyup(function () {
        search_table_members($(this).val());
        });

        function search_table_members(value) {
            var found = false; // Initialize found as false

            $('#members_table tr').each(function () {
                var row = $(this);
                var rowText = row.text().toLowerCase();

                if (rowText.indexOf(value.toLowerCase()) >= 0) {
                    row.show();
                    found = true; // Set found to true if a match is found
                } else {
                    row.hide();
                }
            });

            // Toggle the "User doesn't exist" message
            if (found) {
                $('#no_results').hide();
            } else {
                $('#no_results').show();
            }
        }

    });
</script>
@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Users Section'])
    @php
        $edit = false;
        $dataarray = json_decode($data, true);
        if (isset(json_decode($data, true)['edit_data'])) {
            $editdata = $dataarray['edit_data'][0];
            $edit = true;
        }
    @endphp
    <div class="row clearfix">
        @if ($edit)
        @if(checkmodulepermission(1,'can_edit') == 1)
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">

                    <form action="{{ url('/updateusers') }}" method="post" class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title">Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <img height="200" width="200" id="update_user_image"
                                                src="{{ asset('/' . $editdata['image']) }}"
                                                class="rounded-circle img-raised">
                                            <input type="file" accept="Image/*" name="image"
                                                onchange="document.getElementById('update_user_image').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9">
                                        <div class="row clearfix">

                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="Name">Name</label>
                                                    <input type="hidden" name="id" value="{{ $editdata['id'] }}">
                                                    <input type="text" id="Name" required class="form-control"
                                                        value="{{ $editdata['name'] }}" name="name">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="username">Username</label>

                                                    <input type="text" id="username" required class="form-control"
                                                        value="{{ $editdata['username'] }}" name="username">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="pass">Password</label>
                                                    <input type="password" id="pass" required class="form-control"
                                                        value="{{ $editdata['pass'] }}" name="pass">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group"><b>Site</b>
                                                    <select name="site_id" class="form-control show-tick"
                                                        data-live-search="true" required>
                                                        <option value="" selected disabled>--Select Site--</option>
                                                        @php
                                                            $sites = getallsites();
                                                        @endphp
                                                        @foreach ($sites as $site)
                                                            @if ($site->id == $editdata['site_id'])
                                                                <option selected value="{{ $site->id }}">
                                                                    {{ $site->name }}</option>
                                                            @else
                                                                <option value="{{ $site->id }}">{{ $site->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group"><b>Role</b>
                                                    <select name="role_id" class="form-control show-tick"
                                                        data-live-search="true" required>
                                                        <option value="" selected disabled>--Select Role--</option>
                                                        @php
                                                            $roles = getallRoles();
                                                        @endphp
                                                        @foreach ($roles as $role)
                                                            @if ($role->id == $editdata['role_id'])
                                                                <option selected value="{{ $role->id }}">
                                                                    {{ $role->name }}</option>
                                                            @else
                                                                <option value="{{ $role->id }}">{{ $role->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="pan_no">Pan No.</label>
                                                    <input type="text" id="pan_no" required class="form-control"
                                                        value="{{ $editdata['pan_no'] }}" name="pan_no">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="contact_no">Contact No.</label>
                                                    <input type="text" id="contact_no" required class="form-control"
                                                        value="{{ $editdata['contact_no'] }}" name="contact_no">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="form-group">
                                                    <label for="contact_no">Contact No.</label>
                                                    
                                                    <select name="mobile_only" class="form-control show-tick" data-live-search="true"
                                                    required>       
                                                    @if($editdata['mobile_only']=='yes')                                
                                                        <option value="no">Web & Mobile Both</option>
                                                        <option selected value="yes">Only Mobile App</option>
                                                        @else
                                                        <option selected value="no">Web & Mobile Both</option>
                                                        <option  value="yes">Only Mobile App</option>
                                                        @endif
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-9">
                                                
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <br>
                                                <button type="submit"
                                                    class="btn btn-primary btn-simple btn-round waves-effect"><a>Update</a></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            @endif
            <br>
        @endif
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Users</strong> List</h2>
                    <ul class="header-dropdown">
                        <li>
                        @if(checkmodulepermission(1,'can_add') == 1)
                            <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                data-toggle="modal" data-target="#addnewuser" type="button">
                                <i class="zmdi zmdi-plus" style="color: white;"></i>
                            </button>
                            @endif
                        </li>
                    </ul>
                </div>
                <div class="body">
                @if(checkmodulepermission(1,'can_view') == 1)
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:50px;">Name</th>
                                    <th></th>
                                    <th><strong>Site</strong></th>
                                    <th>Other Site Members</th>
                                    <th>Status</th>
                                    <th>Username</th>
                                    <th>Contact No.</th>
                                    <th>Pan No.</th>
                                    @if (Session::get('role') == 1)
                                        <th>Password</th>
                                    @endif
                                    <th>Create Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    
                                    //   $userd = json_decode($data, true);
                                    $userarray = $dataarray['data'];
                                @endphp
                                @foreach ($userarray as $userd)
                                    @php
                                        $user = json_decode(json_encode($userd), true);
                                        $userdata = [];
                                        $userlist = [];
                                        $userlist = $user['list'];
                                        $userdata = $user['data'];
                                        $ddid = $userdata['id'];
                                    @endphp

                                    <tr>
                                        <td>

                                            <img class="rounded avatar" style="max-height: 40px;"
                                                src="{{ asset('/' . $userdata['image']) }}" alt="im">
                                        </td>
                                        <td>
                                            <a class="single-user-name" href="#">{{ $userdata['name'] }}</a><br>
                                            <small>{{ getRoleDetailsById($userdata['role_id'])->name }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ getSiteDetailsById($userdata['site_id'])->name }}</strong>
                                        </td>
                                        <td class="hidden-md-down">
                                            <ul class="list-unstyled team-info margin-0">
                                                @foreach ($userlist as $ul)
                                                    <li>
                                                        <a title="{{ $ul['name'] }}"><img
                                                                src="{{ asset('/' . $ul['image']) }}"
                                                                style="max-height: 40px;" alt="{{ $ul['name'] }}"></a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                        @if ($userdata['status'] == 'Active')
                                        @if(checkmodulepermission(1,'can_certify') == 1)
                                            <span onclick="updateuserstatus('{{ $ddid }}','Deactive')"
                                                    class="badge badge-success">{{ $userdata['status'] }}</span>
                                                    @endif
                                        @else
                                        @if(checkmodulepermission(1,'can_certify') == 1)
                                           <span onclick="updateuserstatus('{{ $ddid }}','Active')"
                                                    class="badge badge-danger">{{ $userdata['status'] }}</span>
                                                @endif
                                        @endif
                                    </td>
                                        <td>{{ $userdata['username'] }}</td>
                                        <td>{{ $userdata['contact_no'] }}</td>

                                        <td>{{ $userdata['pan_no'] }}</td>
                                        @if (Session::get('role') == 1)
                                            <td>{{ $userdata['pass'] }}</td>
                                        @endif
                                        <td>{{ $userdata['create_datetime'] }}</td>
                                        <td>
                                        @if(checkmodulepermission(1,'can_edit') == 1)
                                            <button title="Assign Permission"  onclick="assignPerm({{$userdata['id']}})"
                                                style="all:unset"><img src="{{ asset('/images/permission.png') }}"
                                                    style="width:20px" /> </button>
                                                 
                                            <button title="Edit" onclick="editdata({{$userdata['id']}})" style="all:unset;"><i
                                                    class="zmdi zmdi-edit"></i> </button>
                                                    @endif
                                            @if (isUserDeletable($userdata['id']))
                                            @if(checkmodulepermission(1,'can_delete') == 1)
                                                <button title="delete" onclick="deleteUser(<?= $userdata['id'] ?>)" style="all:unset"><i
                                                        class="zmdi zmdi-delete"></i> </button>
                                             @endif
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-danger">You Don't Have Permission to View </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('models')
@if(checkmodulepermission(1,'can_add') == 1)
    <div class="modal fade" id="addnewuser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form action="addnewuser" method="post" class="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title">Add New User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <img height="200" width="200" id="user_image"
                                        src="{{ asset('/images/noprofile.jpg') }}" class="rounded-circle img-raised">
                                    <input type="file" accept="Image/*" name="image"
                                        onchange="document.getElementById('user_image').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row clearfix">
                                    <div class="col-sm-6"><b>Name</b>
                                        <div class="input-group">

                                            <input type="text" required name="name" class="form-control" required
                                                placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-md-6"> <b>Phone Number</b>
                                        <div class="input-group">

                                            <input type="number" required name="contact_no"
                                                class="form-control mobile-phone-number"
                                                placeholder="Ex: +00 (000) 000-00-00">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6"><b>Username</b>
                                        <div class="input-group">

                                            <input type="text" name="username" class="form-control" required
                                                placeholder="UserName">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><b>Password<b>
                                                <div class="input-group">

                                                    <input type="password" name="password" class="form-control" required
                                                        placeholder="Password">
                                                </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6"><b>Site</b>
                                        <div class="input-group">
                                            <select name="site_id" class="form-control show-tick" data-live-search="true"
                                                required>
                                                <option value="" selected disabled>--Select Site--</option>
                                                @php
                                                    $sites = getallsites();
                                                @endphp
                                                @foreach ($sites as $site)
                                                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><b>Role<b>
                                                <div class="input-group">
                                                    <select name="role_id" class="form-control show-tick"
                                                        data-live-search="true" required>
                                                        <option value="" selected disabled>--Select Role--</option>
                                                        @php
                                                            $roles = getallRoles();
                                                        @endphp
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-6"><b>Pan No.</b>
                                        <div class="input-group">

                                            <input type="text" name="pan_no" class="form-control" required
                                                placeholder="Pan No">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><b>Login Platform</b>
                                        <div class="input-group">
                                            <select name="mobile_only" class="form-control show-tick" data-live-search="true"
                                                required>                                       
                                                    <option value="no">Web & Mobile Both</option>
                                                    <option value="yes">Only Mobile App</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-primary btn-simple waves-effect"
                            data-dismiss="modal"><a>CLOSE</a></button>
                        <button type="submit" class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE
                                CHANGES</a></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
@section('scripts')
    <script type="text/javascript">
 
    function assignPerm(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Update This User Permissions ?",
                icon: 'warning',
                showCancelButton: true,
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonColor: '#eda61a',
                cancelButtonColor: '#000000',
                confirmButtonText: 'Update',
                cancelButtonText: 'Cancel',
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/assign_permission/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

          function editdata(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This User ?",
                icon: 'warning',
                showCancelButton: true,
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonColor: '#eda61a',
                cancelButtonColor: '#000000',
                confirmButtonText: 'Edit',
                cancelButtonText: 'Cancel',
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/edit_users/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }
        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#000000',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/delete_users/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function updateuserstatus(id, status) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To " + status + " This User?",
                icon: 'warning',
                showCancelButton: true,
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#000000',
                confirmButtonText: status,
                cancelButtonText: 'Cancel',
                focusConfirm: true,
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/update_user_status/?id=') }}" + id + "&status=" + status;
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection

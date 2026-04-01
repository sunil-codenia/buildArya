@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Material'])
    @php
        $edit = false;
        $dataarray = json_decode($data, true);
        if (isset(json_decode($data, true)['edit_data'])) {
            $editdata = $dataarray['edit_data'][0];
            $edit = true;
            $dataarray = $dataarray['data'];
        }
    @endphp
    <div class="row clearfix">
        @if ($edit)
            @if (checkmodulepermission(3, 'can_edit') == 1)
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card project_list">

                        <form action="{{ url('/updatematerial') }}" method="post" class="form">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title">Edit Materials</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                            <label for="Name">Name</label>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <div class="form-group">
                                                <input type="hidden" name="id" value="{{ $editdata['id'] }}">
                                                <input type="text" id="Name" required class="form-control"
                                                    value="{{ $editdata['name'] }}" name="name"
                                                    placeholder="Enter the Expense Head Name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit"
                                        class="btn btn-primary btn-simple btn-round waves-effect"><a>Update</a></button>
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
                    <h2><strong>Materials</strong> List</h2>
                    <ul class="header-dropdown">
                        <li>

                            @if (checkmodulepermission(3, 'can_add') == 1)
                                <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                    data-toggle="modal" data-target="#newexpensehead1" type="button">
                                    <i class="zmdi zmdi-plus" style="color: white;"></i>
                                </button>
                            @endif
                        </li>
                    </ul>
                </div>


                @if (checkmodulepermission(3, 'can_view') == 1)
                    <div class="body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($dataarray as $dd)
                                        @php
                                            $ddid = $dd['id'];
                                        @endphp

                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <a class="single-user-name" href="#">{{ $dd['name'] }}</a>
                                            </td>
                                            <td>
                                                <a title="Manage Conversion" href="{{url('/manage_unit_conversion?id='.$ddid)}}" class="btn   btn-simple btn-round waves-effect">Manage Conversions</a>
                                                &nbsp;
                                                &nbsp;
                                                @if (checkmodulepermission(3, 'can_edit') == 1)
                                                    <button title="Edit" onclick="editdata('{{ $ddid }}')"
                                                        style="all:unset"><i class="zmdi zmdi-edit"></i> </button>
                                                @endif
                                                &nbsp;


                                                @if (checkmodulepermission(3, 'can_delete') == 1)
                                                    @if (isMaterialDeletable($ddid))
                                                        <button title="Delete" onclick="deletedata('{{ $ddid }}')"
                                                            style="all:unset"><i class="zmdi zmdi-delete"></i> </button>
                                                    @endif
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger mx-5">You Don't Have Permission to View !! </div>
                @endif

            </div>
        </div>

    </div>

@endsection

@section('models')
    @if (checkmodulepermission(3, 'can_add') == 1)
        <div class="modal fade" id="newexpensehead1" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <form action="{{ url('/addmaterial') }}" method="post" class="form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title">Add New Material</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">Name</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="Name" required class="form-control" name="name"
                                            placeholder="Enter the Expense Head Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-simple waves-effect"
                                data-dismiss="modal"><a>CLOSE</a></button>
                            <button type="submit" class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE
                                </a></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script type="text/javascript">
        function deletedata(id) {
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
                    var url = "{{ url('/delete_material/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function editdata(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Material ?",
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
                    var url = "{{ url('/edit_material/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection

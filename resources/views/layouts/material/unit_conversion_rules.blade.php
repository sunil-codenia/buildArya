@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Material Unit Conversion Rules'])
 
    <div class="row clearfix">
      

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Materials Units Conversion Rules</strong> List - [ {{$material->name}} ]</h2>
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
                                        <th>From Unit</th>
                                        <th>To Unit</th>
                                        <th>Conversion Factor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($unit_conversions as $dd)
                                        @php
                                            $ddid = $dd->id;
                                        @endphp

                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <a class="single-user-name" href="#">{{ $dd->from_unit }}</a>
                                            </td>
                                            <td>
                                                <a class="single-user-name" href="#">{{ $dd->to_unit }}</a>
                                            </td>
                                            <td>
                                                <a class="single-user-name" href="#">{{ $dd->conversion_factor }}</a>
                                            </td>
                                            <td>
                                              
                                                &nbsp;
                                               


                                                @if (checkmodulepermission(3, 'can_delete') == 1)
                                                   
                                                        <button title="Delete" onclick="deletedata('{{ $ddid }}')"
                                                            style="all:unset"><i class="zmdi zmdi-delete"></i> </button>
                                                  
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
                <form action="{{ url('/add_unit_conversion') }}" method="post" class="form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title">Add New Material Unit Conversion</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">Name</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <input type="hidden" id="id" readonly class="form-control" name="material_id"
                                        value = "{{$material->id}}">
                                        <input type="text" readonly class="form-control" name="material_name"
                                          value = "{{$material->name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">From Unit</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select name="from_unit"   class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected disabled >--Select Unit--</option>
                                        @foreach($units as $unit)
                                        <option value = "{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">To Unit</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <select name="to_unit"   class="form-control show-tick" data-live-search="true" required>
                                            <option value="" selected disabled >--Select Unit--</option>
                                        @foreach($units as $unit)
                                        <option value = "{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">Conversion Factor</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">

                                        <input type="text" required class="form-control" name="conversion_factor"
                                        placeholder="0.0">
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
                    var url = "{{ url('/delete_unit_conversion/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

          </script>
@endsection

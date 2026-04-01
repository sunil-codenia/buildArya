@extends('app')
@section('content')
@include('templates.blockheader', ['pagename' => 'Material Supplier'])
@php
$edit=false;
$dataarray = json_decode($data, true);
                            if(isset(json_decode($data, true)['edit_data'])){
                            $editdata = $dataarray['edit_data'][0];
                            $edit=true;
                            $dataarray = $dataarray['data'];
                            }
@endphp
<div class="row clearfix">

@if($edit)
@if(checkmodulepermission(3,'can_edit') == 1)
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">

        <form action="{{url('/updatematerialsupplier')}}" method="post" class="form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title">Edit Material Supplier</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Name</label>
                                <input type="hidden" name="id" value="{{$editdata['id']}}">
                                <input type="text" id="Name" required class="form-control" value="{{$editdata['name']}}" name="name" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Address</label>

                                <input type="text" id="adress" required class="form-control" value="{{$editdata['address']}}" name="address" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Gstin</label>
                                <input type="text" id="gstin" required class="form-control" value="{{$editdata['gstin']}}" name="gstin"  >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank A/C</label>
                                <input type="text" id="bank_ac" required class="form-control" value="{{$editdata['bank_ac']}}" name="bank_ac"  >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank Ifsc</label>
                                <input type="text" id="bank_ifsc" required class="form-control" value="{{$editdata['bank_ifsc']}}" name="bank_ifsc"  >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank Name</label>
                                <input type="text" id="bank_name" required class="form-control" value="{{$editdata['bank_name']}}" name="bank_name"  >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank A/C Holder</label>
                                <input type="text" id="bank_ac_holder" required class="form-control" value="{{$editdata['bank_ac_holder']}}" name="bank_ac_holder"  >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-simple btn-round waves-effect"><a>Update</a></button>
                </div>
            </div>
        </form>
        </div>

    </div>
    <br>
    @endif
    @endif

  
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="header">
                <h2><strong>Material Supplier</strong> List</h2>
                <ul class="header-dropdown">
                    <li>
                  
                    @if(checkmodulepermission(3,'can_add') == 1)
                        <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10" data-toggle="modal" data-target="#newexpensehead1" type="button">
                            <i class="zmdi zmdi-plus" style="color: white;"></i>
                        </button>
                        @endif
                    </li>
                </ul>
            </div> 
             @if(checkmodulepermission(3,'can_view') == 1)

            <div class="body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Gstin</th>
                                <th>Bank A/C</th>
                                <th>Bank Ifsc</th>
                                <th>Bank Name</th>
                                <th>Bank A/C Holder</th>
                                <th>Status</th>
                                <th>Action</th>
                                
                            </tr>
                        </thead>
                        <tbody> 
                            @php
                            $i=1;
                            @endphp
                            @foreach($dataarray as $dd)
                            @php
                            $ddid = $dd['id'];
                            @endphp

                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <a class="single-user-name" href="#">{{$dd['name']}}</a>
                                </td>
                                <td>
                                    <a class="single-user-name" href="#">{{$dd['address']}}</a>
                                </td>
                                <td>
                                    <a class="single-user-name" href="#">{{$dd['gstin']}}</a>
                                </td>
                                <td>
                                    <a class="single-user-name" href="#">{{$dd['bank_ac']}}</a>
                                </td>
                                <td>
                                    <a class="single-user-name" href="#">{{$dd['bank_ifsc']}}</a>
                                </td><td>
                                    <a class="single-user-name" href="#">{{$dd['bank_name']}}</a>
                                </td><td>
                                    <a class="single-user-name" href="#">{{$dd['bank_ac_holder']}}</a>
                                </td>
                                @if($dd['status'] == 'Active')
                                @if(checkmodulepermission(3,'can_certify') == 1)
                                <td><span onclick="updateuserstatus('{{$ddid}}','Deactive')" class="badge badge-success">{{$dd['status']}}</span></td>
                                @endif
                                @else
                                @if(checkmodulepermission(3,'can_certify') == 1)
                                <td><span onclick="updateuserstatus('{{$ddid}}','Active')" class="badge badge-danger">{{$dd['status']}}</span></td>
                                @endif
                                @endif

                                <td>
                                @if(checkmodulepermission(3,'can_edit') == 1)
                                    <button title="Edit" onclick="editdata('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-edit"></i> </button>
                                &nbsp;
                                @endif
                                @if(checkmodulepermission(3,'can_delete') == 1)
                                @if(isMaterialSupplierDeletable($ddid))
                                    <button title="Delete" onclick="deletedata('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-delete"></i> </button>
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
            <div class="alert alert-danger m-5"> You Don't Have Permission To View..!!! </div>
            @endif
        </div>
    </div>
   
</div>
@endsection


@section('models')

@if(checkmodulepermission(3,'can_add') == 1)
<div class="modal fade" id="newexpensehead1" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <form action="{{url('/addmaterialsupplier')}}" method="post" class="form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title">Add New Material Supplier</h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Name</label>

                                <input type="text" id="Name" required class="form-control" name="name" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Address</label>

                                <input type="text" id="address" required class="form-control" name="address" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Gstin</label>

                                <input type="text" id="gstin" required class="form-control" name="gstin" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank  A/C</label>

                                <input type="text" id="Bank_ac" required class="form-control" name="bank_ac" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank Ifsc</label>

                                <input type="text" id="Bank_ifsc" required class="form-control" name="bank_ifsc" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank Name</label>

                                <input type="text" id="Bank_name" required class="form-control" name="bank_name" >
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="form-group">
                            <label for="Name">Bank Account</label>

                                <input type="text" id="bank_ac_holder" required class="form-control" name="bank_ac_holder" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-simple waves-effect" data-dismiss="modal"><a>CLOSE</a></button>
                    <button type="submit" class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE</a></button>
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
            customClass:{
                container: 'model-width-450px'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{url('/delete_materialsupplier/?id=')}}" + id;
                window.location.href = url;
            }
        });
        }
        function editdata(id) {
         Swal.fire({
            title: 'Are you sure?',
            text: "You Want To Edit This Supplier ?",
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
            customClass:{
                container: 'model-width-450px'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{url('/edit_materialsupplier/?id=')}}" + id;
                window.location.href = url;
            }
        });
        }
        function updateuserstatus(id,status){
        Swal.fire({
            title: 'Are you sure?',
            text: "You Want To "+status+" This Supplier?",
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
            focusConfirm:true,
            customClass:{
                container: 'model-width-450px'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{url('/update_material_supplier_status/?id=')}}" + id + "&status="+status;
                window.location.href = url;
            }
        });
      }
        </script>

@endsection
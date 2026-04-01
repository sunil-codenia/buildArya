@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Stock Reconciliation'])

    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Stock Reconciliation</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                        <div class="info-content">Stock Reconciliation will be listed here.</div>
                    </h2>
                    <div class="row-clearfix"
                        style="display:flex;  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; padding:20px 10px 20px 10px;    align-items: anchor-center;">
                        <div class="col-2">
                            <button type="button" onclick="showpending();" id="pending_btn"
                                class="btn btn-warning btn-fill btn-round waves-effect"><a>Pending <span
                                        style="color:white;border-radius:50%;background:black;padding-inline:4px;">{{ count($pending_list) }}</span></a></button>

                        </div>
                        <div class="col-2">
                            <button type="button" onclick="showuploaded();" id="uploaded_btn"
                                class="btn btn-danger btn-simple btn-round waves-effect"><a>Uploaded <span
                                        style="color:white;border-radius:50%;background:black;padding-inline:4px;">{{ count($submitted_list) }}</span></a></button>

                        </div>
                        <div class="col-2">
                            <button type="button" onclick="showverified();" id="verified_btn"
                                class="btn btn-secondry btn-simple btn-round waves-effect"><a>Verified </a></button>

                        </div>
                        <div class="col-6 align-right">
                            @if (checkmodulepermission(3, 'can_certify') == 1)
                                <button type="button" data-toggle="modal" data-target="#addnewreconsilation"  id="requestReconsilation_btn"
                                    class="btn btn-primary btn-fill btn-round waves-effect"><a>Request
                                        Reconciliation</a></button>
                            @endif
                        </div>
                    </div>


                </div>
                @if (checkmodulepermission(3, 'can_view') == 1)
                    <div class="body">
                        <div id="consumption_view" class="table-responsive">

                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Site</th>
                                        <th>Status</th>
                                        <th>Requested By</th>
                                        <th>Uploaded By</th>
                                        <th>Verify By</th>
                                        <th>Stock Converted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tablebody">
                                    @php

                                        $i = 1;
                                    @endphp
                                    @foreach ($pending_list as $dd)
                                        <tr>
                                            <td>{{ $i++ }}

                                            </td>

                                            <td>
                                                {{ $dd->date }}
                                            </td>
                                            <td>
                                                {{ $dd->site_name }}
                                            </td>
                                            <td>
                                                {{ $dd->status }}
                                            </td>
                                            <td>
                                                {{ $dd->requested_by_name }}
                                            </td>
                                            <td>
                                                {{ $dd->upload_by_name}}
                                            </td>
                                            <td>
                                                {{ $dd->approved_by_name}}
                                            </td>
                                            <td>
                                                {{ $dd->stock_updated }}
                                            </td>


                                            <td class="text-center">

                                                <button title="View" type="button" onclick="viewReconsilation({{$dd->id}})" style="all:unset;"><i class="zmdi zmdi-eye"></i> </button> &nbsp;
                                                @if (checkmodulepermission(3, 'can_delete') == 1)
                                                <button title="Delete" type="button"  onclick="deleteReconsilation({{$dd->id}})" style="all:unset;"><i class="zmdi zmdi-delete"></i> </button> 
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>


                            </table>

                        </div>
                    </div>
                @else
                    <div class="alert alert-danger"> You Don't Have Permission to View !!</div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('models')

        <div class="modal fade" id="addnewreconsilation" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <form action="{{ url('/request_reconsilation') }}" method="post" class="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title">Request New Reconciliation</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-12"><b>Choose Site</b>
                                    <div class="input-group">
                                        <select name="site_id"
                                        class="form-control show-tick" data-live-search="true" required>
                                        <option value="" selected disabled>--Select Site--</option>                                                                       
                                            @foreach ($sites as $site)
                                                <option value="{{ $site->id }}">{{ $site->name }}
                                                </option>
                                            @endforeach
                                        

                                    </select>
                                    </div>
                                </div>
                            </div>
<br>
<span style="color:red;"><b>If You Are Planning To Update Stock According To This Reconciliation. Then Don't Create Any Material Stock Transaction Until Stock Reconciled & Update Successfully. <br>Transaction Like : Material Purchase Entry , Material Consumption / Wastage , Site Transfer , Unit Conversion.</b></span>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-primary btn-simple waves-effect"
                                    data-dismiss="modal"><a>Close</a></button>
                                <button type="submit"
                                    class="btn btn-primary btn-simple btn-round waves-effect"><a>Submit</a></button>
                            </div>
                        </div>


                    </div>

                </form>
            </div>
        </div>
    
@endsection
@section('scripts')
    <script>
        let pendingData = @json($pending_list);
        let uploadedData = @json($submitted_list);
        let verifiedData = @json($verified_list);
        let delete_perm = {{ checkmodulepermission(3, 'can_delete') }};

        function showpending() {
            $('#verified_btn').removeClass('btn-fill')
                .addClass('btn-simple');
            $('#uploaded_btn').removeClass('btn-fill')
                .addClass('btn-simple');
            $('#pending_btn').removeClass('btn-simple')
                .addClass('btn-fill');
            document.getElementById('tablebody').innerHTML = '';
            var newData = [];
            var table = $('#dataTable').DataTable();
            table.clear();
            var count =1; 
            pendingData.forEach((element) => {

                var newDat = [count, element['date'], element['site_name'], element[
                        'status'], element['requested_by_name'], element['upload_by_name'], element['approved_by_name'],
                    element['stock_updated'],
                    '<button title="View" type="button" onclick="viewReconsilation(' + element['id'] +
                    ')" style="all:unset;"><i class="zmdi zmdi-eye"></i> </button> &nbsp;' +
                    ((delete_perm == "1") ?
                        '<button title="Delete" type="button"  onclick="deleteReconsilation(' + element['id'] +
                        ')" style="all:unset;"><i class="zmdi zmdi-delete"></i> </button> &nbsp;' :
                        '')
                ];
                newData.push(newDat);
                count++;
            });
            table.rows.add(newData);
            table.draw();

        }

        function showuploaded() {
            $('#verified_btn').removeClass('btn-fill')
                .addClass('btn-simple');
            $('#pending_btn').removeClass('btn-fill')
                .addClass('btn-simple');
            $('#uploaded_btn').removeClass('btn-simple')
                .addClass('btn-fill');
            document.getElementById('tablebody').innerHTML = '';
            var newData = [];
            var table = $('#dataTable').DataTable();
            table.clear();
            var count =1; 
            uploadedData.forEach((element) => {

                var newDat = [count, element['date'], element['site_name'], element[
                        'status'], element['requested_by_name'], element['upload_by_name'], element['approved_by_name'],
                    element['stock_updated'],
                    '<button title="View" type="button" onclick="viewReconsilation(' + element['id'] +
                    ')" style="all:unset;"><i class="zmdi zmdi-eye"></i> </button> &nbsp;'
                ];
                newData.push(newDat);
                count++;
            });
            table.rows.add(newData);
            table.draw();


        }

        function showverified() {
            $('#pending_btn').removeClass('btn-fill')
                .addClass('btn-simple');
            $('#uploaded_btn').removeClass('btn-fill')
                .addClass('btn-simple');
            $('#verified_btn').removeClass('btn-simple')
                .addClass('btn-fill');
            document.getElementById('tablebody').innerHTML = '';
            var newData = [];
            var table = $('#dataTable').DataTable();
            table.clear();
            var count =1; 
            verifiedData.forEach((element) => {

                var newDat = [count, element['date'], element['site_name'], element[
                        'status'], element['requested_by_name'], element['upload_by_name'], element['approved_by_name'],
                    element['stock_updated'],
                    '<button title="View" type="button" onclick="viewReconsilation(' + element['id'] +
                    ')" style="all:unset;"><i class="zmdi zmdi-eye"></i> </button> &nbsp;'
                ];
                newData.push(newDat);
                count++;
            });
            table.rows.add(newData);
            table.draw();


        }
        function deleteReconsilation(id) {
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
                    var url = "{{ url('/delete_reconsilation/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }
  
        function viewReconsilation(id){
            var url = "{{ url('/view_reconsilation_detail/?id=') }}" + id;
            window.location.href = url;
        }
    </script>
@endsection

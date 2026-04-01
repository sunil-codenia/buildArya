@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Stock Reconciliation'])

    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Stock Reconciliation</strong> View&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                        <div class="info-content">Stock Reconciliation will be viewed here.</div>
                    </h2>
                    <div class="row-clearfix"
                        style="display:flex;  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; padding:20px 10px 20px 10px;    align-items: anchor-center;">
                        <div class="col-2">
                            Date : {{ $reconsile_record->date }}
                            <br>
                            Requested By : {{ $reconsile_record->requested_by_name }}
                        </div>
                        <div class="col-2">
                            Site : {{ $reconsile_record->site_name }}
                            <br>
                            Uploaded By : {{ $reconsile_record->upload_by_name }}
                        </div>
                        <div class="col-2">
                            Status : {{ $reconsile_record->status }}
                            <br>
                            Approved By : {{ $reconsile_record->approved_by_name }}
                        </div>
                        <div class="col-6 align-right">
                            @if ($reconsile_record->status == 'Pending' || $reconsile_record->status == 'Draft')
                                @if (checkmodulepermission(3, 'can_delete') == 1)
                                    <button type="button" onclick="deleteReconsilation({{$reconsile_record->id}})" class="btn btn-danger btn-fill btn-round waves-effect"><a>Delete
                                            Reconciliation</a></button>
                                @endif
                            @endif
                            @if ($reconsile_record->status == 'Submitted')
                                @if (checkmodulepermission(3, 'can_certify') == 1)
                                    <button type="button" onclick="update_stock_reconsilation({{$reconsile_record->id}})"
                                        class="btn btn-success btn-fill btn-round waves-effect"><a>Approve
                                            Reconciliation & Update Stock</a></button>
                                    <button type="button" onclick="approve_reconsilation({{$reconsile_record->id}})" class="btn btn-secondry btn-fill btn-round waves-effect"><a>Verify
                                            Reconciliation</a></button>

                                    <button type="button" onclick="reject_reconsilation({{$reconsile_record->id}})" class="btn btn-danger btn-fill btn-round waves-effect"><a>Reject
                                            Reconciliation</a></button>
                                @endif
                            @endif

                        </div>
                    </div>


                </div>
                @if (checkmodulepermission(3, 'can_view') == 1)
                    <div class="body">
                        <div class="table-responsive">
                            <form method="post" action="{{ url('/upload_reconsilation') }}">
                                @csrf
                                <input type="hidden" name="reconsilation_id" value="{{$reconsile_record->id}}"/>
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Material</th>
                                            <th>Unit</th>
                                            <th>System Qty</th>
                                            <th>Reconciled qty</th>
                                            <th>Difference</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tablebody">
                                        @php

                                            $i = 1;
                                        @endphp
                                        @foreach ($data as $dd)
                                            <tr>
                                                <td>{{ $i++ }}

                                                </td>

                                                <td>
                                                    {{ $dd->material_name }}
                                                </td>
                                                <td>
                                                    {{ $dd->unit_name }}
                                                </td>
                                                <td>
                                                    {{ $dd->system_qty }}
                                                </td>
                                                <td>
                                                    @if (
                                                        $reconsile_record->status == 'Pending' ||
                                                            $reconsile_record->status == 'Draft' ||
                                                            $reconsile_record->status == 'Submitted')
                                                        <input type="hidden" name="material_id[]" class="form-control"
                                                            value="{{ $dd->material_id }}" />
                                                        <input type="hidden" name="unit[]" class="form-control"
                                                            value="{{ $dd->unit }}" />
                                                        <input type="hidden" name="system_qty[]" class="form-control"
                                                            value="{{ $dd->system_qty }}" />
                                                        <input type="number"
                                                            oninput="reconsiled_qty_change({{ $i }},{{ $dd->system_qty }});"
                                                            id="reconsiled_qty_{{ $i }}" step="0.01"
                                                            pattern="^\d+(?:\.\d{1,2})?$" required name="reconsiled_qty[]"
                                                            class="form-control" value="{{ $dd->reconsiled_qty }}" />
                                                    @else
                                                        {{ $dd->reconsiled_qty }}
                                                    @endif
                                                </td>
                                                <td >
                                                    <input type="number"
                                                          
                                                            id="difference_{{ $i }}" step="0.01"
                                                            pattern="^\d+(?:\.\d{1,2})?$" name="difference[]"
                                                            class="form-control" readonly value="{{ $dd->difference }}" />
                                                  
                                                </td>



                                            </tr>
                                        @endforeach

                                    </tbody>


                                </table>
                                <br><br><br><br>
                                <div class="align-right">
                                    @if (
                                        $reconsile_record->status == 'Pending' ||
                                            $reconsile_record->status == 'Draft' ||
                                            $reconsile_record->status == 'Submitted')
                                        <button type="submit"
                                            class="btn btn-success btn-fill btn-round waves-effect"><a>Upload
                                                Reconciliation</a></button>
                                    @endif
                                </div>
                                <br><br>

                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger"> You Don't Have Permission to View !!</div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function reconsiled_qty_change(id, qty) {
            let re_qty = $('#reconsiled_qty_' + id).val();
            var diff = Number(qty - re_qty).toFixed(2);

            $('#difference_' + id).val(diff);

        }
        
        function update_stock_reconsilation(id) {
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
                confirmButtonText: 'Yes, Update Stock',
                cancelButtonText: 'Cancel',
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/update_stock_reconsilation/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function reject_reconsilation(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to reject this data!",
                icon: 'warning',
                showCancelButton: true,
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#000000',
                confirmButtonText: 'Yes, Reject It',
                cancelButtonText: 'Cancel',
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/reject_reconsilation_detail/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function approve_reconsilation(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to Approve this data!",
                icon: 'warning',
                showCancelButton: true,
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonColor: '#00ff00',
                cancelButtonColor: '#000000',
                confirmButtonText: 'Yes, Approve It',
                cancelButtonText: 'Cancel',
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/approve_reconsilation_detail/?id=') }}" + id;
                    window.location.href = url;
                }
            });
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
    </script>
@endsection

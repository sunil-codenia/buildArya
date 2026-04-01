@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Manage Sales Invoice'])
    @php
        $edit = false;
        $dataarray = json_decode($data, true);
        if (isset(json_decode($data, true)['edit_data'])) {
            $editdata = $dataarray['edit_data'][0];
            $edit = true;
        }
        $types = $dataarray['types'];
        $manage = $dataarray['manage'];
        $invoice = $dataarray['invoice'];
        $project_id = $invoice['project_id'];
        $invoice_id = $invoice['id'];
        $invoice_val = $invoice['amount'];

    @endphp
    <div class="row clearfix">

        @if ($edit)
            @if (checkmodulepermission(7, 'can_edit') == 1)
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="card project_list">

                        <form action="{{ url('/updatesales_manage_invoice') }}" method="post" enctype="multipart/form-data"
                            class="form">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="title">Edit Sales Invoice Data</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="Name">Invoice Head</label>
                                                <input type="hidden" name="id" value="{{ $editdata['id'] }}" />
                                                <input type="hidden" name="invoice_id"
                                                    value="{{ $editdata['invoice_id'] }}" />
                                                <select class="form-control show-tick" data-live-search="true"
                                                    name="type_id">
                                                    <option disabled value="" selected>--Select Head--</option>
                                                    @foreach ($types as $type)
                                                        @if ($type['id'] == $editdata['type_id'])
                                                            <option selected value="{{ $type['id'] }}">{{ $type['name'] }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="Name">Amount</label>

                                                <input type="number" id="amount" value="{{ $editdata['amount'] }}"
                                                    required class="form-control" name="amount">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <div class="form-group">
                                                <label for="Name">Date</label>

                                                <input type="date" id="date" value="{{ $editdata['date'] }}"
                                                    required class="form-control" name="date">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="Name">Image</label>

                                                <input type="file" id="image"
                                                    accept="image/jpeg,image/gif,image/png,image/x-eps" class="form-control"
                                                    name="image">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="Name">PDF</label>

                                                <input type="file" id="pdf" accept="application/pdf"
                                                    class="form-control" name="pdf">
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
                    <h2><strong>Manage Sales Invoices</strong> List </h2>
                    <br>
                    <div class="row">
                        <div class="col-4" style="border:1px solid black; text-align: center;" >
                            <strong>Invoice : </strong>{{ $invoice['invoice_no'] }}
                        </div>
                        <div class="col-4" style="border:1px solid black; text-align: center;">
                            <strong>Project : </strong>{{ $invoice['project'] }}
                        </div>
                        <div class="col-4" style="border:1px solid black; text-align: center;">
                            <strong>Company : </strong>{{ $invoice['company'] }}
                        </div>
                        <div class="col-4" style="border:1px solid black; text-align: center;">
                            <strong>Taxable Value : </strong>{{ $invoice['taxable_value'] }}
                        </div>
                        <div class="col-4" style="border:1px solid black; text-align: center;">
                            <strong>GST Rate : </strong>{{ $invoice['gst_rate'] }}
                        </div>
                        <div class="col-4" style="border:1px solid black; text-align: center;">
                            <strong>Gross Value : </strong>{{ $invoice['amount'] }}
                        </div>
                        <div class="col-3" style="border:1px solid black; text-align: center;">
                            <strong>Date : </strong>{{ $invoice['date'] }}
                        </div>

                        <div class="col-3" style="border:1px solid black; text-align: center;">
                            <strong>Financial Year : </strong>{{ $invoice['financial_year'] }}
                        </div>
                        <div class="col-3" style="border:1px solid black; text-align: center;">
                            <strong>Party : </strong>{{ $invoice['party'] }}
                        </div>
                        <div class="col-3" style="border:1px solid black; text-align: center;">
                            <strong>Status : </strong>{{ $invoice['status'] }}
                        </div>
                      
                    </div>

                    <ul class="header-dropdown">
                        <li>

                            @if ($invoice['status'] == 'Active')
                                @if (checkmodulepermission(7, 'can_add') == 1)
                                    <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                        data-toggle="modal" data-target="#newexpensehead1" type="button">
                                        <i class="zmdi zmdi-plus" style="color: white;"></i>
                                    </button>
                                @endif
                            @else
                                <div class="alert alert-danger">Invoice Is Inactive. New Entries Can't Be Created!</div>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="body">

                    <div class="row clearfix">
                        @if (checkmodulepermission(7, 'can_view') == 1)
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h3 class="title">Debit</h3>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Head</th>
                                                <th>Date</th>
                                                <th>Amount</th>

                                                <th>Attachment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                                $deb = 0;
                                            @endphp
                                            @foreach ($manage as $dd)
                                                @php
                                                    $ddid = $dd['id'];

                                                @endphp
                                                @if ($dd['type'] == 'add')
                                                    @php   $deb += $dd['amount']; @endphp
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>
                                                            <a class="single-user-name"
                                                                href="#">{{ $dd['type_name'] }}</a>
                                                        </td>
                                                        <td>
                                                            <a class="single-user-name"
                                                                href="#">{{ $dd['date'] }}</a>
                                                        </td>
                                                        <td>
                                                            <a class="single-user-name"
                                                                href="#">{{ getStructuredAmount($dd['amount'], true, false) }}</a>
                                                        </td>

                                                        <td>
                                                            @if ($dd['pdf'] != null)
                                                                <a href="{{ url('/') . '/' . $dd['pdf'] }}"
                                                                    target="_blank"><i class="zmdi zmdi-collection-pdf"></i>
                                                                </a>
                                                            @endif
                                                            &nbsp;
                                                            @if ($dd['image'] != null)
                                                                <a href="{{ url('/') . '/' . $dd['image'] }}"
                                                                    target="_blank"><i class="zmdi zmdi-image-o"></i> </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (checkmodulepermission(7, 'can_edit') == 1)
                                                                <button title="Edit"
                                                                    onclick="editentry('{{ $ddid }}','{{ $invoice_id }}')"
                                                                    style="all:unset"><i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                            @endif
                                                            &nbsp;
                                                            @if (checkmodulepermission(7, 'can_delete') == 1)
                                                                <button title="Delete"
                                                                    onclick="deletedata('{{ $ddid }}','{{ $invoice_id }}')"
                                                                    style="all:unset"><i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><b>Total Debit</b></td>
                                                <td></td>
                                                <td><b>{{ getStructuredAmount($deb, true, false) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                        @if (checkmodulepermission(7, 'can_view') == 1)
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                <h3 class="title">Credit</h3>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Head</th>
                                                <th>Date</th>
                                                <th>Amount</th>

                                                <th>Attachment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                                $cre = 0;
                                            @endphp
                                            @foreach ($manage as $dd)
                                                @php
                                                    $ddid = $dd['id'];

                                                @endphp
                                                @if ($dd['type'] == 'ded')
                                                    @php   $cre += $dd['amount']; @endphp
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>
                                                            <a class="single-user-name"
                                                                href="#">{{ $dd['type_name'] }}</a>
                                                        </td>
                                                        <td>
                                                            <a class="single-user-name"
                                                                href="#">{{ $dd['date'] }}</a>
                                                        </td>
                                                        <td>
                                                            <a class="single-user-name"
                                                                href="#">{{ getStructuredAmount($dd['amount'], true, false) }}</a>
                                                        </td>

                                                        <td>
                                                            @if ($dd['pdf'] != null)
                                                                <a href="{{ url('/') . '/' . $dd['pdf'] }}"
                                                                    target="_blank"><i
                                                                        class="zmdi zmdi-collection-pdf"></i> </a>
                                                            @endif
                                                            &nbsp;
                                                            @if ($dd['image'] != null)
                                                                <a href="{{ url('/') . '/' . $dd['image'] }}"
                                                                    target="_blank"><i class="zmdi zmdi-image-o"></i> </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (checkmodulepermission(7, 'can_edit') == 1)
                                                                <button title="Edit"
                                                                    onclick="editentry('{{ $ddid }}','{{ $invoice_id }}')"
                                                                    style="all:unset"><i class="zmdi zmdi-edit"></i>
                                                                </button>
                                                            @endif
                                                            &nbsp;
                                                            @if (checkmodulepermission(7, 'can_delete') == 1)
                                                                <button title="Delete"
                                                                    onclick="deletedata('{{ $ddid }}','{{ $invoice_id }}')"
                                                                    style="all:unset"><i class="zmdi zmdi-delete"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                @if (checkmodulepermission(7, 'can_view') == 1)
                                                    <td><b>Total Credit<b></td>
                                                    <td></td>
                                                    <td><b>{{ getStructuredAmount($cre, true, false) }}</b></td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <br>
                    @if (checkmodulepermission(7, 'can_view') == 1)
                        <h3 class="title text-right">Balance :
                            {{ getStructuredAmount($invoice_val + $deb - $cre, true, false) }}</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('models')
    @if (checkmodulepermission(7, 'can_add') == 1)
        <div class="modal fade" id="newexpensehead1" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <form action="{{ url('/addsales_manage_invoice') }}" enctype="multipart/form-data" method="post"
                    class="form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title">Add New Invoice</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="Name">Invoice Head</label>
                                        <input type="hidden" name="invoice_id" value="{{ $invoice['id'] }}" />
                                        <select class="form-control show-tick" data-live-search="true" name="type_id">
                                            <option disabled value="" selected>--Select Head--</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="Name">Amount</label>

                                        <input type="number" id="amount" required class="form-control"
                                            name="amount">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label for="Name">Date</label>

                                        <input type="date" id="date" required class="form-control"
                                            name="date">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="Name">Image</label>

                                        <input type="file" id="image"
                                            accept="image/jpeg,image/gif,image/png,image/x-eps" class="form-control"
                                            name="image">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label for="Name">PDF</label>

                                        <input type="file" id="pdf" accept="application/pdf"
                                            class="form-control" name="pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-simple waves-effect"
                                data-dismiss="modal"><a>CLOSE</a></button>
                            <button type="submit"
                                class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE</a></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script type="text/javascript">
        var imageupload = document.getElementById("image");

        imageupload.onchange = function() {
            if (this.files[0].size > 5242880) {
                alert("Image is too big. Max Size Allowed is 5 MB!");
                this.value = "";
            };
        };
        var pdfupload = document.getElementById("pdf");

        pdfupload.onchange = function() {
            if (this.files[0].size > 10485760) {
                alert("PDF is too big. Max Size Allowed is 10 MB!");
                this.value = "";
            };
        };
        document.getElementById("gst_rate").onchange = function() {

            var taxable_value = parseFloat(document.getElementById("taxable_value").value);
            var gst_rate = parseFloat(document.getElementById("gst_rate").value);
            var amount = taxable_value + (taxable_value * gst_rate) / 100;
            document.getElementById("amount").value = amount;
        }

        function deletedata(id, invoice_id) {
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
                    var url = "{{ url('/delete_sales_manage_invoice/?id=') }}" + id + "&invoice_id=" + invoice_id;
                    window.location.href = url;
                }
            });
        }



        function editentry(id, invoice_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Entry Details ?",
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
                    var url = "{{ url('/edit_sales_manage_invoice/?invoice_id=') }}" + invoice_id + "&id=" + id;
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection

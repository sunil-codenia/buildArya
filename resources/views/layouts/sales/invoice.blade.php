@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Sales Invoice'])
    @php
        $edit = false;
        $dataarray = json_decode($data, true);
        if (isset(json_decode($data, true)['edit_data'])) {
            $editdata = $dataarray['edit_data'][0];
            $edit = true;
        }
        $invoices = $dataarray['invoices'];
        $companies = $dataarray['companies'];
        $parties = $dataarray['parties'];
        $project = $dataarray['project'];
        
    @endphp
    <div class="row clearfix">

        @if ($edit)
        @if(checkmodulepermission(7,'can_edit') == 1)
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">

                    <form action="{{ url('/updatesalesinvoice') }}" method="post" enctype="multipart/form-data" class="form">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title">Edit Sales Invoice</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="Name">Company</label>
                                            <input type="hidden" name="id" value="{{$editdata['id']}}"/>
                                            <input type="hidden" name="project_id" value="{{$project['id']}}"/>
                                            <select  class="form-control show-tick" data-live-search="true" name="company_id">
                                                <option disabled value="" selected>--Select Company--</option>
                                                @foreach ($companies as $company)
                                                @if($company['id'] == $editdata['company_id'])
                                                    <option selected value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                                    @else
                                                    <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label for="Name">Party</label>
                                            <select  class="form-control show-tick" data-live-search="true" name="party_id">
                                                <option disabled value="" selected>--Select Party--</option>
                                                @foreach ($parties as $party)
                                                @if($party['id'] == $editdata['party_id'])
                                                    <option selected value="{{ $party['id'] }}">{{ $party['name'] }}</option>
                                                    @else
                                                    <option value="{{ $party['id'] }}">{{ $party['name'] }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="Name">Financial Year</label>
                                            @php $years = getFinancialYear();@endphp
                                            <select  class="form-control show-tick" data-live-search="true" name="financial_year">
                                                <option disabled value="" selected>--Select Year--</option>
                                                @foreach ($years as $year)
                                                @if($year == $editdata['financial_year'])
                                                    <option selected value="{{ $year }}">{{ $year }}</option>
                                                    @else
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="Name">Invoice No.</label>
        
                                            <input type="text" id="invoice_no" value="{{$editdata['invoice_no']}}" required class="form-control"
                                                name="invoice_no">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="Name">Invoice Date</label>
        
                                            <input type="date" id="date" value="{{$editdata['date']}}" required class="form-control" name="date">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="Name">Taxable Value</label>
        
                                            <input type="number" id="taxable_value" value="{{$editdata['taxable_value']}}" required class="form-control"
                                                name="taxable_value">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="Name">GST Rate (%)</label>
        
                                            <input type="number" id="gst_rate" required class="form-control" value="{{$editdata['gst_rate']}}" name="gst_rate">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label for="Name">Amount</label>
        
                                            <input type="number" id="amount" required class="form-control" value="{{$editdata['amount']}}" name="amount">
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
        
                                            <input type="file" id="pdf" accept="application/pdf" class="form-control"
                                                name="pdf">
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
            @else
            <div class="alert alert-danger">You Don't Have Permission to Edit </div>
            @endif
            <br>
        @endif
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Sales Invoices</strong> List - <strong>(Project : {{ $project['name'] }})</strong></h2>
                    <ul class="header-dropdown">
                        <li>

                            @if ($project['status'] == 'Active')
                          
                            @if(checkmodulepermission(7,'can_add') == 1)
                                <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                    data-toggle="modal" data-target="#newexpensehead1" type="button">
                                    <i class="zmdi zmdi-plus" style="color: white;"></i>
                                </button>
                                @endif
                             
                            @else
                                <div class="alert alert-danger">Project Is Inactive. New Invoice Can't Be Created!</div>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="body">
                @if(checkmodulepermission(7,'can_view') == 1)
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Date</th>
                                    <th>Company</th>
                                    <th>Party</th>
                                    <th>Financial Year</th>
                                    <th>Balance</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($invoices as $dd)
                                    @php
                                        $ddid = $dd['id'];
                                        $project_id = $project['id'];
                                    @endphp

                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <a class="single-user-name" href="#">{{ $dd['invoice_no'] }}</a>
                                        </td>
                                        <td>
                                            <a class="single-user-name" href="#">{{ $dd['date'] }}</a>
                                        </td>
                                        <td>
                                            <a class="single-user-name" href="#">{{ $dd['company'] }}</a>
                                        </td>
                                        <td>
                                            <a class="single-user-name" href="#">{{ $dd['party'] }}</a>
                                        </td>
                                        <td>
                                            <a class="single-user-name" href="#">{{ $dd['financial_year'] }}</a>
                                        </td>
                                        <td><a class="single-user-name" href="#">{{ getSalesInvoiceBalance($ddid) }}</a></td>
                                        <td>
                                            <a class="single-user-name" href="#">Taxable Value -
                                                {{ $dd['taxable_value'] }}<br>
                                                GST Rate - {{ $dd['gst_rate'] }}<br>
                                                Gross Value - {{ $dd['amount'] }}</a>
                                        </td>
                                        @if ($dd['status'] == 'Active')
                                        @if(checkmodulepermission(7,'can_certify') == 1)
                                            <td><span
                                                    onclick="updateinvoicestatus('{{ $ddid }}','Deactive','{{ $project_id }}')"
                                                    class="badge badge-success">{{ $dd['status'] }}</span></td>
                                                    @endif
                                        @else
                                        @if(checkmodulepermission(7,'can_certify') == 1)
                                            <td><span
                                                    onclick="updateinvoicestatus('{{ $ddid }}','Active','{{ $project_id }}')"
                                                    class="badge badge-danger">{{ $dd['status'] }}</span></td>
                                                    @endif
                                        @endif
                                        <td>
                                            @if ($dd['pdf'] != null)
                                                <a href="{{ url('/') . '/' . $dd['pdf'] }}" target="_blank"><i
                                                        class="zmdi zmdi-collection-pdf"></i> </a>
                                            @endif
                                            &nbsp;
                                            @if ($dd['image'] != null)
                                                <a href="{{ url('/') . '/' . $dd['image'] }}" target="_blank"><i
                                                        class="zmdi zmdi-image-o"></i> </a>
                                            @endif
                                        </td>
                                        <td>
                                        @if(checkmodulepermission(7,'can_view') == 1)
                                              <a title="View" href="{{ url('/sales_manage_invoice?invoice_id=')  . $ddid }}"><i
                                            class="zmdi zmdi-eye"></i> </a>
                                            @endif
                                            &nbsp;
                                            @if(checkmodulepermission(7,'can_edit') == 1)
                                            <button title="Edit" onclick="editinvoice('{{ $ddid }}','{{ $project_id }}')"
                                                style="all:unset"><i class="zmdi zmdi-edit"></i> </button>
                                            @endif
                                            &nbsp;
                                            @if(checkmodulepermission(7,'can_delete') == 1)
                                            @if(isSalesInvoiceDeletable($ddid))
                                            <button title="Delete" onclick="deletedata('{{ $ddid }}','{{ $project_id }}')"
                                                style="all:unset"><i class="zmdi zmdi-delete"></i> </button>
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
@if(checkmodulepermission(7,'can_add') == 1)
    <div class="modal fade" id="newexpensehead1" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <form action="{{ url('/addsalesinvoice') }}" enctype="multipart/form-data" method="post" class="form">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title">Add New Invoice</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="Name">Company</label>
                                    <select  class="form-control show-tick" data-live-search="true" name="company_id">
                                        <option disabled value="" selected>--Select Company--</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" required value="{{ $project['id'] }}" name="project_id">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="Name">Party</label>
                                    <select  class="form-control show-tick" data-live-search="true" name="party_id">
                                        <option disabled value="" selected>--Select Party--</option>
                                        @foreach ($parties as $party)
                                            <option value="{{ $party['id'] }}">{{ $party['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="Name">Financial Year</label>
                                    @php $years = getFinancialYear();@endphp
                                    <select  class="form-control show-tick" data-live-search="true" name="financial_year">
                                        <option disabled value="" selected>--Select Year--</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="Name">Invoice No.</label>

                                    <input type="text" id="invoice_no" required class="form-control"
                                        name="invoice_no">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="Name">Invoice Date</label>

                                    <input type="date" id="date" required class="form-control" name="date">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="Name">Taxable Value</label>

                                    <input type="number" id="taxable_value" required class="form-control"
                                        name="taxable_value">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="Name">GST Rate (%)</label>

                                    <input type="number" id="gst_rate" required class="form-control" name="gst_rate">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label for="Name">Amount</label>

                                    <input type="number" id="amount" required class="form-control" name="amount">
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

                                    <input type="file" id="pdf" accept="application/pdf" class="form-control"
                                        name="pdf">
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

        function deletedata(id, project_id) {
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
                    var url = "{{ url('/delete_sales_invoice/?id=') }}" + id + "&project_id=" + project_id;
                    window.location.href = url;
                }
            });
        }

        function updateinvoicestatus(id, status, project_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To " + status + " This Invoice?",
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
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/update_sales_invoice_status/?id=') }}" + id + "&status=" + status +
                        "&project_id=" + project_id;
                    window.location.href = url;
                }
            });
        }

        function editinvoice(id, project_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Invoice Details ?",
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
                    var url = "{{ url('/edit_sales_invoice/?project_id=') }}" + project_id + "&id=" + id;
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection

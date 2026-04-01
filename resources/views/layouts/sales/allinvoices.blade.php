@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'All Sales Invoice'])
   
    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Sales Invoices</strong> List - <strong>(All Project
                        )</strong></h2>
                  
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
                                    <th>Project</th>
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
                                    $data = json_decode($data, true);
                                @endphp
                                @foreach ($data as $dd)
                                    @php
                                        $ddid = $dd['id'];
                                      $project_id = $dd['project_id'];
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
                                            <a class="single-user-name" href="#">{{ $dd['project'] }}</a>
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
                                            @if(checkmodulepermission(7,'can_view') == 1)
                                            <a href="{{url('/sales_pdf/?id='.$ddid)}}" style="all:unset" ><i class="zmdi zmdi-collection-pdf"></i> </a>
                                            @endif
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
                    <div class="alert alert-danger">You Don't Have Permission to View</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
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

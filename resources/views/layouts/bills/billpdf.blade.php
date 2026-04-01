<!doctype html>

<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">

    <title>:: Kash Compass ::</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- Favicon-->
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

</head>

<body class="">
@if(checkmodulepermission(4,'can_view') == 1)
    @php
        $data = json_decode($data, true);
        $bill = $data['bill'];
        $bill_items = $data['bill_items'];
        $balance = $data['balance'];
        $bill_party = $data['bill_party'];
    @endphp

    
    <div class="card">
        <div class="header">
            <h2><strong>Bill</strong> Details</h2>
            <h3>Invoice No : <strong class="text-primary">{{ $bill['bill_no'] }}</strong></h3>
        </div>
    </div>
    <div>
        <div id="details" aria-expanded="true">
            <div class="card" id="details">
                <div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <address>
                                <strong>{{ $bill_party['name'] }}</strong><br>
                                <b title="Phone">Pan No : </b> {{ $bill_party['panno'] }}6
                            </address>
                        </div>
                        <div class="col-md-6 col-sm-6 " style="text-align: right;">
                            <p style="margin:0;"><strong>Bill Date: </strong> {{ $bill['billdate'] }}</p>
                            <p style="margin:0;"><strong>Bill Status: </strong> <span class="badge "
                                    style="background-color:{{ getStatusColor($bill['status']) }};">{{ $bill['status'] }}</span>
                            </p>
                            <p><strong>Bill Period: </strong> {{ $bill['bill_period'] }}</p>
                        </div>
                    </div>
                    <div class="mt-40"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="hidden-sm-down">Item</th>


                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th class="hidden-sm-down">Unit Cost</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach ($bill_items as $bill_item)
                                            @php
                                                $amount = $bill_item['rate'] * $bill_item['qty'];
                                            @endphp
                                            <tr>
                                                <td>{{ $count++ }}</td>
                                                <td>{{ $bill_item['name'] }}</td>
                                                <td>{{ $bill_item['qty'] }}</td>
                                                <td>{{ $bill_item['unit'] }}</td>
                                                <td class="hidden-sm-down">
                                                    {{ getStructuredAmount($bill_item['rate'], true, false) }}
                                                </td>
                                                <td>{{ getStructuredAmount($amount, true, false) }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4" style="text-align:start;">
                            <h5><b>Notes & Remarks</b></h5>
                            <p>{{ $bill['remark'] }}</p>
                        </div>
                        <div class="col-md-4" style="text-align: start;">
                            <h5><b>Bank Details</b></h5>
                            <p>Bank Name : {{ $bill_party['bankname'] }}<br>
                                A/C No : {{ $bill_party['bank_ac'] }}<br>
                                A/C Holder : {{ $bill_party['ac_holder_name'] }}<br>
                                Bank IFSC : {{ $bill_party['ifsc'] }}</p>

                        </div>
                        <div class="col-md-4" style="text-align:start;">

                            <h5 class="m-b-0"><b>Grand Total =>¸
                                    {{ getStructuredAmount($bill['amount'], true, false) }}</b></h5>
                            <br>
                            <h5 class="m-b-0">Created By => {{ $bill['user'] }}</h5>
                            <h5 class="m-b-0">Created At => {{ $bill['site'] }}</h5>
                            <h5 class="m-b-0">Party Balance => {{ getStructuredAmount($balance, true, false) }}
                            </h5>
                            <br>
                        </div>
                    </div>
                    <hr>
                    
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h3 style="text-align: center;"><strong class="text-primary">Company Name</strong></h3>
                
                    </div>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane in active" id="details" aria-expanded="true">
                        <div class="card" id="details">
                            <div class="body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <address>
                                            <h3 class="m-b-0">Invoice No : <strong class="text-primary">{{ $bill->bill_no }}</strong></h3>
                  <br>
                                            <strong>Party : {{ $bill_party->name }}</strong><br>
                                            <b title="Phone">Pan No : </b> {{ $bill_party->panno }}6
                                        </address>
                                    </div>
                                    <div class="col-md-6 col-sm-6 text-right"><br>
                                        <p class="m-b-0"><strong>Bill Date: </strong> {{ $bill->billdate }}</p>
                                        <p class="m-b-0"><strong>Bill Status: </strong> <span
                                                class="badge bg-{{ getStatusColor($bill->status) }}">{{ $bill->status }}</span>
                                        </p>
                                        <p><strong>Bill Period: </strong> {{ $bill->bill_period }}</p>
                                    </div>
                                </div>
                                <div class="mt-40"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="dataTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="hidden-sm-down">Item</th>
                                                        <th>Quantity</th>
                                                        <th>Unit</th>
                                                        <th class="hidden-sm-down">Unit Cost</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($bill_items as $bill_item)
                                                        @php
                                                            $amount = $bill_item->rate * $bill_item->qty;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $count++ }}</td>
                                                            <td>{{ $bill_item->name }}</td>
                                                            <td>{{ $bill_item->qty }}</td>
                                                            <td>{{ $bill_item->unit }}</td>
                                                            <td class="hidden-sm-down">
                                                                {{ getStructuredAmount($bill_item->rate, true, false) }}
                                                            </td>
                                                            <td>{{ getStructuredAmount($amount, true, false) }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4" style="text-align:start;">
                                        <h5><b>Notes & Remarks</b></h5>
                                        <p>{{ $bill->remark }}</p>
                                    </div>
                                    <div class="col-md-4" style="text-align: start;">
                                        <h5><b>Bank Details</b></h5>
                                        <p>Bank Name : {{ $bill_party->bankname }}<br>
                                            A/C No : {{ $bill_party->bank_ac }}<br>
                                            A/C Holder : {{ $bill_party->ac_holder_name }}<br>
                                            Bank IFSC : {{ $bill_party->ifsc }}</p>

                                    </div>
                                    <div class="col-md-4" style="text-align:start;">

                                        <h5 class="m-b-0"><b>Grand Total =>
                                                {{ getStructuredAmount($bill->amount, true, false) }}</b></h5>
                                        <br>
                                        <h5 class="m-b-0">Created By => {{ $bill->user }}</h5>
                                        <h5 class="m-b-0">Created At => {{ $bill->site }}</h5>
                                        <h5 class="m-b-0">Party Balance => {{ getStructuredAmount($balance, true, false) }}
                                        </h5>
                                        <br>
                                    </div>
                                </div>
                                <hr>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}


    <!-- Jquery Core Js -->
    @endif
</body>

</html>

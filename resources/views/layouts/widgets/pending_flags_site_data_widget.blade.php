<div class="row clearfix">
    @php
    $data = get_pending_flags_data_widget($id, $from ?? null, $to ?? null);
    @endphp
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2><strong>Flags</strong></h2>
            </div>
            <ul class="row profile_state list-unstyled">
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <a href="/pending_expense?from_date={{$from}}&to_date={{$to}}&site_id={{$id}}">
                            <i class="zmdi {{getFlagAlertIconClass($data['pending_expense'])}} "></i>      
                            <h4>
                                {{ $data['pending_expense'] }}
                            </h4>
                            <span>Pending Expenses</span>
                        </a>
                    </div>
                </li>
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <a href="/pending_material?from_date={{$from}}&to_date={{$to}}&site_id={{$id}}">
                            <i class="zmdi  {{getFlagAlertIconClass($data['pending_mat'])}}"></i>         
                            <h4>
                                {{ $data['pending_mat'] }}
                            </h4>
                            <span>Pending Material Entries</span>
                        </a>
                    </div>
                </li>
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <a href="/pending_bill?from_date={{$from}}&to_date={{$to}}&site_id={{$id}}">
                            <i class="zmdi {{getFlagAlertIconClass($data['pending_bill'])}}"></i>         
                            <h4>
                                {{ $data['pending_bill'] }}
                            </h4>
                            <span>Pending Bills</span>
                        </a>
                    </div>
                </li>
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <a href="/pending_paymentvoucher?from_date={{$from}}&to_date={{$to}}&site_id={{$id}}">
                            <i class="zmdi {{getFlagAlertIconClass($data['pending_pv'])}}"></i>         
                            <h4>
                                {{ $data['pending_pv'] }}
                            </h4>
                            <span>Pending Payment Vouchers</span>
                        </a>
                    </div>
                </li>
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <a href="/verified_paymentvoucher?from_date={{$from}}&to_date={{$to}}&site_id={{$id}}">
                            <i class="zmdi {{getFlagAlertIconClass($data['unpaid_pv'])}}"></i>         
                            <h4>
                                {{ $data['unpaid_pv'] }}
                            </h4>
                            <span>Unpaid Payment Vouchers</span>
                        </a>
                    </div>
                </li>
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <i class="zmdi {{getFlagAlertIconClass(0)}} "></i>        
                        <h4>
                            0
                        </h4>
                        <span>Pending Document Requests</span>
                    </div>
                </li>
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <a href="/expense_party?status=Pending&from_date={{$from}}&to_date={{$to}}&site_id={{$id}}">
                            <i class="zmdi {{getFlagAlertIconClass($data['pending_expense_party'])}}"></i>         
                            <h4>
                                {{ $data['pending_expense_party'] }}
                            </h4>
                            <span>Pending Expense Parties</span>
                        </a>
                    </div>
                </li>
                <li class="col-lg-3 col-md-3 col-6">
                    <div class="body">
                        <a href="/billparty?status=Pending&from_date={{$from}}&to_date={{$to}}&site_id={{$id}}">
                            <i class="zmdi {{getFlagAlertIconClass($data['pending_bill_party'])}}"></i>         
                            <h4>
                                {{ $data['pending_bill_party'] }}
                            </h4>
                            <span>Pending Bill Parties</span>
                        </a>
                    </div>
                </li>

            </ul>
        </div>

    </div>
</div>

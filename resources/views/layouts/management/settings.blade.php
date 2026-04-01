@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Settings'])

    @php
        $settings = json_decode($data, true);
    @endphp
    @if (checkmodulepermission(9, 'can_edit') == 1)
        <div class="row clearfix">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">

                    <form action="{{ url('/updatebillsequence') }}" method="post" class="form">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title">Bills Sequence</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="Name">Sequence</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            @foreach ($settings as $setting)
                                                @if ($setting['name'] == 'bill_sequence')
                                                    <input type="text" id="bill_sequence" required class="form-control"
                                                        value="{{ $setting['value'] }}" name="bill_sequence">
                                                @endif
                                            @endforeach
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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">

                    <form action="{{ url('/updatepaymentvouchersequence') }}" method="post" class="form">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title">Payment Voucher Sequence</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="Name">Sequence</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            @foreach ($settings as $setting)
                                                @if ($setting['name'] == 'payment_voucher_sequence')
                                                    <input type="text" id="payment_voucher_sequence" required
                                                        class="form-control" value="{{ $setting['value'] }}"
                                                        name="payment_voucher_sequence">
                                                @endif
                                            @endforeach
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

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">

                    <form action="{{ url('/updateuploadsrc') }}" method="post" class="form">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title">Image Upload Source From Mobile</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="Name">Expense </label>
                                        <select class="form-control show-tick" data-live-search="true" required
                                            name="expense_upload_src">
                                            @php
                                                $upload_sources = ['Camera', 'Gallery', 'Both'];

                                            @endphp
                                            @foreach ($settings as $setting)
                                                @if ($setting['name'] == 'expense_upload_src')
                                                    @php $expense_upload_src = $setting['value']; @endphp
                                                @endif
                                            @endforeach
                                            @foreach ($upload_sources as $src)
                                                @if ($expense_upload_src == $src)
                                                    <option selected value="{{ $src }}"> {{ $src }}
                                                    </option>
                                                @else
                                                    <option value="{{ $src }}"> {{ $src }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="Name">Material First </label>
                                        <select class="form-control show-tick" data-live-search="true" required
                                        name="material_first_upload_src">
                                        @php
                                            $upload_sources = ['Camera', 'Gallery', 'Both'];

                                        @endphp
                                        @foreach ($settings as $setting)
                                            @if ($setting['name'] == 'material_first_upload_src')
                                                @php $material_first_upload_src = $setting['value']; @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($upload_sources as $src)
                                            @if ($material_first_upload_src == $src)
                                                <option selected value="{{ $src }}"> {{ $src }}
                                                </option>
                                            @else
                                                <option value="{{ $src }}"> {{ $src }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="Name">Material Second </label>
                                        <select class="form-control show-tick" data-live-search="true" required
                                        name="material_second_upload_src">
                                        @php
                                            $upload_sources = ['Camera', 'Gallery', 'Both'];

                                        @endphp
                                        @foreach ($settings as $setting)
                                            @if ($setting['name'] == 'material_second_upload_src')
                                                @php $material_second_upload_src = $setting['value']; @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($upload_sources as $src)
                                            @if ($material_second_upload_src == $src)
                                                <option selected value="{{ $src }}"> {{ $src }}
                                                </option>
                                            @else
                                                <option value="{{ $src }}"> {{ $src }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="Name">Machinery Document </label>
                                        <select class="form-control show-tick" data-live-search="true" required
                                        name="machinery_doc_upload_src">
                                        @php
                                            $upload_sources = ['Camera', 'Gallery', 'Both'];

                                        @endphp
                                        @foreach ($settings as $setting)
                                            @if ($setting['name'] == 'machinery_doc_upload_src')
                                                @php $machinery_doc_upload_src = $setting['value']; @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($upload_sources as $src)
                                            @if ($machinery_doc_upload_src == $src)
                                                <option selected value="{{ $src }}"> {{ $src }}
                                                </option>
                                            @else
                                                <option value="{{ $src }}"> {{ $src }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="Name">Machinery Service </label>
                                        <select class="form-control show-tick" data-live-search="true" required
                                        name="machinery_service_upload_src">
                                        @php
                                            $upload_sources = ['Camera', 'Gallery', 'Both'];

                                        @endphp
                                        @foreach ($settings as $setting)
                                            @if ($setting['name'] == 'machinery_service_upload_src')
                                                @php $machinery_service_upload_src = $setting['value']; @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($upload_sources as $src)
                                            @if ($machinery_service_upload_src == $src)
                                                <option selected value="{{ $src }}"> {{ $src }}
                                                </option>
                                            @else
                                                <option value="{{ $src }}"> {{ $src }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 form-control-label">
                                        <label for="Name">Document </label>
                                        <select class="form-control show-tick" data-live-search="true" required
                                        name="document_upload_src">
                                        @php
                                            $upload_sources = ['Camera', 'Gallery', 'Both'];

                                        @endphp
                                        @foreach ($settings as $setting)
                                            @if ($setting['name'] == 'document_upload_src')
                                                @php $document_upload_src = $setting['value']; @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($upload_sources as $src)
                                            @if ($document_upload_src == $src)
                                                <option selected value="{{ $src }}"> {{ $src }}
                                                </option>
                                            @else
                                                <option value="{{ $src }}"> {{ $src }}</option>
                                            @endif
                                        @endforeach

                                    </select>
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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">

                    <form action="{{ url('/updatecurrency') }}" method="post" class="form">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="title">Currency Settings</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="Name">Name</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            @foreach ($settings as $setting)
                                                @if ($setting['name'] == 'currency')
                                                    <input type="text" id="Name" required class="form-control"
                                                        value="{{ $setting['value'] }}" name="currency_name"
                                                        placeholder="Enter the Expense Head Name">
                                                @endif
                                            @endforeach
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
        </div>
    @endif
@endsection

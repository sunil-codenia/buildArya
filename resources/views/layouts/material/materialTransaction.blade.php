@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Material Transactions'])

    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Material Transactions </strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                        <div class="info-content">Material Transactions will be listed here.</div>
                    </h2>
                    <div class="align-center">
                        <div class="card">
                            <div class="row-clearfix"
                                style="display:flex;  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s; padding:20px 10px 20px 10px;    align-items: anchor-center;">
                              
                                <div class="col-4">
                                   <h6>Material : {{$current_stock->material_name}}</h6>
                                </div>
                                <div class="col-4">
                                  <h6>Site : {{$current_stock->site_name}}</h6>
                                </div>
                                <div class="col-4">
                                    <h6>Current Stock : {{$current_stock->qty}} {{$current_stock->unit_name}}</h6>
                                  </div>
                            </div>
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
                                        <th>Transaction Type</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Refrence</th>
                                    </tr>
                                </thead>

                                <tbody id="matTableBody">
                                    @php

                                        $i = 1;
                                        
                                    @endphp
                                    @foreach ($transactions as $dd)
                                        <tr>
                                            <td>{{ $i++ }}

                                            </td>

                                            <td>
                                                {{ substr($dd->create_datetime, 0, 10) }}
                                            </td>
                                            <td>
                                                {{ $dd->type }}
                                            </td>
                                            <td>
                                                {{ $dd->qty }}
                                            </td>
                                            <td>
                                                {{ $current_stock->unit_name }}
                                            </td>
                                            <td>
                                                {{ $dd->refrence }}
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

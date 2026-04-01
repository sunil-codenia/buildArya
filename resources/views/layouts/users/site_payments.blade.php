@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Sites Payments'])
 
    <div class="row clearfix">

   
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Site Payments</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                       
                    </h2>
                   <br>
                   <h4>Site Name - {{$site_name}}</h4>
                

                <div class="body">
                    @if (checkmodulepermission(1, 'can_view') == 1)
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Remark</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                      
                                    @endphp

                                    @foreach ($data as $dd)
                                      

                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>
                                                <a class="single-user-name" href="#">{{ $dd->date }}</a>
                                            </td>
                                            <td>
                                                <a class="single-user-name" href="#">{{ $dd->amount }}</a>
                                            </td>
                                            <td>
                                                <a class="single-user-name" href="#">{{ $dd->remark }}</a>
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
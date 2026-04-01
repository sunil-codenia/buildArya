@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Company Activity'])
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Activities</strong> <small>Recent user Activities</small></h2>


                        <ul class="header-dropdown">
                            
                            <li style="    vertical-align: top;">   
                                
                                <div class="card border">
                                    <div class="body" style="    text-align-last: center;">
                                        <h6 >
                                            Showing Data Of :- <u>
                                                @if($by_module)
                                                {{getcompanyModulesName($module_id)}}
                                                @else
                                                All Modules
                                                @endif



                                            </u>
                                        </h6>
                                       
                                @if($by_module)
                                <hr>
                                <a href="{{url('/activity')}}"  class="btn btn-primary  btn-round waves-effect"
                                style="color:white !important;">Get All Modules Data</a>
                                @endif
                                    </div>
                                </div>
                            </li>
                            <li style="    vertical-align: top;">

                                <div class="card border">
                                    <div class="body" style="    text-align-last: center;">
                                        <h6 >
                                            Change Display Module                                       </h6>
                                        <hr>
                                      
                                        <form method="post" action="{{ url('/moduleActivity') }}">

                                            @csrf

                                            @php
                                                $modules = getcompanyModules();
                                            @endphp
                          
                                            <select class="form-control show-tick" data-live-search="true" required
                                                name="module_id">
                                                <option selected value=""> Change Display Module</option>
                                                @foreach ($modules as $module)
                                                    <option value="{{ $module->id }}"> {{ $module->name }}</option>
                                                @endforeach

                                            </select>

                                            <button type="submit" class="btn btn-primary  btn-round waves-effect"
                                                style="color:white !important;">Search</button>
                                        </form>
                                   
                                    </div>
                                </div>

                            </li>
                        </ul>
                    </div> <br> <br> <br><br>

                    <div class="body">
                        @if (checkmodulepermission(11, 'can_view') == 1)
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Time</th>

                                            <th>Messages</th>
                                            <th>Name</th>
                                            <th>Module</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($activities as $activity)
                                            <tr>
                                                <td>
                                                    {{ $i++ }}
                                                </td>
                                                <td>{{ $activity->date }}</td>
                                                <td>{{ $activity->time }}</td>
                                                <td>{{ $activity->action }}</td>
                                                <td>{{ $activity->uid != 0 ? getUserDetailsById($activity->uid)->name : 'User Info Unavailable ' }}
                                                </td>
                                                <td>{{ getcompanyModulesName($activity->module_id) }}</td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-danger">You Don't Have Permission To View</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

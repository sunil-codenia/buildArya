@extends('app')
@section('content')
@include('templates.blockheader', ['pagename' => 'Verified Material Consumption / Wastage'])

<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="header">
                <h2><strong>Verified Material Consumption / Wastage</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                    <div class="info-content" >Material Consumption / Wastage which are verified will be listed here.</div></h2>
                    <div class="align-center">
                       
                        <button type="button" onclick="showconsumption();" id="showconsumption_btn" class="btn btn-success btn-fill btn-round waves-effect"><a>Consumption <span style="color:white;border-radius:50%;background:black;padding-inline:4px;">{{count($material_consumption)}}</span></a></button>
                        <button type="button" onclick="showwastage();" id="showwastage_btn" class="btn btn-secondry btn-simple btn-round waves-effect"><a>Wastage <span style="color:white;border-radius:50%;background:red;padding-inline:4px;">{{count($material_wastage)}}</span></a></button>
                       </div>    

            </div>
            @if(checkmodulepermission(3,'can_view') == 1)
            <div class="body">
                <div id="consumption_view" class="table-responsive">
            
                        <table id="dataTable" class="table table-hover">
                     
                        <thead>
                            <tr>           
                                <th>#</th>                            
                               
                                <th>Material</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Site</th>
                                <th>User</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       
                        <tbody>
                            @php
                 
                          $i=1;
                          @endphp
                          @foreach($material_consumption as $dd)
                                         
                          <tr>
                                       <td>{{$i++}}
                                        
                                    </td>
                                       
                                        <td>
                                            {{$dd->material}}
                                        </td>
                                        <td>
                                            {{$dd->unit}}
                                        </td>
                                        <td>
                                            {{$dd->qty}}
                                        </td>                                                                            
                                        <td>
                                            {{$dd->status}}
                                        </td>
                                        <td>
                                            {{$dd->remark}}
                                        </td>
                                        <td>
                                            {{$dd->site}}
                                        </td>
                                        <td>
                                            {{$dd->user}}
                                        </td>
                                        <td>
                                            {{$dd->location}}
                                        </td>
                                        <td>
                                            {{$dd->date}}
                                        </td>
                                        <td class="d-flex text-center">
                                            @php 
                                            $image = $dd->image;
                                            @endphp
                                            <img class="lazy" data-src="{{$dd->image}}" onclick="enlargeImage('{{$image}}')"  height="50px" width="50px" />
                                         
                                        </td>
                                        <td class="text-center">
                                          
                                            @php
                                            $ddid = $dd->id;
                                            @endphp
                                            @if($dd->status == 'Approved')
                                                           
                                                            @if(checkmodulepermission(3,'can_certify') == 1)
                                                            <button title="Reject" type="button" onclick="rejectconsumption('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-block"></i> </button>
                                                            @endif
                                            @else
                                                @if(checkmodulepermission(3,'can_certify') == 1)
                                            <button title="Approve" type="button" onclick="approveconsumption('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-check-circle"></i> </button>
                                            @endif
                                            
                                           
                                            @if(checkmodulepermission(3,'can_edit') == 1)
                                            <button title="Edit" type="button" onclick="editconsumption('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-edit"></i> </button>
                                            @endif
                                    @endif
                                        </td>
                                       </tr>  
                       @endforeach
                            
                        </tbody>


                    </table>
            
                </div>
                <div id="wastage_view" class="table-responsive" style="display: none;">
                                
                        <table id="dataTable2" class="table table-hover" style="width:100%;">
                     
                        <thead>
                            <tr>           
                                <th>#</th>                            
                               
                                <th>Material</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Reason</th>
                                <th>Site</th>
                                <th>User</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       
                        <tbody>
                            @php
                 
                          $i=1;
                          @endphp
                          @foreach($material_wastage as $dd)
                                         
                          <tr>
                                       <td>{{$i++}}
                                        
                                    </td>
                                       
                                        <td>
                                            {{$dd->material}}
                                        </td>
                                        <td>
                                            {{$dd->unit}}
                                        </td>
                                        <td>
                                            {{$dd->qty}}
                                        </td>                                                                            
                                        <td>
                                            {{$dd->status}}
                                        </td>
                                        <td>
                                            {{$dd->remark}}
                                        </td>
                                        <td>
                                            {{$dd->reason}}
                                        </td>
                                        <td>
                                            {{$dd->site}}
                                        </td>
                                        <td>
                                            {{$dd->user}}
                                        </td>
                                        <td>
                                            {{$dd->location}}
                                        </td>
                                        <td>
                                            {{$dd->date}}
                                        </td>
                                        <td class="d-flex text-center">
                                            @php 
                                            $image = $dd->image;
                                            @endphp
                                            <img class="lazy" data-src="{{$image}}" onclick="enlargeImage('{{$image}}')"  height="50px" width="50px" />
                                         
                                        </td>
                                        <td class="text-center">
                                            
                                            @php
                                            $ddid = $dd->id;
                                            @endphp
                                            @if($dd->status == 'Approved')
                                                           
                                                            @if(checkmodulepermission(3,'can_certify') == 1)
                                                            <button title="Reject" type="button" onclick="rejectwastage('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-block"></i> </button>
                                                            @endif
                                            @else
                                                @if(checkmodulepermission(3,'can_certify') == 1)
                                            <button title="Approve" type="button" onclick="approvewastage('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-check-circle"></i> </button>
                                            @endif
                                            
                                           
                                            @if(checkmodulepermission(3,'can_edit') == 1)
                                            <button title="Edit" type="button" onclick="editwastage('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-edit"></i> </button>
                                            @endif
                                    @endif
                                        </td>
                                       </tr>  
                       @endforeach
                            
                        </tbody>


                    </table>
               
                </div>
            </div>
            @else
            <div class="alert alert-danger">  You Don't Have Permission to View !!</div>
            @endif
        </div>
    </div>
</div>
<script>
    function showconsumption(){
        $('#showwastage_btn').removeClass('btn-fill')  
                      .addClass('btn-simple');
        $('#showconsumption_btn').removeClass('btn-simple')  
                      .addClass('btn-fill');
                      $('#consumption_view').css('display', 'block');
                      $('#wastage_view').css('display', 'none');
                   
    }
    function showwastage(){
        $('#showconsumption_btn').removeClass('btn-fill').addClass('btn-simple');
        $('#showwastage_btn').removeClass('btn-simple')  
                      .addClass('btn-fill');
                      $('#wastage_view').css('display', 'block');
                      $('#consumption_view').css('display', 'none');                
    }


      function rejectconsumption(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Reject This material consumption ?",
          icon: 'warning',
          showCancelButton: true,
          toast: true,
              position: 'center',
              showConfirmButton: true,
              timer: 8000,
              timerProgressBar: true,
          confirmButtonColor: '#ff0000',
          cancelButtonColor: '#000000',
          confirmButtonText: 'Reject',
          cancelButtonText: 'Cancel',
          customClass:{
              container: 'model-width-450px'
          },
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "{{url('/reject_consumption_by_id/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
      function approveconsumption(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Approve This material consumption ?",
          icon: 'success',
          showCancelButton: true,
          toast: true,
              position: 'center',
              showConfirmButton: true,
              timer: 8000,
              timerProgressBar: true,
          confirmButtonColor: '#17ce0a',
          cancelButtonColor: '#000000',
          confirmButtonText: 'Approve',
          cancelButtonText: 'Cancel',
          customClass:{
              container: 'model-width-450px'
          },
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "{{url('/approve_consumption_by_id/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
      function editconsumption(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Edit This Material Consumption ?",
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
          customClass:{
              container: 'model-width-450px'
          },
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "{{url('/edit_consumption_entry/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
 

      function rejectwastage(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Reject This material wastage ?",
          icon: 'warning',
          showCancelButton: true,
          toast: true,
              position: 'center',
              showConfirmButton: true,
              timer: 8000,
              timerProgressBar: true,
          confirmButtonColor: '#ff0000',
          cancelButtonColor: '#000000',
          confirmButtonText: 'Reject',
          cancelButtonText: 'Cancel',
          customClass:{
              container: 'model-width-450px'
          },
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "{{url('/reject_wastage_by_id/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
      function approvewastage(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Approve This material wastage ?",
          icon: 'success',
          showCancelButton: true,
          toast: true,
              position: 'center',
              showConfirmButton: true,
              timer: 8000,
              timerProgressBar: true,
          confirmButtonColor: '#17ce0a',
          cancelButtonColor: '#000000',
          confirmButtonText: 'Approve',
          cancelButtonText: 'Cancel',
          customClass:{
              container: 'model-width-450px'
          },
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "{{url('/approve_wastage_by_id/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
      function editwastage(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Edit This Material Wastage ?",
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
          customClass:{
              container: 'model-width-450px'
          },
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "{{url('/edit_wastage_entry/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
 
   </script>
@endsection

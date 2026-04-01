@extends('app')
@section('content')
@include('templates.blockheader', ['pagename' => 'Verified Material '])

<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="header">
                <h2><strong>Verified Material</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                    <div class="info-content" >Material entries which are apporved or rejected  will be listed here.</div></h2>
                
            </div>
            @if(checkmodulepermission(3,'can_view') == 1)
            <div class="body">
                <div class="table-responsive">
                    <form action="{{url('/add_material_bill_info')}}" method="POST">
                        @csrf
                        <div class="align-right">
                        @if(checkmodulepermission(3,'can_add') == 1)
                            <button type="submit" name="bill_info" value = "bill_info" class="btn btn-success btn-simple btn-round waves-effect"><a>Add Bill Information</a></button>
                        @endif    
                        </div>      
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>           
                                <th>#</th>                            
                                <th >Supplier</th>
                                <th>Material</th>
                                <th>Unit</th>
                            
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                
                                <th>Vehicle</th>
                              
                                <th>Status</th>
                                <th>Remark</th>
                                <th>Site</th>
                                <th>User</th>
                                <th>Location</th>
                                <th>Bill No.</th>

                                <th>Date</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                    
                          $dataarray = json_decode($data, true);
                          $i=1;
                          @endphp
                          @foreach($dataarray as $dd)
                                         
                          <tr>
                                       <td>{{$i++}}</td>
                                       <td>
                                        {{$dd['supplier']}}
                                    </td>
                                    <td>
                                        {{$dd['material']}}
                                    </td>
                                    <td>
                                        {{$dd['unit']}}
                                    </td>
                                    <td>
                                        {{$dd['qty']}}
                                    </td>
                                    <td>
                                        {{$dd['rate']}}
                                    </td>
                                    <td>
                                        {{$dd['amount']}}
                                    </td>
                                    
                                    <td>
                                        {{$dd['vehical']}}
                                    </td>
                                    <td>
                                        {{$dd['status']}}
                                    </td>
                                    <td>
                                        {{$dd['remark']}}
                                    </td>
                                    <td>
                                        {{$dd['site']}}
                                    </td>
                                    <td>
                                        {{$dd['user']}}
                                    </td>
                                    <td>
                                        {{$dd['location']}}
                                    </td>
                                    <td>
                                        {{$dd['bill_no']}}
                                    </td>
                                  
                                    <td>
                                        {{$dd['date']}}
                                    </td>
                                      <td class="d-flex">
                                        @php 
                                        $image = $dd['image'];
                                        @endphp
                                         @if($image != null && $image != '')
                                            <img class="lazy" data-src="{{$dd['image']}}"  onclick="enlargeImage('{{$image}}')" height="50px" width="50px" />
                                            @endif
                                            @php 

                                            $image2 = $dd['image2'];
                                            @endphp
                                            @if($image2 != null && $image2 != '')
                                                <img class="lazy" data-src="{{$dd['image2']}}"  onclick="enlargeImage('{{$image2}}')" height="50px" width="50px" />
                                                @endif
                                        </td>
                                        <td>
                                            <?php
                                            $ddid = $dd['id'];
                                            if($dd['status'] == 'Approved'):?>
                                                            <input type="checkbox" name="check_list[]" value="{{$dd['id']}}"> 
                                                            &nbsp;
                                                            @if(checkmodulepermission(3,'can_certify') == 1)
                                                            <button title="Reject" type="button" onclick="rejectmaterial('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-block"></i> </button>
                                                            @endif
                                            <?php else: ?>
                                                @if(checkmodulepermission(3,'can_certify') == 1)
                                            <button title="Approve" type="button" onclick="approvematerial('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-check-circle"></i> </button>
                                            @endif
                                            &nbsp;
                                            @if(  $dd['bill_no'] != null &&   $dd['bill_no'] != '')
                                            <a href="{{url('/material_pdf/?id='.$ddid)}}" target="_blank" style="all:unset" ><i class="zmdi zmdi-collection-pdf"></i> </a> 
                                            @endif
                                            @if(checkmodulepermission(3,'can_edit') == 1)
                                            <button title="Edit" type="button" onclick="editmaterial('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-edit"></i> </button>
                                            @endif
                                    <?php endif;?>
                                </td>
                                       </tr>    
                            @endforeach
                            
                        </tbody>
                       
                    </table>
                </form>
                </div>
            </div>
            @else
            <div class="alert alert-danger"> You Don't Have Permission to View </div>
            @endif
        </div>
    </div>
</div>
<script>
    function rejectmaterial(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Reject This material Entry?",
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
              var url = "{{url('/reject_material_by_id/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
      function approvematerial(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Approve This material Entry ?",
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
              var url = "{{url('/approve_material_by_id/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
      function editmaterial(id) {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Edit This Material Entry ?",
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
              var url = "{{url('/edit_material_entry/?id=')}}" + id;
              window.location.href = url;
          }
      });
      }
  </script>

@endsection

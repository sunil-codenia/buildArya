@extends('app')
@section('content')
@include('templates.blockheader', ['pagename' => 'Pending Material'])

<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="header">
                <h2><strong>Pending Material</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                    <div class="info-content" >Material entry which are pending will be listed here.</div></h2>
            </div>
            @if(checkmodulepermission(3,'can_view') == 1)
            <div class="body">
                <div class="table-responsive">
                    <form action="{{url('/update_material')}}" method="POST">
                        @csrf
                        <div class="align-right">
                        @if(checkmodulepermission(3,'can_certify') == 1)
                        <button type="submit" name="approve_material" value = "approve_material" class="btn btn-success btn-simple btn-round waves-effect"><a>Approve</a></button>
                        @endif
                        @if(checkmodulepermission(3,'can_certify') == 1)
                        <button type="submit" name="reject_material"  value="reject_material" class="btn btn-danger btn-simple btn-round waves-effect"><a>Reject</a></button>
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
                                
                                <th>Vehicle</th>
                              
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
                 
                          $dataarray = json_decode($data, true);
                          $i=1;
                          @endphp
                          @foreach($dataarray as $dd)
                                         
                          <tr>
                                       <td>{{$i++}}
                                        
                                    </td>
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
                                            {{$dd['date']}}
                                        </td>
                                        <td class="d-flex text-center">
                                            @php 
                                            $image = $dd['image'];
                                            @endphp
                                            <img class="lazy" data-src="{{$dd['image']}}" onclick="enlargeImage('{{$image}}')"  height="50px" width="50px" />
                                            @php
                                            $image2 = $dd['image2'];
                                            @endphp
                                                <img class="lazy" data-src="{{$dd['image2']}}"  onclick="enlargeImage('{{$image2}}')" height="50px" width="50px" />
                                        

                                        </td>
                                        <td class="text-center">
                                            @if(checkmodulepermission(3,'can_certify') == 1)
                                            <?php $ddid = $dd['id']; ?>
                                            <input type="checkbox" name="check_list[]" value="{{$dd['id']}}"> 
                                            @endif
                                            &nbsp;
                                            @if(checkmodulepermission(3,'can_edit') == 1)
                                            <button title="Edit" type="button" onclick="editmaterial('{{$ddid}}')" style="all:unset" ><i class="zmdi zmdi-edit"></i> </button>
                                            @endif
                                            
                                        </td>
                                       </tr>  
                       @endforeach
                            
                        </tbody>


                    </table>
                </form>
                </div>
            </div>
            @else
            <div class="alert alert-danger">  You Don't Have Permission to View !!</div>
            @endif
        </div>
    </div>
</div>
<script>
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

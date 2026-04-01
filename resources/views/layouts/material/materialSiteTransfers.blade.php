@extends('app')
@section('content')
@include('templates.blockheader', ['pagename' => 'Material Transfer (Site To Site)'])

<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="header">
                <h2><strong>Material Transfer (Site To Site)</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                    <div class="info-content" >Material Transfers will be listed here.</div></h2>
                    <div class="align-right">
                        @if(checkmodulepermission(3,'can_add') == 1 && $entry_at_site == 'all')
                        <button type="button" onclick="transferMaterial();"  class="btn btn-secondry btn-fill btn-round waves-effect"><a>Transfer Material</a></button>
                        @endif
                       </div>    

            </div>
            @if(checkmodulepermission(3,'can_view') == 1)
            <div class="body">
                <div id="consumption_view" class="table-responsive">
                            
                        <table id="dataTable" class="table table-hover">                     
                        <thead>
                            <tr>           
                                <th>#</th>     
                                <th>Date</th>   
                                <th>From Site</th>
                                <th>To Site</th>
                                                                            
                                <th>Material</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                              
                                <th>User</th>
                                <th>Remark</th>
                                <th>Vehicle No.</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       
                        <tbody>
                            @php
                 
                          $i=1;
                          @endphp
                          @foreach($material_transfer as $dd)
                                         
                          <tr>
                                       <td>{{$i++}}
                                        
                                    </td>
                                       
                                        <td>
                                            {{$dd->date}}
                                        </td>
                                        <td>
                                            {{$dd->f_site}}
                                        </td>
                                        <td>
                                            {{$dd->t_site}}
                                        </td>                                                                            
                                        <td>
                                            {{$dd->material}}
                                        </td>
                                        <td>
                                            {{$dd->unitname}}
                                        </td>
                                        <td>
                                            {{$dd->qty}}
                                        </td>
                                        <td>
                                            {{$dd->user}}
                                        </td>
                                        <td>
                                            {{$dd->remark}}
                                        </td>
                                        <td>
                                            {{$dd->vehicle_no}}
                                        </td>
                                       
                                        <td class="text-center">
                                      
                                         
                                            @if(checkmodulepermission(3,'can_delete') == 1)
                                            <button title="Delete" type="button" onclick="deletedata('{{$dd->id}}')" style="all:unset" ><i class="zmdi zmdi-delete"></i> </button>
                                      
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
  
      function transferMaterial() {
       Swal.fire({
          title: 'Are you sure?',
          text: "You Want To Transfer New Material ?",
          icon: 'warning',
          showCancelButton: true,
          toast: true,
              position: 'center',
              showConfirmButton: true,
              timer: 8000,
              timerProgressBar: true,
          confirmButtonColor: '#eda61a',
          cancelButtonColor: '#000000',
          confirmButtonText: 'Yes, Transfer',
          cancelButtonText: 'Cancel',
          customClass:{
              container: 'model-width-450px'
          },
      }).then((result) => {
          if (result.isConfirmed) {
              var url = "{{url('/newMaterialSiteTransfer')}}";
              window.location.href = url;
          }
      });
      }
      function deletedata(id) {
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
                    var url = "{{ url('/deleteMaterialTransferForm/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

   </script>
@endsection

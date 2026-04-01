@extends('app')
@section('content')
@include('templates.blockheader', ['pagename' => 'Update Bill Information'])
@php
$data = json_decode($data, true);
$materialentries = $data['material_entries'];

@endphp

<div class="row clearfix">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="card project_list">
      @if(checkmodulepermission(3,'can_edit') == 1)
         <div class="modal-content">
            <div class="modal-body">
               <form method="post" action="{{url('/update_material_bill_info')}}" enctype="multipart/form-data">
                  @csrf
                    <hr>
                  <div class="row clearfix">
                   
                     <div class="col-lg-9 col-md-9 col-sm-9">
                        <div class="row clearfix">
              
                           <div class="col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group">
                                 <label>Bill No.</label>
                                 <input type="text" placeholder="Supplier Bill No" required  class="form-control" name="bill_no" >
                               
                              </div>
                           </div>

                         

                     
                         
                        </div>
                     </div>
                     <div class=" col-lg-12 container" style="display:block;padding: 10px;">     
           
              <hr>
              <h4>Set Rate At Once</h4>
                        <div class="row">
                <div class="col-md-4 pb-3">
                    <label for="constant_rate">Enter Rate</label>
                <input type="number" class="form-control" value="0" min="0"  step="0.001" pattern="^\d+(?:\.\d{1,4})?$" placeholder="Enter rate"  id="constant_rate" >
                </div>
                    <div class="col-md-4">
                        <label for="constant_tax">Enter Tax (%)</label>
                    <input type="number" class="form-control" value="0" min="0"  step="0.001" pattern="^\d+(?:\.\d{1,4})?$" placeholder="Enter tax" id="constant_tax"  >
                        </div>
                        <div class="col-md-4">
                            <button type="button" onclick="constantrate()" class="btn btn-primary btn-simple btn-round waves-effect"><a>Set</a></button>
                           
                        </div>
    
                        </div>
                  
    
                </div>
                    </div>
                  <hr>
                  <table  class="table table-hover">
                    <thead>
                        <tr>           
                            <th>#</th>                            
                            <th >Supplier</th>
                            <th>Material</th>
                            <th>Unit</th>
                            <th>Quantity</th>      
                            <th>Remark</th>
                            <th>Site</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Rate</th>
                            <th>Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                
                 
                      $i=1;
                      @endphp
                      @foreach($materialentries as $materialdata)
                 @php 
                 $dd = $materialdata[0];
                 @endphp
                 
                 
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
                                    {{$dd['remark']}}
                                </td>
                                <td>
                                    {{$dd['site']}}
                                </td>
                               
                                <td>
                                    {{$dd['date']}}
                                </td>
                                  <td>
                                        <img class="lazy" data-src="{{$dd['image']}}" height="50px" width="50px" />
                                    </td>
                                    <td>
                                        <input type="hidden" name="ids[]" value="{{$dd['id']}}" />
                                        <input type="number" placeholder="0.00" required class="form-control rateinput" name="rates[]" min="0"  step="0.001" pattern="^\d+(?:\.\d{1,4})?$">
                                      
                                        </td>
                                        <td>
                                        
                                            <input type="number" placeholder="0.00" required class="form-control taxinput" name="tax[]" min="0"  step="0.001" pattern="^\d+(?:\.\d{1,4})?$">
                                          
                                            </td>
                                   </tr>    
                                   @endforeach
                    </tbody>
                   
           
                 </table>

                 <br>
                 <div class="form-group">
                    <button style="float:right;" type="submit" class="btn btn-primary btn-simple btn-round waves-effect"><a>Update</a></button>
                 </div>
               </form>
            </div>
         </div>
         @else
         <div class="alert alert-danger"> You Don't Have Permission to Edit / Update </div>
         @endif
      </div>
   </div>
</div>
<script type="text/javascript">
    function constantrate(){
        var rate = document.getElementById("constant_rate").value;
        var tax = document.getElementById("constant_tax").value;
            

if (rate != null || rate != 0 && tax != null || tax != 0 ) {
    Array.from(document.getElementsByClassName('rateinput')).forEach(el => el.value = rate);
    Array.from(document.getElementsByClassName('taxinput')).forEach(el => el.value = tax);

}
    }


    

 
</script>
@endsection
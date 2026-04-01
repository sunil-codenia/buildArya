@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Bill Party Payments'])
 
    <div class="row clearfix">

   
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Bill Party Payments</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                        
                    </h2>
                    <ul class="header-dropdown">
                        <li>

                            @if (checkmodulepermission(4, 'can_pay') == 1)
                                <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                    data-toggle="modal" data-target="#billpartybalancemodal" type="button">
                                    <i class="zmdi zmdi-balance-wallet" style="color: white;"></i>
                                </button>
                            @endif
                        </li>
                    </ul>
                   <br>
                   <h4>Party Name - {{$bill_party_name}}</h4>
              

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
                                      <th>Edit</th>
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
                                            <td>
                                                @if (checkmodulepermission(4, 'can_pay') == 1)
                                                <button title="Edit" onclick="editparty({{ $dd->id }},'{{$dd->date}}','{{$dd->remark}}','{{$dd->amount}}')"
                                                    style="all:unset"><i class="zmdi zmdi-edit"></i> </button>
                                                &nbsp;
                                            @endif
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
@section('models')
@if (checkmodulepermission(4, 'can_pay') == 1)
<div class="modal fade" id="billpartybalancemodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <form action="{{ url('/addBillPartyBalance') }}" method="post" class="form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title">Add Payment To Bill Party </h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="hidden" id="billpartybalanceid" value="{{$id}}" name="party_id" />
                                <input type="number" id="amount" required class="form-control"
                                    name="amount">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="Name">Date</label>

                                <input type="date" id="date" required class="form-control"
                                    name="date">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="Name">Remark</label>

                                <input type="text" id="remark" required class="form-control"
                                    name="remark">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-simple waves-effect"
                        data-dismiss="modal"><a>CLOSE</a></button>
                    <button type="submit"
                        class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE</a></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="updatebillpartybalancemodal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <form action="{{ url('/updateBillPartyBalance') }}" method="post" class="form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title">Update Payment Of Bill Party </h4>
                </div>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="hidden" id="update_party_id" name="party_id" value="{{$id}}" />
                                <input type="hidden" id="update_id" name="id" />
                                <input type="number" id="update_amount" required class="form-control"
                                    name="amount">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="Name">Date</label>

                                <input type="date" id="update_date"  required class="form-control"
                                    name="date">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="Name">Remark</label>

                                <input type="text" id="update_remark" required class="form-control"
                                    name="remark">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-simple waves-effect"
                        data-dismiss="modal"><a>CLOSE</a></button>
                    <button type="submit"
                        class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE</a></button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script>

function editparty(id,date,remark,amount) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Entry ?",
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
                focusConfirm: true,
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                $('#updatebillpartybalancemodal').modal('show');
                $('#update_id').val(id);
                $('#update_date').val(date);
                $('#update_remark').val(remark);
                $('#update_amount').val(amount);
            });
        }

       
</script>
@endsection
@extends('app')
@section('content')
    @include('templates.blockheader', ['pagename' => 'Contacts Management'])
    @php
        $edit = false;
        $companyData = json_decode($data, true); // Handle null or empty $data
        if (isset($companyData['edit_data'])) {
            $editdata = $companyData['edit_data'];
            $edit = true;
        } else {
            $editdata = null;
        }
    @endphp


    <div class="container-fluid">
        <div class="row clearfix">
            @if ($edit)
                @if (checkmodulepermission(10, 'can_edit') == 1)
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card project_list">
                            <form action="{{ url('/updatecompany') }}" method="post" class="form">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="title">Edit Company Profile</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row clearfix">
                                            <div class="col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="col-sm-12 col-md-6">
                                                        <b>Company Name</b>
                                                        <div class="input-group">
                                                            <input type="hidden" name="id"
                                                                value="{{ $editdata['id'] }}">
                                                            <input type="text" required
                                                                value="{{ $editdata['comp_name'] }}" name="company_name"
                                                                class="form-control" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-md-6">
                                                        <b>Contact Person</b>
                                                        <div class="input-group">
                                                            <input type="text" required name="contact_name"
                                                                value="{{ $editdata['contact_name'] }}" class="form-control"
                                                                placeholder="Ex: +00 (000) 000-00-00">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4 col-sm-4 col-md-4">
                                                        <b>Number</b>
                                                        <div class="input-group">
                                                            <input type="number" required name="mobile"
                                                                value="{{ $editdata['mobile'] }}" class="form-control"
                                                                placeholder="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-md-4">
                                                        <b>Email</b>
                                                        <div class="input-group">
                                                            <input type="email" name="email" class="form-control"
                                                                value="{{ $editdata['email'] }}">

                                                        </div>
                                                    </div>
                                           
                                                    <div class="col-lg-4 col-sm-4 col-md-4">
                                                        <b>Category</b>
                                                        <div class="input-group">
                                                            @php $categories = getContactCategories(); @endphp
                                                            <select name="category"  class="form-control show-tick" data-live-search="true">
                                                             
                                                                @forEach($categories as $category)
                                                                @if($category == $editdata['category'])
                                                                <option selected value="{{$category}}">{{$category}}</option>
                                                                @else
                                                                <option value="{{$category}}">{{$category}}</option>
                                                                @endif

                                                                @endforeach
                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a type="submit" class="" href="{{ url('/users_report') }}">CLOSE</a>
                                        <button type="submit"
                                            class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE
                                                CHANGES</a></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">
                    <div class="header">
                        <h2><strong>Contacts</strong> List</h2>
                        <ul class="header-dropdown">

                          
                            <li>
                                @if(checkmodulepermission(10,'can_add') == 1)
                                <button type="button" data-toggle="modal" data-target="#addnewcompany"
                                    class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10">
                                    <i class="zmdi zmdi-plus" style="color: white;"></i>
                                </button>
                                @endif
                            </li>
                        </ul>
                    </div>


                    <div class="body">
                        @if(checkmodulepermission(10,'can_view') == 1)
                        <div class="table-responsive">
                            <style>
                           

.circle {
    height: auto;
    width: 20px !important;
    display: block;
    text-align: -webkit-center;
    aspect-ratio: 1;
    border-radius: 50%;
    color: white !important;
}
</style>
                            <table id="dataTable" class="table table-hover m-b-0 c_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th>Category </th>
                                        <th>No. Of Contacts</th>
                                        <th data-breakpoints="xs">Contact Person </th>
                                        <th data-breakpoints="xs sm md">Mobile</th>
                                        <th data-breakpoints="xs sm md">View</th>
                                        <th data-breakpoints="xs">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $count = 1;
                                        $arraycontact = $companyData['data'];
                                    @endphp
                                    @foreach ($arraycontact as $item)
                                        @php
                                            $contac = json_decode(json_encode($item), true);
                                            $contactda = [];
                                            $contactlist = [];
                                            $contactlist = $contac['list'];
                                            $contactda = $contac['data'];
                                            $ddid = $contactda['id'];

                                        @endphp


                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>
                                                <p class="c_name">{{ $contactda['comp_name'] }} </p>
                                            </td>
                                            <td>
                                                <span class="phone">{{ $contactda['category'] }} </span>
                                            </td>
                                            <td >
                                                @php $num = getNoOfContactInCompanyProfile($contactda['id']);@endphp
                                                <span class="circle " style="background-color: {{$num == 0 ? 'red' : 'lightseagreen'}};">{{$num }}</span></td>
                                            <td>
                                                <span class="name">{{ $contactda['contact_name'] }}</span>
                                            </td>
                                            <td>
                                                <address><i class="zmdi zmdi-phone m-r-10"></i>{{ $contactda['mobile'] }}
                                                </address>
                                            </td>
                                            <td>
                                                <button type="button" style="all:unset;"
                                                    onclick="showContactDetailsModel({{ $contactda['id'] }})"><i
                                                        class="zmdi zmdi-eye" style="font-size:30px;"></i></button>
                                            </td>

                                            <td>
                                                @if (checkmodulepermission(10, 'can_edit') == 1)
                                                    <a title="Edit" onclick="editcompanycontact('{{ $ddid }}')"
                                                        style="all:unset"><i class="zmdi zmdi-edit mx-2"
                                                            style="font-size:20px;"></i></a>
                                                @endif

                                                @if (checkmodulepermission(10, 'can_delete') == 1)
                                                    <a title="Delete" onclick="deletecompanyprofile('{{ $ddid }}')"
                                                        style="all:unset"><i class="zmdi zmdi-delete"
                                                            style="font-size:20px;"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('models')
@if(checkmodulepermission(10,'can_add') == 1)
    <div class="modal fade" id="addnewcompany" role="dialog">
        <div class="modal-dialog modal-lg" role="">
            <form action="{{ url('/addnew_company') }}" method="post" class="form">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title">Add New Company</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="row clearfix">
                                    <div class="col-sm-12 col-md-6">
                                        <b>Company Name</b>
                                        <div class="input-group">
                                            <input type="text" required name="companyname" class="form-control"
                                                placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-md-6">
                                        <b>Contact Person</b>
                                        <div class="input-group">
                                            <input type="text" required name="contactperson" class="form-control"
                                                placeholder="Ex: +00 (000) 000-00-00">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-4 col-md-4">
                                        <b>Mobile</b>
                                        <div class="input-group">
                                            <input type="number" required name="mobile" class="form-control"
                                                placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-lg-4 col-md-4">
                                        <b>Email</b>
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-lg-4 col-md-4">
                                        <b>Category</b>
                                        <div class="input-group">
                                            @php $categories = getContactCategories(); @endphp
                                            <select name="category"  class="form-control show-tick" data-live-search="true">
                                                <option value="">Select a Category</option>
                                                @forEach($categories as $category)
                                                <option value="{{$category}}">{{$category}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-simple waves-effect"
                            data-dismiss="modal"><a>CLOSE</a></button>
                        <button type="submit" class="btn btn-primary btn-simple btn-round waves-effect"><a>SAVE
                                CHANGES</a></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
@if(checkmodulepermission(10,'can_view') == 1)
    <div class="modal fade" id="showContactDetailsModel" role="dialog">
        <div class="modal-dialog modal-lg" role="">
            <div class="modal-content">



                <div class="modal-body">
                    <div class="" style="display: flex; justify-content: space-between;">
                        <h4 class="title" style="margin: 0%;">View Contact List</h4>
                        <button type="button" id="addcontact"
                            class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                            onclick="showForm()"> <i class="zmdi zmdi-plus" style="color: white;"></i></button>
                    </div>
                    <div class="form" id="contact-form" style="display: none;">

                        <form action="{{ url('/add_contact') }}" method="post" class="">
                            @csrf
                            <div class="modal-cot" style="border:1px dashed">

                                <div class="modal-body">
                                    <h4>Add New Contact</h4>
                                    <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="row clearfix">
                                                <div class="col-sm-12 col-md-6">
                                                    <b>Contact Name</b>
                                                    <div class="input-group">
                                                        <input type="hidden" name="profile_id"
                                                            id="addNewContactProfileId" />
                                                        <input type="text" required name="name"
                                                            class="form-control" placeholder=" Contact Name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <b>Phone</b>
                                                    <div class="input-group">
                                                        <input type="number" required name="number"
                                                            class="form-control" placeholder="Ex: +00 (000) 000-00-00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-md-6">
                                                    <b>Email</b>
                                                    <div class="input-group">
                                                        <input type="email" required name="email"
                                                            class="form-control" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>Position</b>
                                                    <div class="input-group">
                                                        <input type="text" required name="position"
                                                            class="form-control" placeholder="Position">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit"
                                        class="btn btn-primary btn-simple btn-round waves-effect"><a>Submit</a></button>
                                </div>
                            </div>
                        </form>
                        <div id="co"></div>
                    </div>
                    <div class="table-responsive" id="contact_table">
                        <table id="dataTable" class="table table-hover m-b-0 c_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th data-breakpoints="xs">Email </th>
                                    <th data-breakpoints="xs sm md">Mobile</th>
                                    <th data-breakpoints="xs sm md">Position</th>
                                    <th data-breakpoints="xs">Action</th>
                                </tr>
                            </thead>
                            <tbody id="contact-list">
                            </tbody>
                        </table>
                    </div>
                    <div id="contact_msg"></div>
                </div>
            </div>
        </div>
    </div>
@endif
@if(checkmodulepermission(10,'can_edit') == 1)
    <div class="modal fade" id="editContactModal" role="dialog">
        <div class="modal-dialog modal-lg" role="">
            <form action="{{ url('/update_contact') }}" method="post" >
                @csrf
                <div class="modal-content">



                    <div class="modal-body">
                        <div class="form" id="contact-form" >


                            <h4>Update Contact</h4>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="row clearfix">
                                        <div class="col-sm-12 col-md-6">
                                            <b>Contact Name</b>
                                            <div class="input-group">
                                                <input type="hidden" name="id" id="updateContactId" />
                                                <input type="text" required name="name" id="updateContactName" class="form-control"
                                                    placeholder=" Contact Name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-md-6">
                                            <b>Phone</b>
                                            <div class="input-group">
                                                <input type="number" required name="phone" id="updateContactNumber"  class="form-control"
                                                    placeholder="Ex: +00 (000) 000-00-00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-md-6">
                                            <b>Email</b>
                                            <div class="input-group">
                                                <input type="email" required name="email" id="updateContactEmail"  class="form-control"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <b>Position</b>
                                            <div class="input-group">
                                                <input type="text" required name="position" id="updateContactPosition"  class="form-control"
                                                    placeholder="Position">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal"
                            class="btn btn-primary btn-simple waves-effect"><a>Close</a></button>
                        <button type="submit"
                            class="btn btn-primary btn-simple btn-round waves-effect"><a>Submit</a></button>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endif    
@endsection
@section('scripts')
    <script>
        var table = document.getElementById("dataTable");
        var select = document.getElementById("mySelect");

        select.addEventListener("change", function() {
            var filter = this.value.toUpperCase();
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) {
                var categoryCell = rows[i].getElementsByTagName("td")[5];
                var category = categoryCell.innerHTML.toUpperCase();

                if (filter === "" || category.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });

        function editcompanycontact(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Company Details ?",
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
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/edit_company/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function editcontact(contactjson) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Contact Details ?",
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
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    $('#showContactDetailsModel').modal('hide');
                    $('#editContactModal').modal('show');
$('#updateContactId').val(contactjson.id);
$('#updateContactName').val(contactjson.name);
$('#updateContactNumber').val(contactjson.phone);
$('#updateContactEmail').val(contactjson.email);
$('#updateContactPosition').val(contactjson.position);

                }
            });


        }



        function deletecompanyprofile(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to delete this. All contacts attached with this company will also be deleted.",
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
                    var url = "{{ url('/delete_company_profile/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function deletecontact(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to delete this.",
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
                    var url = "{{ url('/delete_contact/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }
        //contact data ---------------------------------------------------


        function showContactDetailsModel(id) {

            var xhr = new XMLHttpRequest();
            xhr.open('GET', "{{ url('/get_contact_data/?profile_id=') }}" + id, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {

                    var response = JSON.parse(xhr.responseText);
                    var contactList = document.getElementById('contact-list');
                    var contact_table = document.getElementById('contact_table');
                    var contact_msg = document.getElementById('contact_msg');
                    document.getElementById('addNewContactProfileId').value = id;

                    contact_table.style.display = 'block';
                    contact_msg.style.display = 'none';
                    html = "";
                    if (response.data.length == 0) {
                        contact_table.style.display = 'none';
                        contact_msg.style.display = 'block';
                        contact_msg.innerHTML = "<span style='color:red;'>No Contacts Found!</span>";
                    } else {
                        response.data.forEach(function(contact, index) {
                            const contactJson = JSON.stringify(contact).replace(/"/g, '&quot;');

                            html += `<tr><td>${index + 1}</td>
                            <td>${contact.name}</td>
                            <td>${contact.email}</td>
                            <td>${contact.phone}</td>
                            <td>${contact.position}</td>
                            <td> 
                                @if (checkmodulepermission(1, 'can_edit') == 1)
                                                    <a title="Edit" onclick="editcontact(${contactJson})"
                                                        style="all:unset"><i class="zmdi zmdi-edit mx-2"
                                                            style="font-size:20px;"></i></a>
                                                @endif

                                                @if (checkmodulepermission(1, 'can_delete') == 1)
                                                    <a title="Delete" onclick="deletecontact(${contact.id})"
                                                        style="all:unset"><i class="zmdi zmdi-delete"
                                                            style="font-size:20px;"></i></a>
                                                @endif</td>
                            </tr>`;
                        });
                    }
                    contactList.innerHTML = html;
                    $('#showContactDetailsModel').modal('show');
                }
            };


            xhr.send();
        }

        function showForm() {
            var form = document.getElementById("contact-form");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>
@endsection

@extends('app')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @include('templates.blockheader', ['pagename' => 'Document Management'])
    <style>
        .list-group-item {
            background-color: inherit;
            border: none;
            margin-bottom: 0px;
            padding: 0px;
        }


        #data-display-image {
            padding: 20px;

        }

        #data-display-pdf {
            padding: 20px;
        }
    </style>


    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12 col-lg-4">
                <div class="card top-report">
                    <div class="body">
                        <h3 class="m-t-0 m-b-0">{{ formatSizeUnits($storage_comsume) }}</h3>
                        @php
                            $ts = 1073741824;
                            $csp = round(($storage_comsume / $ts) * 100);
                        @endphp
                        <p class="text-muted">Storage Consume</p>
                        <div class="progressbar-xs progress-rounded progress-striped progress ng-isolate-scope"
                            value="{{ $csp }}" type="success">
                            <div class="progress-bar progress-bar-success" role="progressbar"
                                aria-valuenow="{{ $csp }}" aria-valuemin="0" aria-valuemax="100"
                                style="width: {{ $csp }}%;"></div>
                        </div>
                        <small>{{ $csp }}% Storage Consumed Of 1 GB</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to">
                            {{ $files_count }}

                        </h3>
                        <p class="text-muted">Total Files</p>
                        <div class="progress">
                            <div class="progress-bar l-blue" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                        {{-- <small>{{$name}}</small> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to">
                            {{ $images_count }}</h3>

                        <p class="text-muted">Total Images</p>
                        <div class="progress">
                            <div class="progress-bar l-green" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                        {{-- <small>Change 9%</small> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to">
                            {{ $pdfs_count }}
                        </h3>

                        <p class="text-muted">Total PDFs</p>
                        <div class="progress">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                        {{-- <small>Change 17%</small> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3">
                <div class="card">
                    <div class="body">
                        <h3>
                            {{ $other_count }}
                        </h3>

                        <p class="text-muted">Other Files Count</p>
                        <div class="progress">
                            <div class="progress-bar l-parpl" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                        {{-- <small>Change 13%</small> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>File</strong> Doc</h2>

                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending_files"><i
                                class="zmdi zmdi-file"></i> Pending Documents </a></li>
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#my_file"><i
                                        class="zmdi zmdi-file"></i> My Document </a></li>
                            <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#system_doc"><i
                                        class="zmdi zmdi-folder"></i> System Document </a></li>

                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#doc_head"><i
                                        class="zmdi zmdi-file"></i> Document Head</a></li>

                        </ul>
                        <hr>
                        <!-- Tab panes -->
                        <div class="tab-content">

                            @include('layouts.doc.system_doc')
                            @include('layouts.doc.pending_doc')
                            @include('layouts.doc.my_doc')
                            @include('layouts.doc.document_head')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('models')
    {{-- upload file data  --}}
    <div class="modal fade" id="new" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">


                <div class="modal-header">
                    <h5>Upload Files</h5>


                </div>

                @if (checkmodulepermission(11, 'can_add') == 1)
                    <div class="modal-body" style="    border: 1px dashed;">
                        <form action="{{ url('my_doc_upload_file') }}" method="post" enctype="multipart/form-data"
                            class="form">
                            @csrf
                            <h6>Choose Filters</h6>
                            <div class="row clearfix">
                                @foreach ($doc_head as $head)
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label>{{ $head->name }}</label>
                                            @php
                                                $options = getDocHeadOptions($head->id);
                                            @endphp
                                            <select name="filter[]" class="form-control show-tick"
                                                data-live-search="true">
                                                <option value="" selected>--Select Option--</option>
                                                @foreach ($options as $opt)
                                                    <option value="{{ $head->id }}=>{{ $opt->id }}">
                                                        {{ $opt->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <h6>Choose Files</h6>
                            <div class="row clearfix">

                                <div class="col-lg-3 col-md-3 col-sm-4 ">
                                    <label>File Name<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <input type="text" required class="form-control" name="name[]"
                                            placeholder="Enter File Name">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-4 ">
                                    <label>Date<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <input type="date" required class="form-control" name="date[]">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 ">
                                    <label>Particular</label><br>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="particular[]"
                                            placeholder="Enter Particular">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-4 ">
                                    <label>Remark</label><br>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="remark[]"
                                            placeholder="Enter Remark">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-4">
                                    <label>Choose File</label><br>
                                    <div class="form-group">
                                        <input type="file" required class="form-control" name="img[]">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-2 text-right">
                                    <div class="form-group">
                                        <button type="button" id="docrow"
                                            class="btn btn-primary btn-simple btn-round waves-effect">
                                            <i class='zmdi zmdi-plus' style='color: white;'></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div id="additional-docrow"></div>
                            <button style="    float: right;" type="submit"
                                class="btn btn-primary btn-simple btn-round waves-effect text-right"><a>SAVE
                                    CHANGES</a></button>
                        </form>
                    </div>
                @endif
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-simple waves-effect "
                        data-dismiss="modal"><a>CLOSE</a></button>

                </div>



            </div>

        </div>
    </div>
    <div class="modal fade" id="updatedocinfo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">


                <div class="modal-header">
                    <h5>Update Document</h5>
                </div>
                <div class="modal-body" style="    border: 1px dashed;">
                    <form action="{{ url('update_my_doc_upload_file') }}" method="post" enctype="multipart/form-data"
                        class="form">
                        @csrf
                        <h6>Choose Filters</h6>
                        <div class="row clearfix">
                            @foreach ($doc_head as $head)
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label>{{ $head->name }}</label>
                                        @php
                                            $options = getDocHeadOptions($head->id);
                                        @endphp
                                        <select name="filter[]" id="update_doc_filter_{{ $head->id }}"
                                            class="form-control show-tick" data-live-search="true">
                                            <option value="" selected>--Select Option--</option>
                                            @foreach ($options as $opt)
                                                <option value="{{ $head->id }}=>{{ $opt->id }}">
                                                    {{ $opt->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <h6>Update File</h6>
                        <div class="row clearfix">

                            <div class="col-lg-3 col-md-3 col-sm-4 ">
                                <label>File Name<sup>*</sup></label><br>
                                <div class="form-group">
                                    <input type="hidden" name="id" id="update_doc_id" />

                                    <input type="text" required id="update_doc_name" class="form-control"
                                        name="name" placeholder="Enter File Name">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-4 ">
                                <label>Date<sup>*</sup></label><br>
                                <div class="form-group">
                                    <input type="date" required id="update_doc_date" class="form-control"
                                        name="date">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 ">
                                <label>Particular</label><br>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="update_doc_particular"
                                        name="particular" placeholder="Enter Particular">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-4 ">
                                <label>Remark</label><br>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="update_doc_remark" name="remark"
                                        placeholder="Enter Remark">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-4">
                                <label>Choose File <sub>Choose File If You Want To Update Attachment.</sub></label><br>
                                <div class="form-group">
                                    <input type="file"  class="form-control" id="update_doc_img"
                                        name="img">
                                </div>
                            </div>

                        </div>

                        <button style="    float: right;" type="submit"
                            class="btn btn-primary btn-simple btn-round waves-effect text-right"><a>SAVE
                                CHANGES</a></button>
                    </form>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-simple waves-effect "
                        data-dismiss="modal"><a>CLOSE</a></button>

                </div>



            </div>

        </div>
    </div>
    {{-- upload file data end --}}
    @if (checkmodulepermission(11, 'can_add') == 1)
        <div class="modal fade" id="newDocumenthead" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <form action="{{ url('/adddochead') }}" method="post" class="form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title">Add New Head</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">Name</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <input type="text" id="Name" required class="form-control"
                                            name="name" placeholder="Enter the Document Head Name">
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
    @if (checkmodulepermission(11, 'can_edit') == 1)
        <div class="modal fade" id="updatedochead" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <form action="{{ url('/updatedochead') }}" method="post" class="form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title">Update Document Head</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">Name</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="update_doc_head_id" />
                                        <input type="text" id="update_doc_head_name" required class="form-control"
                                            name="name" placeholder="Enter the Document Head Name">
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

    @if (checkmodulepermission(11, 'can_edit') == 1)
        <div class="modal fade" id="updatedocheadoption" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <form action="{{ url('/updatedocheadoption') }}" method="post" class="form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="title">Update Document Head Option</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                    <label for="Name">Name</label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="update_doc_head_option_id" />
                                        <input type="text" id="update_doc_head_option_name" required
                                            class="form-control" name="name"
                                            placeholder="Enter the Document Head Name">
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
    <div class="modal fade" id="viewHeadOptionsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">


                <div class="modal-header">
                    <h5>Manage Head Option</h5>


                </div>
                <h4 style="display: flex;">Head - <div id="headOptionsHeadname"></div>
                </h4>
                @if (checkmodulepermission(11, 'can_add') == 1)
                    <div class="modal-body" style="    border: 1px dashed;">
                        <form action="{{ url('adddocheadoption') }}" method="post" class="form">
                            @csrf
                            <h4 class="title">Add New Option</h4>
                            <div class="row clearfix">

                                <div class="col-lg-4 col-md-4 col-sm-4 ">
                                    <label>Option Head</label>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="hidden" name="head_id" id="options_head_id" />
                                        <input type="text" required class="form-control" name="name[]"
                                            placeholder="Enter the Option Name">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 text-right">
                                    <div class="form-group">
                                        <button type="button" id="addrow"
                                            class="btn btn-primary btn-simple btn-round waves-effect">
                                            <i class='zmdi zmdi-plus' style='color: white;'></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div id="additional-rows"></div>
                            <button type="submit" class="btn btn-primary btn-simple btn-round waves-effect"
                                style="float: inline-end;"><a>SAVE
                                    CHANGES</a></button>
                        </form>
                    </div>
                @endif
                <h4 class="title">Options List</h4>


                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card product_item_list">
                            <div class="body table-responsive">
                                <table class="table table-hover m-b-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th data-breakpoints="sm xs md">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="head_options_table_data">


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" style="align-self: self-end;">
                    <div class="row clearfix"> <button type="button"
                            class="btn btn-primary btn-simple waves-effect text-end"
                            data-dismiss="modal"><a>CLOSE</a></button>

                    </div>
                </div>



            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function openFilterContainer() {
            if (document.getElementById('doc_filter_container').style.display == 'block') {
                document.getElementById('doc_filter_container').style.display = 'none';
                document.getElementById('doc-head-lg-row').style.display = 'flex';
            } else {

                document.getElementById('doc_filter_container').style.display = 'block';
                document.getElementById('doc-head-lg-row').style.display = 'none';
            }
        }

        function loadPreview(path, name) {

            var origin_path = "{{ url('/images/app_images') }}" + "/" + path;

            var dataDisplayimg = document.getElementById('data-display-image');
            var dataDisplaypdf = document.getElementById('data-display-pdf');
            var dataDisplayDownload = document.getElementById('data-display-download');
            var dataDisplayOpen = document.getElementById('data-display-open');
            var datatDisplayPath = document.getElementById('data-display-path');
            var docinfo = document.getElementById('doc-info');
            docinfo.innerHTML = "";
            datatDisplayPath.value = path;

            var dataDiaplayErr = document.getElementById('data-display-err');
            document.getElementById('data-diaplay-name').innerHTML = name;
            dataDisplayimg.style.display = 'none';
            dataDisplaypdf.style.display = 'none';
            dataDiaplayErr.style.display = 'none';
            dataDisplayOpen.href = origin_path;
            dataDisplayDownload.href = origin_path;
            dataDisplayDownload.download = name;
            var ext = checkFileTypeByExtension(path);
            if (ext == 'image') {
                dataDisplayimg.style.display = 'block';

                dataDisplayimg.src = origin_path;

            } else if (ext == 'pdf') {
                dataDisplaypdf.style.display = 'block';

                dataDisplaypdf.src = origin_path + "#toolbar=0";

            } else {
                dataDiaplayErr.style.display = 'block';
                dataDiaplayErr.innerHTML = 'Unable To Load File Preview';

            }

        }

        function fetchlinkData() {

            var datatDisplayPath = document.getElementById('data-display-path');
            var docinfo = document.getElementById('doc-info');
            docinfo.innerHTML = "";
            var path = "images/app_images/" + datatDisplayPath.value;
            var paths = path.split("/");
            var table = paths[3];
            $.ajax({
                url: "{{ url('/fetchLinkedData') }}" + "?table=" + table + "&path=" + path,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {

                    if (res.status_code == '200') {
                        var data = res.data;
                        html = '';
                        html += '<div class="row m-5" style="border:1px solid black;">';
                        for (var key in data) {
                            html +=
                                '<div class="col-lg-4 col-md-4 col-sm-4 col-4" style="border:1px solid black;"><b>' +
                                key + ' : </b>' + data[key] + '</div>';
                        }
                        html += '</div>';
                        docinfo.innerHTML = html;
                    } else {
                        docinfo.style.textAlignLast = 'center';
                        docinfo.innerHTML =
                            "<span style='color:red;text-align:center;'>Document Record Not Found</span>";
                    }

                }
            });

        }

        function getDocsByHeadId(id) {

            const elements = document.querySelectorAll('.doc-head-sm');

            elements.forEach(element => {
                element.classList.remove('active');
            });
            document.getElementById('doc_filter_container').style.display = 'none';
            document.getElementById('doc-head-lg-row').style.display = 'flex';

            document.getElementById('mydocslist').innerHTML = '';

            var table = $('#myDocDatatable').DataTable();
            table.clear();
            $.ajax({
                url: "{{ url('/getDocListByHeadId') }}" + "?id=" + id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    html = '';
                    count = 1;

                    var newData = [];
                    if (res.length > 0) {
                        res.forEach((element) => {
                            doc_path = element['path'];
                            doc_id = element['id'];
                            var newDat = [count, element['name'], element['date'], element[
                                    'particular'],
                                ' <button style="all:unset;" onclick="openImage(`' + doc_path +
                            '`)" target="_blank" role="button"><i class="zmdi zmdi-attachment-alt"></i></button>&nbsp;',
                                element['remark'], element['filter'],
                                (("{{ $edit_perm }}" == "1") ?
                                    '<button title="Edit" type="button" data-info=\'' + JSON
                                    .stringify(element) +
                                    '\' onclick="editmydoc(this)" style="all:unset;"><i class="zmdi zmdi-edit"></i> </button> &nbsp;' :
                                    '') + (("{{ $delete_perm }}" == "1") ?
                                    '<button title="Delete" onclick="deleteDoc(`' + doc_id +
                                '`)" style="all:unset"><i class="zmdi zmdi-delete"></i> </button>' :
                                    '')
                            ];
                            newData.push(newDat);
                            count++;
                            // html += '<tr><td>' + count + '</td><td>' + element['name'] +
                            //     '</td><td> <a style="all:unset;" href="" target="_blank" role="button"><i class="zmdi zmdi-attachment"></i></a></td></tr>'
                        });
                        table.rows.add(newData);
                    }
                    table.draw();
                    document.getElementById('doc-head-sm-' + id).classList.add('active');
                    // document.getElementById('mydocslist').innerHTML = html;

                }
            });
        }

        function openImage(path) {
            var link = "{{ url('/') . '/' }}" + path;
            window.open(link, "_blank");

        }

        function searchDocByFilters() {

            const selects = document.querySelectorAll('select.filter-select-search');
            const elements = document.querySelectorAll('.doc-head-sm');
            document.getElementById('mydocslist').innerHTML = '';
            elements.forEach(element => {
                element.classList.remove('active');
            });
            var table = $('#myDocDatatable').DataTable();
            table.clear();
            var values = Array.from(selects).map(select => select.value);
            values = values.filter(value => value !== '');
            console.log(JSON.stringify(values));
            if (values.length > 0) {
                $.ajax({
                    url: "{{ url('/api/searchDocByFilter') }}",
                    type: 'POST',
                    data: {
                        'filters': JSON.stringify(values),
                        'conn': "{{ session()->get('comp_db_conn_name') }}"
                    },
                    dataType: 'json', // added data type
                    success: function(res) {
                        html = '';
                        count = 1;
                        console.log(res);

                        var newData = [];
                        if (res.length > 0) {
                            res.forEach((element) => {
                                var doc_path = element['path'];
                                var doc_id = element['id'];
                                var newDat = [count, element['name'], element['date'], element[
                                        'particular'],
                                    ' <button style="all:unset;" onclick="openImage(`' + doc_path +
                                '`)" target="_blank" role="button"><i class="zmdi zmdi-attachment-alt"></i></button>&nbsp;',
                                    element['remark'],
                                    element['filter'],


                                    (("{{ $edit_perm }}" == "1") ?
                                        '<button title="Edit" type="button" data-info=\'' + JSON
                                        .stringify(element) +
                                        '\' onclick="editmydoc(this)" style="all:unset;"><i class="zmdi zmdi-edit"></i> </button> &nbsp;' :
                                        '') + (("{{ $delete_perm }}" == "1") ?
                                        '<button title="Delete" onclick="deleteDoc(`' + doc_id +
                                    '`)" style="all:unset"><i class="zmdi zmdi-delete"></i> </button>' :
                                        '')
                                ];

                                newData.push(newDat);
                                count++;
                                // html += '<tr><td>' + count + '</td><td>' + element['name'] +
                                //     '</td><td> <a style="all:unset;" href="" target="_blank" role="button"><i class="zmdi zmdi-attachment"></i></a></td></tr>'
                            });
                            table.rows.add(newData);
                        }
                        table.draw();
                        // document.getElementById('mydocslist').innerHTML = html;

                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            } else {
                Swal.fire({
                    title: 'Oops!',
                    text: "Please Select Atleast One Filter!",
                    icon: 'warning',
                    toast: true,
                    position: 'center',
                    timer: 5000,
                    timerProgressBar: true,
                    confirmButtonColor: '#eda61a',
                    confirmButtonText: 'OK',
                    customClass: {
                        container: 'model-width-450px'
                    },
                });
            }
        }

        function checkFileTypeByExtension(filePath) {
            const extension = filePath.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(extension)) {
                return 'image';
            } else if (extension === 'pdf') {
                return 'pdf';
            } else {
                return 'other';
            }
        }



        $(document).ready(function() {
            $('#addrow').click(function() {
                var newRow = `<div class="row clearfix new-row">
                                    <div class="col-lg-4 col-md-4 col-sm-4">   
                                    <label>Option Head</label>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                     <div class="form-group">

                                        <input type="text"  required class="form-control" name="name[]"
                                        placeholder="Enter the Option Name">
                                    </div>
                               </div>


                                <div class="col-lg-2 col-md-2 col-sm-2 text-right">
                                    <button type="button" class="btn btn-primary btn-simple btn-round waves-effect remove-row"><i class='zmdi zmdi-minus' style='color: white;'></i></button>
                                </div>
                            </div>`;
                $('#additional-rows').append(newRow);
            });

            $('#docrow').click(function() {
                var newRow =
                    ` <div class="row clearfix new-doc-row">
                    <div class="col-lg-3 col-md-3 col-sm-4 ">
                                    <label>File Name<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <input type="text" required class="form-control" name="name[]"
                                            placeholder="Enter File Name">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-4 ">
                                    <label>Date<sup>*</sup></label><br>
                                    <div class="form-group">
                                        <input type="date" required class="form-control" name="date[]">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-4 ">
                                    <label>Particular</label><br>
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="particular[]"
                                            placeholder="Enter Particular">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-4 ">
                                    <label>Remark</label><br>
                                    <div class="form-group">
                                        <input type="text"  class="form-control" name="remark[]"
                                            placeholder="Enter Remark">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-4">
                                    <label>Choose File</label><br>
                                    <div class="form-group">
                                        <input type="file" required class="form-control" name="img[]">
                                    </div>
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-2 text-right">
                                    <div class="form-group">
                                                                            <button type="button" class="btn btn-primary btn-simple btn-round waves-effect remove-doc-row"><i class='zmdi zmdi-minus' style='color: white;'></i></button>

                                    </div>

                                </div>
                            </div>`;
                $('#additional-docrow').append(newRow);
            });

            // Event delegation to handle click event for dynamically added remove buttons
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.new-row').remove();
            });
            $(document).on('click', '.remove-doc-row', function() {
                $(this).closest('.new-doc-row').remove();
            });
        });

        function editHead(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Head ?",
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
                    $('#update_doc_head_name').val(name);

                    $('#update_doc_head_id').val(id);

                    $('#updatedochead').modal('show');

                }
            });
        }


        function editmydoc(button) {

            const data = button.getAttribute('data-info');
            const parsedData = JSON.parse(data);
            const filtersdata = JSON.parse(parsedData['original_filter']);
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Document?",
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
                    $('#update_doc_name').val(parsedData['name']);
                    $('#update_doc_id').val(parsedData['id']);
                    $('#update_doc_date').val(parsedData['date']);
                    $('#update_doc_particular').val(parsedData['particular']);
                    $('#update_doc_remark').val(parsedData['remark']);

                    filtersdata.forEach((item, index) => {
                        var selectedvalue = item['head_id'] + "=>" + item['option_id'];
                        $('#update_doc_filter_' + item['head_id']).val(selectedvalue);
                        $('#update_doc_filter_' + item['head_id']).select().trigger('change');

                    });

                    $('#updatedocinfo').modal('show');

                }
            });
        }

        function editHeadOption(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Edit This Head ?",
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
                    $('#update_doc_head_option_name').val(name);

                    $('#update_doc_head_option_id').val(id);
                    $('#viewHeadOptionsModal').modal('hide');

                    $('#updatedocheadoption').modal('show');

                }
            });
        }

        function deleteHead(id) {
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
                    var url = "{{ url('/delete_doc_head/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function deleteDoc(id) {
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
                    var url = "{{ url('/deleteDoc/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function approveDoc(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this document!",
                icon: 'warning',
                showCancelButton: true,
                toast: true,
                position: 'center',
                showConfirmButton: true,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#000000',
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel',
                customClass: {
                    container: 'model-width-450px'
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ url('/approveDoc/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function deleteHeadOption(id) {
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
                    var url = "{{ url('/delete_doc_head_option/?id=') }}" + id;
                    window.location.href = url;
                }
            });
        }

        function viewHeadOption(id, name, data) {

            $('#options_head_id').val(id);
            document.getElementById('headOptionsHeadname').innerHTML = name;

            var options = JSON.parse(data);
            var html = "";
            options.forEach(myFunction);

            function myFunction(item, index) {
                html += "<tr><td>" + (index + 1) + "</td><td>" + item['name'] +
                    "</td><td><button type='button' style='all:unset;' class='mx-2' onclick='editHeadOption(" + item['id'] +
                    ",`" + item['name'] +
                "`)' ><i class='zmdi zmdi-edit'></i></button><button class='mx-2' style='all:unset;' type='button' onclick='deleteHeadOption(" +
                    item['id'] + ")'><i class='zmdi zmdi-delete'></i></button></td></tr>";
            }
            document.getElementById("head_options_table_data").innerHTML = html;
            $('#viewHeadOptionsModal').modal('show');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carousel = document.querySelector('.doc-carousel');
            const items = document.querySelectorAll('.doc-carousel-item');

            // Function to handle horizontal scrolling
            const handleScroll = (event) => {
                event.preventDefault();
                carousel.scrollLeft += event.deltaY;
            };

            // Attach the scroll handler to the carousel container
            document.querySelector('.doc-carousel-container').addEventListener('wheel', handleScroll);

            // Function to update active item
            const updateActiveItem = (index) => {
                items.forEach((item, idx) => {
                    if (idx === index) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            };

            // Add click event to each carousel item
            items.forEach((item, index) => {
                item.addEventListener('click', () => {
                    updateActiveItem(index);
                });
            });

            // Implement mouse drag to scroll
            let isDragging = false;
            let startX, scrollLeft;

            carousel.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.pageX - carousel.offsetLeft;
                scrollLeft = carousel.scrollLeft;
                carousel.classList.add('dragging');
            });

            carousel.addEventListener('mouseleave', () => {
                isDragging = false;
                carousel.classList.remove('dragging');
            });

            carousel.addEventListener('mouseup', () => {
                isDragging = false;
                carousel.classList.remove('dragging');
            });

            carousel.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const x = e.pageX - carousel.offsetLeft;
                const walk = (x - startX) * 2; // Scroll speed
                carousel.scrollLeft = scrollLeft - walk;
            });
        });
    </script>
@endsection

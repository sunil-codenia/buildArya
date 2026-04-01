<div role="tabpanel" class="tab-pane active" id="my_file">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="row clearfix">
            <br>
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Document</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                    </h2>
                    <ul class="header-dropdown">
                        <li>
                            @if (checkmodulepermission(11, 'can_view') == 1)
                                <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                    onclick="openFilterContainer()" type="button">
                                    <i class="zmdi zmdi-search-in-file" style="color: white;"></i>
                                </button>
                            @endif
                        </li>
                        <li>
                            @if (checkmodulepermission(11, 'can_add') == 1)
                                <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                    data-toggle="modal" data-target="#new" type="button">
                                    <i class="zmdi zmdi-cloud-upload" style="color: white;"></i>
                                </button>
                            @endif
                        </li>
                    </ul>
                </div>
                <hr>
                @if (checkmodulepermission(11, 'can_view') == 1)
                    <div class="row clearfix">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card project_list" id="doc_filter_container"
                                style="border:1px dashed;   display:none; padding: 10px;">
                                <h5>Filters</h5>


                                <div class="row clearfix">

                                    <div class="col-12">
                                        <div class="row clearfix">
                                            @foreach ($doc_head as $head)
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                                    <div class="form-group">
                                                        <label>{{ $head->name }}</label>
                                                        @php
                                                            $options = getDocHeadOptions($head->id);
                                                        @endphp
                                                        <select name="filter[]"
                                                            class="form-control show-tick filter-select-search"
                                                            data-live-search="true">
                                                            <option value="" selected>--Select Option--</option>
                                                            @foreach ($options as $opt)
                                                                <option
                                                                    value="{{ $head->id }}=>{{ $opt->id }}">
                                                                    {{ $opt->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-10 col-md-10 col-sm-9">
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-3">
                                        <div class="form-group">
                                            <button type="button" onclick="searchDocByFilters()"
                                                class="btn btn-primary btn-simple btn-round waves-effect form-control"><a>Search</a></button>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                @endif
                @if (checkmodulepermission(11, 'can_view') == 1)
                    <div class="row" id="doc-head-lg-row">
                        @foreach ($doc_head as $head)
                            <div class="col-lg-2 col-md-2 col-sm-3" onclick="getDocsByHeadId('{{ $head->id }}')">
                                <div class="card border rounded-lg shadow-sm p-4 "
                                    style="height:75px !important;padding: 10px !important;align-content: center;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <img src="{{ asset('images/folder.png') }}" alt="folder icon" class="me-3"
                                                height="25" />
                                            <br>

                                            <b class="card-title mb-1">{{ $head->name }}</b>
                                        </div>
                                        <div>
                                            <p class="card-text mb-0">{{ getNoOfFilesByHeadId($head->id) }} Files</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="row">

                    <div class="doc-carousel-container">
                        <div class="doc-carousel">

                            <div class="doc-carousel-item active doc-head-sm " id="doc-head-sm-0"
                                onclick="getDocsByHeadId('0')"> <img src="{{ asset('images/folder.png') }}"
                                    alt="folder icon" class="me-3" height="10" /> All</div>
                            @foreach ($doc_head as $head)
                                <div onclick="getDocsByHeadId('{{ $head->id }}')"
                                    id="doc-head-sm-{{ $head->id }}" class="doc-carousel-item doc-head-sm"> <img
                                        src="{{ asset('images/folder.png') }}" alt="folder icon" class="me-3"
                                        height="10" /> {{ $head->name }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card project_list">

            <div class="body">
                @if (checkmodulepermission(11, 'can_view') == 1)
                    <div class="table-responsive">
                        <table id="myDocDatatable"  class="doc_table table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Particular</th>
                                    <th>Remark</th>
                                    <th>Document</th>
                                    <th>Filters </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="mydocslist">
                                @php $count=1;
                         
                                @endphp
                                @foreach ($docs as $doc)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $doc->name }}</td>
                                        <td>{{ $doc->date }}</td>
                                        <td>{{ $doc->particular }}</td>
                                        <td>{{ $doc->remark }}</td>
                                        <td>                                            <a style="all:unset;" href="{{ url('/') . '/' . $doc->path }}" target="_blank"
                                            role="button"><i class="zmdi zmdi-attachment-alt"></i></a> &nbsp;</td>
                                        
                                        <td>{{ $doc->filter }}</td>
                                        <td>

                                            @if ($edit_perm)
                                                <button title="Edit" type="button" data-info='{{json_encode($doc)}}'
                                                    onclick="editmydoc(this)" style="all:unset;"><i
                                                        class="zmdi zmdi-edit"></i>
                                                </button> &nbsp;
                                            @endif


                                            @if ($delete_perm)
                                                <button title="Delete" onclick="deleteDoc('{{ $doc->id }}')"
                                                    style="all:unset"><i class="zmdi zmdi-delete"></i> </button>
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

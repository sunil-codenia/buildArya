<div role="tabpanel" class="tab-pane" id="doc_head">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="row clearfix">

            <br>
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Document Head</strong> List&nbsp;<i
                            class="zmdi zmdi-info info-hover"></i>

                    </h2>
                    <ul class="header-dropdown">
                        <li>
                            @if (checkmodulepermission(11, 'can_add') == 1)
                                <button
                                    class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10"
                                    data-toggle="modal" data-target="#newDocumenthead"
                                    type="button">
                                    <i class="zmdi zmdi-plus" style="color: white;"></i>
                                </button>
                            @endif
                        </li>
                    </ul>
                </div>
                {{-- table start --}}
                @if (checkmodulepermission(11, 'can_view') == 1)
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="card product_item_list">
                                <div class="body table-responsive">
                                    <table class="table table-hover m-b-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th data-breakpoints="xs md">Option</th>
                                                <th data-breakpoints="sm xs md">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($doc_head as $head)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $head->name }}</td>
                                                    <td>{{ getDocHeadOptions($head->id, true) }}
                                                    </td>
                                                    <td>
                                                        <button type="button" style="all:unset;"
                                                            onclick="viewHeadOption({{ $head->id }},`{{$head->name}}`, `{{ json_encode(getDocHeadOptions($head->id)) }}`)"><i
                                                                class="zmdi zmdi-eye"></i></button>
                                                        @if (checkmodulepermission(11, 'can_edit') == 1)
                                                            <button
                                                                onclick="editHead('{{ $head->id }}', '{{ $head->name }}')"
                                                                type="button" style="all:unset;"><i
                                                                    class="zmdi zmdi-edit mx-3"></i></button>
                                                        @endif
                                                        @if (checkmodulepermission(11, 'can_delete') == 1)
                                                            <button type="button" style="all:unset;"
                                                                onclick="deleteHead('{{ $head->id }}')"><i
                                                                    class="zmdi zmdi-delete "></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                {{-- tabel end --}}

            </div>
        </div>
    </div>
</div>
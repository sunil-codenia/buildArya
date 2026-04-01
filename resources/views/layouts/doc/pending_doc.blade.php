<div role="tabpanel" class="tab-pane " id="pending_files">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="row clearfix">
            <br>
            <div class="card project_list">
                <div class="header">
                    <h2><strong>Pending Document</strong> List&nbsp;<i class="zmdi zmdi-info info-hover"></i>
                    </h2>
                </div>
                <hr>
            </div>
        </div>

        <div class="card project_list">

            <div class="body">
                @if (checkmodulepermission(11, 'can_view') == 1)
                    <div class="table-responsive">
                        <table class=" doc_table table table-hover" style="width: 100%;">
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
                            <tbody>
                                @php
                                $count = 1;

                                @endphp
                                @foreach ($pending_docs as $doc)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{ $doc->name }}</td>
                                        <td>{{ $doc->date }}</td>
                                        <td>{{ $doc->particular }}</td>
                                        <td>{{ $doc->remark }}</td>
                                        <td> <a style="all:unset;" href="{{ url('/') . '/' . $doc->path }}"
                                                target="_blank" role="button"><i
                                                    class="zmdi zmdi-attachment-alt"></i></a> &nbsp;</td>

                                        <td>{{ $doc->filter }}</td>
                                        <td>

                                            @if ($edit_perm)
                                                <button title="Edit" type="button"
                                                    data-info='{{ json_encode($doc) }}' onclick="editmydoc(this)"
                                                    style="all:unset;"><i class="zmdi zmdi-edit"></i>
                                                </button> &nbsp;
                                            @endif
                                            @if ($certify_perm)
                                                <button title="Edit" type="button"
                                                    data-info='{{ $doc->id }}' onclick="approveDoc({{$doc->id}})"
                                                    style="all:unset;"><i class="zmdi zmdi-check-circle"></i>
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

<div role="tabpanel" class="tab-pane " id="system_doc">

    <div class="row clearfix">
        <div class="col-lg-6 col-md-12" style="border: 1px solid;">
            <div class="card">
                <div class="header">
                    <h2><strong>Document</strong> List </h2>
                </div>
                <div class="body">
                    <ul style="list-style: none; padding: 0 10px; margin: 0; font-size:20px;">
                        @foreach ($directories as $directory)
                            @if ($directory['type'] === 'directory')
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle toggled" data-content ="name">
                                        <i class="zmdi zmdi-folder"></i> {{ $directory['name'] }}
                                    </a>
                                    @if (!empty($directory['children']))
                                        <!-- Recursively render child directories -->
                                        <ul style="list-style: none; padding-left: 20px;">
                                            @foreach ($directory['children'] as $child)
                                                @if ($child['type'] === 'directory')
                                                    <li>
                                                        <a href="javascript:void(0);" class="menu-toggle toggled">
                                                            <i class="zmdi zmdi-folder"></i> {{ $child['name'] }}
                                                        </a>
                                                        @if (!empty($child['children']))
                                                            <!-- Recursive rendering for subdirectories -->
                                                            @include('layouts.doc.directory_tree', [
                                                                'directories' => $child['children'],
                                                            ])
                                                        @endif
                                                    </li>
                                                @else
                                                    <li>
                                                        @php
                                                        $path = $child['path'];
                                                            $name = $child['name'];
                                                        @endphp
                                                        <a onclick="loadPreview('{{ $path }}', '{{ $name }}')"
                                                            class="menu-toggle">
                                                            <i class="zmdi zmdi-file"></i> {{ $child['name'] }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @else
                                <li>
                                    @php
                                    $path = $directory['path'];
                                        $name = $directory['name'];
                                    @endphp
                                    <a onclick="loadPreview('{{ $path }}','{{ $name }}')"
                                        class="menu-toggle">
                                        <i class="zmdi zmdi-file"></i> {{ $directory['name'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>


            </div>
        </div>

        <div class="col-lg-6 col-md-12" style="border: 1px solid;">
            <div class="card">
                <div class="header">
                    <h2><strong>Document</strong> Preview </h2>
                    <ul class="header-dropdown">
                        <li class="mx-2">
                           <input type="hidden" id="data-display-path"/>
                            <button style="all:unset;" onclick="fetchlinkData()"  id="data-display-link" role="button"><i class="zmdi zmdi-info"></i></button>
                        </li>
                        <li class="mx-2">                          
                            <a style="all:unset;" href=""  download="" target="_blank" id="data-display-download" role="button"><i class="zmdi zmdi-download"></i></a>
                        </li>                        
                        <li class="mx-2">
                            <a style="all:unset;" target="_blank" id="data-display-open" role="button" href=""><i class="material-icons">launch</i></a>
                        </li>
                    </ul>
                </div>
                <div class="body" >
                    <div class="content" >
                        <h4  class="p-5">File Name : <span id="data-diaplay-name"></span></h4>
                        <div id="doc-info">
                            
                        </div>
                        <span id="data-display-err" class="m-b-10" style="color:red; display:none; text-align: -webkit-center;    font-weight: bold;"></span>
                        <img id="data-display-image" width="100%" height="500px"
                            style="display: none;" />
                        <iframe id="data-display-pdf" width="100%" height="800px" toolbar="0"
                            style="display: none;"></iframe>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
 
</div>

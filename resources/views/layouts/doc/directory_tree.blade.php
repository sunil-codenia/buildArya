<!-- resources/views/layouts/doc/directory_tree.blade.php -->
<ul style="list-style: none; padding-left: 20px;">
    @foreach($directories as $directory)
        @if($directory['type'] === 'directory')
            <li>
                <a href="javascript:void(0);" class="menu-toggle toggled"> 
                    <i class="zmdi zmdi-folder"></i> {{ $directory['name'] }}
                </a>
                @if(!empty($directory['children']))
                    <!-- Recursive rendering for subdirectories -->
                    @include('layouts.doc.directory_tree', ['directories' => $directory['children']])
                @endif
            </li>
        @else
            <li>
                @php 
                $path = $directory['path'];
                $name = $directory['name'];
                @endphp
                <a onclick="loadPreview('{{$path}}','{{$name}}')" class="menu-toggle">
                    <i class="zmdi zmdi-file"></i> {{ $directory['name'] }}
                </a>
            </li>
        @endif
    @endforeach
</ul>

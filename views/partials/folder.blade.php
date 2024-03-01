<li><a href="#" data-url="{{ $folder['url'] }}"><i class="fa-regular fa-folder"></i> {{ ucfirst($folder['name']) }}</a>
    @if(!empty($folder['subDirectories']))
        <ul>
            @foreach($folder['subDirectories'] as $subDirectory)
                @include('partials.folder', ['folder' => $subDirectory])
            @endforeach
        </ul>
    @endif
</li>
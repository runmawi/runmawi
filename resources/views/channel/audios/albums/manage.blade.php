<ol>

    @foreach($childs as $child)

        <li class="dd-item">

           <div class="dd-handle"> {{ $child->albumname }} </div>
           <div class="actions"><a href="/cpp/audios/albums/edit/{{ $child->id }}" class="edit">Edit</a> <a href="/admin/audios/albums/delete/{{ $child->id }}" class="delete">Delete</a></div>
            @if(count($child->childs))

                @include('admin.audios.albums.manageChild',['childs' => $child->childs])

            @endif

        </li>

    @endforeach

</ol>
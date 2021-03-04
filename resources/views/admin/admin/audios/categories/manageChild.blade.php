<ol>

    @foreach($childs as $child)

        <li class="dd-item">

           <div class="dd-handle"> {{ $child->name }} </div>
           <div class="actions"><a href="/flicknexs/admin/audios/categories/edit/{{ $child->id }}" class="edit">Edit</a> <a href="/flicknexs/admin/audios/categories/delete/{{ $child->id }}" class="delete">Delete</a></div>
            @if(count($child->childs))

                @include('admin.audios.categories.manageChild',['childs' => $child->childs])

            @endif

        </li>

    @endforeach

</ol>
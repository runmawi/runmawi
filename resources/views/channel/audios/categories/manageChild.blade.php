<ol>

    @foreach($childs as $child)

        <li class="dd-item">

           <div class="dd-handle"> {{ $child->name }} </div>
           <div class="actions">
            <a class="iq-bg-success" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit" href="{{ URL::to('admin/audios/categories/edit/') }}/{{$child->id}}"><i class="ri-pencil-line"></i></a>

            <a class="iq-bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="{{ URL::to('admin/audios/categories/delete/') }}/{{$child->id}}"><i class="ri-delete-bin-line"></i></a>

        </div>
            @if(count($child->childs))

                @include('admin.audios.categories.manageChild',['childs' => $child->childs])

            @endif

        </li>

    @endforeach

</ol>
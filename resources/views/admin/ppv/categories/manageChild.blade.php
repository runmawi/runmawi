<ol>

    @foreach($childs as $child)

        <li class="dd-item">

           <div class="dd-handle"> {{ $child->name }} </div>
<!--
           <div class="actions"><a href="{{ URL::to('/').'/admin/ppv/categories/edit/'.$child->id }}" class="btn btn-black edit">Edit</a> <a href="{{ URL::to('/').'/admin/ppv/categories/delete/'.$child->id }}" class="btn btn-white delete">Delete</a></div>
            
            
-->
            @if(count($child->childs))

                @include('admin.videos.categories.manageChild',['childs' => $child->childs])

            @endif

        </li>

    @endforeach

</ol>
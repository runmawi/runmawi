{{-- Header --}}
@php include(public_path('themes/theme3/views/header.php')); @endphp

    <section>
        
            @forelse ($ModeratorUsers_list as  $key => $Moderator_user_list)
                <div class="div">
                    {{ $Moderator_user_list->username }}
                </div>
            @empty

            @endforelse
        
    </section>

{{-- Footer --}}
@php include(public_path('themes/theme3/views/footer.blade.php')); @endphp

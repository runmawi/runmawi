{{-- Header --}}
@php include(public_path('themes/theme5-nemisatv/views/header.php')); @endphp

    <section>
        
            @forelse ($ModeratorUsers_list as  $key => $Moderator_user_list)
                <div class="div">
                    {{ $Moderator_user_list->username }}
                </div>
            @empty

            @endforelse
        
    </section>

{{-- Footer --}}
@php include(public_path('themes/theme5-nemisatv/views/footer.blade.php')); @endphp

@php
    include public_path('themes/theme5-nemisha/views/header.php');
@endphp

<style>
    .profilcard{
        background-color: transparent;
    }
    .profilcard:hover{
        background-color: #ed1c24;
        border-radius: 10px;
        box-shadow: 1px 3px 4px rgba(0, 0, 0, 0.2);
        transition: transform 0.5s ease-in-out;
        transform: scale(1.02);
}
</style>

<div>
    <div class="row m-4" >
        @foreach ($userdata as $eachuserdata)
        <div class="col-4 profilcard"> 
            <a href="{{ route('profile.show', ['username' => $eachuserdata->username]) }}" >
            <div class="row p-2">
                <div>
                        <img class="rounded-circle img-fluid text-center mb-3 mt-4"
                                src="<?= $eachuserdata->avatar ? URL::to('/') . '/public/uploads/avatars/' . $eachuserdata->avatar : URL::to('/assets/img/placeholder.webp') ?>"  alt="profile-bg" style="height: 80px; width: 80px;">
                </div>
                <div class="col" style="padding-top: 40px;" >
                    <div>
                    <h6>{{$eachuserdata->username}}</h6>
                    </div>
                    <div class="py-2" >
                        @if($eachuserdata->subscribers_count == 0 )
                        <p style="color: white; font-size:18px;" >No Subscribers</p>
                        @elseif($eachuserdata->subscribers_count == 1 )
                        <p style="color: white; font-size:18px;" >1 Member Subscribed</p>
                        @else
                        <p style="color: white; font-size:18px;" >
                         <span class="subscriber-count"> {{ $eachuserdata->subscribers_count }} </span> Members Subscribed
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            </a>
        </div>
       @endforeach
    </div>
</div>


@php
include (public_path('themes/theme5-nemisha/views/footer.blade.php'))
@endphp
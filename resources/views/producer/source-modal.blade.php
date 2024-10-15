<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        
        <h3 class="header center">
            <a class="amber waves-effect waves-light btn modal-trigger" href="#modal">Choose item here &equiv;</a>
        </h3>

        <div id="modal" class="modal modal-fixed-footer">
            <div class="modal-content left">
                <div class="collection">
                    <a href="{{ route('producer.home')}}" class="collection-item">Summary </a>
                </div>

                <h6>Movies</h6>
                <p>
                    <div class="collection">
                        @foreach ($sources_data['video'] as $item)
                            <a class="collection-item" href="{{ route('producer.stats',['video', $item->id]) }}"> {{ @$item->title }}  </a>
                        @endforeach
                    </div>
                </p>

                <h6>Tv Shows (Series)</h6>
                <p>
                    @foreach ($sources_data['series'] as $item)
                        <div class="collection">
                            <a class="collection-item" href="{{ route('producer.stats',['series', $item->id]) }}"> {{ @$item->title }}  </a>
                            <br>
                        </div>
                    @endforeach
                </p>
                <hr>

                <h6>Livestream</h6>
                <p>
                    @foreach ($sources_data['livestream'] as $item)
                        <div class="collection">
                            <a class="collection-item" href="{{ route('producer.stats',['live_stream', $item->id]) }}"> {{ @$item->title }}  </a>
                            <br>
                        </div>
                    @endforeach
                </p>
                <hr>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
            </div>
        </div>
    </div>
</div>

<style>
    a.collection-item{font-size: 20px;}
    h6{font-size: 1.5rem;line-height: 150%;}
    a.modal-close.waves-effect.waves-green.btn-flat{font-size: 18px;}
</style>
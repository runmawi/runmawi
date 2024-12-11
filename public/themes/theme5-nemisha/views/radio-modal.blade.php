<style>
    .modal-content {
        border-radius: 10px;
        overflow: hidden;
    }

    .modal-body {
        max-height: 400px; /* Optional to limit modal size */
        overflow-y: auto;
        padding: 1.5rem;
        overflow-x: auto; /* Enable horizontal scroll */
    }

    .list-group {
        display: flex;
        flex-wrap: nowrap; /* Prevent wrapping of items */
        gap: 1rem; /* Optional: to add space between items */
        overflow-x: auto; /* Enable horizontal scroll */
        padding: 0;
    }

    .list-group-item {
        flex: 0 0 auto; /* Prevent items from shrinking or stretching */
        transition: box-shadow 0.3s ease;
        width: 250px; /* Optional: control the width of each item */
    }

    .list-group-item:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .hover-scale {
        transition: transform 0.3s ease-in-out;
    }

    .hover-scale:hover {
        transform: scale(1.1);
    }

</style>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background-color: #ED563C">
                <h4 class="modal-title" id="exampleModalLabel">Radio Station List</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mt-3">
                    <ul class="list-group">
                        <?php foreach ($Radio_station_lists as $list) { ?>
                        <li class="list-group-item bg-white mb-3 border-0 rounded shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="img-box">
                                    <a href="<?php echo URL::to('live/' . $list->slug); ?>">
                                        <img src="<?php echo URL::to('/') . '/public/uploads/images/' . $list->image; ?>"
                                            class="img-fluid w-100 h-50 rounded hover-scale">
                                    </a>
                                </div>
                                <div class="block-description ml-3 flex-grow-1">
                                    <h6 class="text-dark font-weight-bold">
                                        <?php echo __($list->title); ?>
                                    </h6>
                                    <div class="hover-buttons mt-2">
                                        <a href="<?php echo URL::to('live/' . $list->slug); ?>" aria-label="Radio-Station"
                                            class="btn btn-primary btn-sm px-3">
                                            <img class="ply mr-2"
                                                src="{{ url('/assets/img/default_play_buttons.svg') }}"
                                                alt="play" /> Play Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

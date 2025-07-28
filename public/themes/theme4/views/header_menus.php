<ul id="navbarList" class="navbar-nav top-colps">
    <?php  


    foreach ($header_top_position_menus as $menu) {

        if ( $menu->in_menu == "video" ) {  ?>

        <li class="nav-item dropdown menu-item d-flex align-items-center">
            <a class="nav-link dropdown-toggle justify-content-between" id="down-video" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                <?= $menu->name ?> <i class="fa fa-angle-down"></i>
            </a>

            <ul class="dropdown-menu primary_menu">
                <?php foreach ( $Parent_video_category as $category) : ?>
                    <?php if( !is_null($category) ): ?>
                    <li>
                        <a class="dropdown-item cont-item" href="<?= route('Parent_video_categories',$category->slug) ?>">
                            <?= $category->name;?>
                        </a>

                        <?php foreach ( $category->sub_video_category as $sub_video_category) : ?>
                            <?php if( !is_null($category) ): ?>
                                <ul class="submenu dropdown-menu">
                                <?php foreach ( $category->sub_video_category as $sub_video_category) : ?>
                                    <li>
                                        <a class="dropdown-item cont-item" href="<?= route('Parent_video_categories',$sub_video_category->slug)?>">
                                            <?= $sub_video_category->name;?>
                                        </a>
                                    </li>
                                <?php endforeach ; ?>
                                </ul>
                        <?php endif; endforeach ; ?>
                    </li>
                    <?php endif; ?>
                <?php endforeach ; ?>
            </ul>
                
        </li>

        <?php } elseif  ( $menu->in_menu == "movies") {  ?>

        <li class="nav-item  dskdflex menu-item">
            <a class="nav-link justify-content-between" id="dn" href="<?= URL::to($menu->url) ?>">
                <?= $menu->name ?>
            </a>
            <ul class="dropdown-menu categ-head">
                    <?php foreach ( $languages as $language): ?>
                    <li>
                        <a class="dropdown-item cont-item" href="<?= URL::to('language/'.$language->id.'/'.$language->name);?>">
                            <?= $language->name;?>
                        </a>
                    </li>
                    <?php endforeach; ?>
            </ul>
        </li>

        <?php } elseif ( $menu->in_menu == "live") { ?>

        <li class="nav-item dropdown menu-item d-flex align-items-center">
            <a class="nav-link dropdown-toggle justify-content-between" id="down-live" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                <?= $menu->name ?> <i class="fa fa-angle-down"></i>
            </a>

            <ul class="dropdown-menu primary_menu">
                <?php 
                    foreach ( $Parent_live_category as $category) :
                    if( !is_null($category) ): ?>
                        <li>
                            <a class="dropdown-item cont-item" href="<?= URL::to('live/category/'.$category->slug) ?>">
                                <?= $category->name;?>
                            </a>

                            <?php foreach ( $category->sub_live_category as $sub_live_category) : ?>
                                <?php if( !is_null($category) ): ?>
                                <ul class="submenu dropdown-menu">
                                    <?php foreach ( $category->sub_live_category as $sub_live_category) : ?>
                                        <li>
                                            <a class="dropdown-item cont-item" href="<?= URL::to('live/category/'.$sub_live_category->slug) ?>">
                                            <?= $sub_live_category->name;?>
                                            </a>
                                        </li>
                                    <?php endforeach ; ?>
                                </ul>
                            <?php endif; endforeach ; ?>
                        </li> <?php
                    endif; 
                    endforeach ; ?>
            </ul>
                
        </li>

        <?php } elseif ( $menu->in_menu == "audios") { ?>

        <li class="nav-item dropdown menu-item d-flex align-items-center">
            <a class="nav-link dropdown-toggle justify-content-between" id="down-audio" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                <?= $menu->name ?> <i class="fa fa-angle-down"></i>
            </a>

            <ul class="dropdown-menu primary_menu">
                <?php 
                    foreach ( $Parent_audios_category as $category) :
                    if( !is_null($category) ): ?>
                        <li>
                            <a class="dropdown-item cont-item" href="<?= URL::to('audio/'.$category->slug) ?>">
                                <?= $category->name;?>
                            </a>

                            <?php foreach ( $category->sub_audios_category as $sub_audios_category) : ?>
                                <?php if( !is_null($category) ): ?>
                                <ul class="submenu dropdown-menu">
                                    <?php foreach ( $category->sub_audios_category as $sub_audios_category) : ?>
                                        <li>
                                            <a class="dropdown-item cont-item" href="<?= URL::to('audio/'.$sub_audios_category->slug) ?>">
                                            <?= $sub_audios_category->name;?>
                                            </a>
                                        </li>
                                    <?php endforeach ; ?>
                                </ul>
                            <?php endif; endforeach ; ?>
                        </li> <?php
                    endif; 
                    endforeach ; ?>
            </ul>
                
        </li>

        <?php }elseif ( $menu->in_menu == "tv_show") { ?>
        
        <li class="nav-item active dskdflex menu-item ">

            <a href="<?php echo URL::to($menu->url)?>">
                    <?= ($menu->name); ?> <i class="fa fa-angle-down"></i>
            </a>

            <?php if(count($tv_shows_series) > 0 ){ ?>
                <ul class="dropdown-menu categ-head primary_menu">
                    <?php foreach ( $tv_shows_series->take(6) as $key => $tvshows_series): ?>
                    <li>
                        <?php if($key < 5): ?>
                        <a class="dropdown-item cont-item" href="<?php echo URL::to('play_series/'.$tvshows_series->slug );?>">
                                <?= $tvshows_series->title;?>
                        </a>
                        <?php else: ?>
                        <a class="dropdown-item cont-item text-primary" href="<?php echo URL::to('/series/list');?>">
                                <?php echo 'More...';?>
                        </a>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php } ?>
        </li>

        <?php }elseif ( $menu->in_menu == "series") { ?>
        
        <li class="nav-item dropdown menu-item d-flex align-items-center">
            <a class="nav-link dropdown-toggle justify-content-between" id="down-series" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                <?= $menu->name ?> <i class="fa fa-angle-down"></i>
            </a>

            <ul class="dropdown-menu primary_menu">
                <?php 
                    foreach ( $Parent_series_category as $category) :
                    if( !is_null($category) ): ?>
                        <li>
                            <a class="dropdown-item cont-item" href="<?= URL::to('series/category/'.$category->slug) ?>">
                                <?= $category->name;?>
                            </a>

                            <?php foreach ( $category->sub_series_category as $sub_series_category) : ?>
                                <?php if( !is_null($category) ): ?>
                                <ul class="submenu dropdown-menu">
                                    <?php foreach ( $category->sub_series_category as $sub_series_category) : ?>
                                        <li>
                                            <a class="dropdown-item cont-item" href="<?= URL::to('series/category/'.$category->slug) ?>">
                                            <?= $sub_series_category->name;?>
                                            </a>
                                        </li>
                                    <?php endforeach ; ?>
                                </ul>
                            <?php endif; endforeach ; ?>
                        </li> <?php
                    endif; 
                    endforeach ; ?>
            </ul>
                
        </li>

        <?php }elseif ( $menu->in_menu == "networks") { ?>

        <li class="nav-item dropdown menu-item d-flex align-items-center">
                <a class="nav-link dropdown-toggle justify-content-between" id="down-network" href="<?= URL::to($menu->url) ?>" data-bs-toggle="dropdown">
                    <?= $menu->name ?> <i class="fa fa-angle-down"></i>
                </a>

                <ul class="dropdown-menu primary_menu">
                    <?php 
                    foreach ( $Parent_Series_Networks as $category) :
                        if( !is_null($category) ): ?>
                            <li>
                                <a class="dropdown-item cont-item" href="<?= route('Specific_Series_Networks',$category->slug) ?>">
                                <?= $category->name;?>
                                </a>

                                <?php foreach ( $category->Sub_Series_Networks as $Sub_Series_Networks) : ?>
                                <?php if( !is_null($category) ): ?>
                                    <ul class="submenu dropdown-menu">
                                        <?php foreach ( $category->Sub_Series_Networks as $Sub_Series_Networks) : ?>
                                            <li>
                                            <a class="dropdown-item cont-item" href="<?= route('Specific_Series_Networks',$category->slug) ?>">
                                                <?= $Sub_Series_Networks->name;?>
                                            </a>
                                            </li>
                                        <?php endforeach ; ?>
                                    </ul>
                                <?php endif; endforeach ; ?>
                            </li> <?php
                        endif; 
                    endforeach ; ?>
                </ul>
                    
            </li>

        <?php } else { ?>

        <li class="menu-item">
            <a href="<?php if($menu->select_url == "add_Site_url"){ echo URL::to( $menu->url ); }elseif($menu->select_url == "add_Custom_url"){ echo $menu->custom_url;  }?>">
                    <?php echo __($menu->name);?>
            </a>
        </li>

        <?php  } 
    } 
    ?>
</ul>
                        

@php
    include public_path('themes/default/views/header.php');
@endphp

<style>
    .detailsBanner {
        width: 100%;
        background-color: var(--black);
        padding-top: 100px;
        margin-bottom: 50px;
    }

    .detailsBanner .backdrop-img {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        opacity: .1;
        overflow: hidden;
    }

    .detailsBanner .backdrop-img .lazy-load-image-background {
        width: 100%;
        height: 100%;
    }

    .lazy-load-image-background.blur.lazy-load-image-loaded {
        filter: blur(0);
        transition: filter .3s;
    }

    .lazy-load-image-background.blur {
        filter: blur(15px);
    }

    .detailsBanner .backdrop-img .lazy-load-image-background img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .lazy-load-image-background.blur.lazy-load-image-loaded>img {
        opacity: 1;
        transition: opacity .3s;
    }

    .lazy-load-image-background.blur>img {
        opacity: 0;
    }

    .detailsBanner .opacity-layer {
        width: 100%;
        height: 250px;
        background: linear-gradient(180deg, rgba(4, 21, 45, 0) 0%, #050505 79.17%);
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .contentWrapper {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .detailsBanner .content {
        display: flex;
        position: relative;
        flex-direction: column;
        gap: 25px;
    }

    .detailsBanner .content .left {
        flex-shrink: 0;
    }

    .detailsBanner .content .left .posterImg {
        width: 100%;
        display: block;
        border-radius: 12px;
    }

    .detailsBanner .content .right {
        color: #fff;
    }

    .detailsBanner .content .right .title {
        font-size: 28px;
        line-height: 40px;
    }

    .detailsBanner .content .right .subtitle {
        font-size: 16px;
        line-height: 24px;
        margin-bottom: 15px;
        font-style: italic;
        opacity: .5;
    }

    .genres {
        display: flex;
        gap: 5px;
    }

    .detailsBanner .content .right .genres {
        margin-bottom: 25px;
        flex-flow: row wrap;
    }

    .genres .genre {
        padding: 3px 5px;
        font-size: 12px;
        border-radius: 4px;
        color: #fff;
        white-space: nowrap;
        border: 2px solid var(--red);
    }

    .detailsBanner .content .right .row {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 25px;
    }

    .circleRating {
        background-color: var(--black);
        border-radius: 50%;
        padding: 2px;
    }

    .detailsBanner .content .right .circleRating {
        max-width: 70px;
        background-color: var(--black2);
    }

    .detailsBanner .content .right .circleRating {
        max-width: 90px;
    }

    .CircularProgressbar {
        width: 100%;
        vertical-align: middle;
    }

    .circleRating .CircularProgressbar-trail {
        stroke: transparent;
    }

    .CircularProgressbar .CircularProgressbar-trail {
        stroke: #d6d6d6;
        stroke-linecap: round;
    }

    .CircularProgressbar .CircularProgressbar-path {
        stroke: #3e98c7;
        stroke-linecap: round;
        -webkit-transition: stroke-dashoffset .5s ease 0s;
        transition: stroke-dashoffset .5s ease 0s;
    }

    .detailsBanner .content .right .circleRating .CircularProgressbar-text {
        fill: #fff;
    }

    .circleRating .CircularProgressbar-text {
        font-size: 34px;
        font-weight: 700;
        fill: var(--black);
    }

    .CircularProgressbar .CircularProgressbar-text {
        fill: #3e98c7;
        font-size: 20px;
        dominant-baseline: middle;
        text-anchor: middle;
    }

    .detailsBanner .content .right .playbtn {
        display: flex;
        align-items: center;
        gap: 20px;
        cursor: pointer;
    }

    .detailsBanner .content .right svg {
        height: auto;
    }

    .detailsBanner .content .right .playbtn svg {
        width: 60px;
        height: auto;
    }

    .detailsBanner .content .right .playbtn .triangle {
        stroke-dasharray: 240;
        stroke-dashoffset: 480;
        stroke: #fff;
        transform: translateY(0);
        transition: all .7s ease-in-out;
    }

    .detailsBanner .content .right .playbtn .text {
        font-size: 20px;
        transition: all .7s ease-in-out;
    }

    .detailsBanner .content .right .overview {
        margin-bottom: 25px;
    }

    .detailsBanner .content .right .overview .description {
        line-height: 24px;
        padding-right: 100px;
    }


    .detailsBanner .content .right .overview .heading {
        font-size: 28px;
        margin-bottom: 10px;
        padding-right: 82%;
    }

    .detailsBanner .content .right .info {
        border-bottom: 1px solid rgba(255, 255, 255, .1);
        padding: 15px 0;
        display: flex;
    }

    .detailsBanner .content .right .info .text {
        margin-right: 10px;
        opacity: .5;
        line-height: 24px;
    }

    .videoPopup {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        opacity: 0;
        visibility: hidden;
        z-index: 9;
    }

    .videoPopup .opacityLayer {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .25);
        backdrop-filter: blur(3.5px);
        -webkit-backdrop-filter: blur(3.5px);
        opacity: 0;
        transition: opacity .4s;
    }

    .videoPopup .videoPlayer {
        position: relative;
        width: 800px;
        aspect-ratio: 16/9;
        background-color: #fff;
        transform: scale(.2);
        transition: transform .25s;
    }

    .videoPopup .videoPlayer .closeBtn {
        position: absolute;
        top: -20px;
        right: 0;
        color: #fff;
        cursor: pointer;
    }

    .castSection {
        position: relative;
        margin-bottom: 50px;
    }

    .contentWrapper {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .castSection .sectionHeading {
        font-size: 24px;
        color: #fff;
        margin-bottom: 25px;
        margin-top: 45px;
    }

    .castSection .listItems {
        display: flex;
        gap: 20px;
        overflow-y: hidden;
        margin-right: -20px;
        margin-left: -20px;
        padding: 0 20px;
    }

    .castSection .listItems .listItem {
        text-align: center;
        color: #fff;
    }

    .castSection .listItems .listItem .profileImg {
        width: 125px;
        height: 125px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .castSection .listItems .listItem .profileImg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        display: block;
    }

    .castSection .listItems .listItem .name {
        font-size: 18px;
        line-height: 24px;
    }

    .castSection .listItems .listItem .name {
        font-size: 14px;
        line-height: 20px;
        font-weight: 600;
    }

    .castSection .listItems .listItem .character {
        font-size: 14px;
        line-height: 20px;
        opacity: .5;
    }

    @media only screen and (min-width: 768px) {
        .detailsBanner {
            margin-bottom: 0;
            padding-top: 120px;
            /* min-height: 700px; */
        }

        .detailsBanner .content {
            gap: 50px;
            flex-direction: row;
        }

        .detailsBanner .content .left .posterImg {
            max-width: 350px;
        }

        .detailsBanner .content .right .title {
            padding-right: 52%;
            font-size: 34px;
            line-height: 44px;
        }

        .detailsBanner .content .right .subtitle {
            font-size: 20px;
            line-height: 28px;
        }

        .detailsBanner .content .right .playbtn svg {
            width: 80px;
        }

        .detailsBanner .content .right .overview .heading {
            font-size: 38px;
        }

        .detailsBanner .content .right .overview .description {
            padding-right: 10px;
        }

        .castSection .listItems {
            margin: 0;
            padding: 0;
        }

        .castSection .listItems .listItem .profileImg {
            width: 120px;
            height: 120px;
            margin-bottom: 25px;
        }

        .castSection .listItems .listItem .name {
            font-size: 16px;
            line-height: 24px;
        }

        .castSection .listItems .listItem .character {
            font-size: 14px;
            line-height: 24px;
        }
    }
</style>

<div class="vpageBanner">
    <div class="backdrop-img">
        <span class=" lazy-load-image-background blur lazy-load-image-loaded"
            style="color: transparent; display: inline-block;">
            <img class="" alt="" src="https://image.tmdb.org/t/p/original/iiXliCeykkzmJ0Eg9RYJ7F2CWSz.jpg">
        </span>
    </div>
    <div class="opacity-layer">

    </div>
    <div class="pageWrapper">
        <div class="content">
            <div class="left">
                <span class=" lazy-load-image-background blur lazy-load-image-loaded"
                    style="color: transparent; display: inline-block;">
                    <img class="posterImg" alt=""
                        src="https://image.tmdb.org/t/p/original/oUmmY7QWWn7OhKlcPOnirHJpP1F.jpg">
                </span>
            </div>
            <div class="right">
                <div class="title">
                    Retribution (2023)
                </div>
                <div class="subtitle">
                    All roads lead to the truth.
                </div>
                <div class="genres">
                    <div class="genre">
                        Thriller
                    </div>
                    <div class="genre">
                        Action
                    </div>
                    <div class="genre">
                        Crime
                    </div>
                </div>
                <div class="row">
                    <div class="circleRating">
                        <svg class="CircularProgressbar " viewBox="0 0 100 100" data-test-id="CircularProgressbar">
                            <path class="CircularProgressbar-trail"
                                d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8"
                                fill-opacity="0"
                                style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 0px;"></path>
                            <path class="CircularProgressbar-path"
                                d="M 50,50m 0,-46a 46,46 0 1 1 0,92a 46,46 0 1 1 0,-92" stroke-width="8"
                                fill-opacity="0"
                                style="stroke: orange; stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 101.159px;">
                            </path>
                            <text class="CircularProgressbar-text" x="50" y="50">6.5</text>
                        </svg>
                    </div>
                    <div class="playbtn">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px"
                            height="80px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7"
                            xml:space="preserve">
                            <polygon class="triangle" fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10"
                                points="73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
                            <circle class="circle" fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8"
                                r="103.3"></circle>
                        </svg>
                        <span class="text">Watch Trailer</span>
                    </div>
                </div>
                <div class="overviewd">
                    <div class="heading">Description</div>
                    <div class="description">
                        When a mysterious caller puts a bomb under his car seat, Matt Turner begins a high-speed chase
                        across the city to complete a specific series of tasks. With his kids trapped in the backseat
                        and a bomb that will explode if they get out of the car, an everyday commute becomes a twisted
                        game of life or death as Matt follows the stranger’s increasingly dangerous instructions in a
                        race against time to save his family.
                    </div>
                </div>
                <div class="info">
                    <div classname="infoItem">
                        <span classname="text bold">Status: </span>
                        <span class="text">Released</span>
                    </div>
                </div>
                <div class="info">
                    <span class="text bold">Director: </span>
                    <span class="text">
                        <span>Nimród Antal</span>
                    </span>
                </div>
                <div class="info">
                    <span class="text bold">Writer: </span>
                    <span class="text">
                        <span>Chris Salmanpour</span>
                    </span>
                </div>

            </div>
        </div>
        <div class="sectionArtists">
            <div class="artistHeading">Top Cast</div>
            <div class="listItems">
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur lazy-load-image-loaded"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://image.tmdb.org/t/p/original/bboldwqSC6tdw2iL6631c98l2Mn.jpg" />
                        </span>
                    </div>
                    <div class="name">Liam Neeson</div>
                    <div class="character">Matt Turner</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur lazy-load-image-loaded"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://image.tmdb.org/t/p/original/abEWaYTugwH967V8LfptQIMioKQ.jpg" />
                        </span>
                    </div>
                    <div class="name">Noma Dumezweni</div>
                    <div class="character">Angela Brickmann</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur lazy-load-image-loaded"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://image.tmdb.org/t/p/original/phfygRDYezltJge7s7UD4M6IMdI.jpg" />
                        </span>
                    </div>
                    <div class="name">Lilly Aspell</div>
                    <div class="character">Emily Turner</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur lazy-load-image-loaded"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://image.tmdb.org/t/p/original/aYY3C75ZwbQxGSSan9Uft4mGE9w.jpg" />
                        </span>
                    </div>
                    <div class="name">Jack Champion</div>
                    <div class="character">Zach Turner</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur lazy-load-image-loaded"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://image.tmdb.org/t/p/original/ApY4Ql2xGnzy8LeWqcntAbEQHiB.jpg" />
                        </span>
                    </div>
                    <div class="name">Arian Moayed</div>
                    <div class="character">Sylvain</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur lazy-load-image-loaded"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://image.tmdb.org/t/p/original/nwsdu9lOsKJ5v9RwOCc7kAiuxSO.jpg" />
                        </span>
                    </div>
                    <div class="name">Embeth Davidtz</div>
                    <div class="character">Heather Turner</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://image.tmdb.org/t/p/original/nwsdu9lOsKJ5v9RwOCc7kAiuxSO.jpg" />
                        </span>
                    </div>
                    <div class="name">Matthew Modine</div>
                    <div class="character">Anders Muller</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;">
                            <img class="" alt=""
                                src="https://movieapplication007.netlify.app/assets/avatar-bd5ec287.png" />
                        </span>
                    </div>
                    <div class="name">Emily Kusche</div>
                    <div class="character">Mila</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Luca Márkus</div>
                    <div class="character">Kat</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Bernhard Piesk</div>
                    <div class="character">Captain Dregger</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Michael S. Ruscheinsky</div>
                    <div class="character">Man in the Blue Suit</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Antonije Stankovic</div>
                    <div class="character">Young Protestor</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Christian Koerner</div>
                    <div class="character">BPol Police Officer</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Gerhard Elfers</div>
                    <div class="character">Male News Anchor</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Tine Gerhäeusser</div>
                    <div class="character">Female News Anchor</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Peter Miklusz</div>
                    <div class="character">Press Conference Reporter</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Luc Etienne</div>
                    <div class="character">Pils Groger</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Nedy John Cross</div>
                    <div class="character">Passerby (uncredited)</div>
                </div>
                <div class="listItem">
                    <div class="profileImg">
                        <span class="lazy-load-image-background blur"
                            style="color: transparent; display: inline-block;"><span class=""
                                style="display: inline-block;"></span></span>
                    </div>
                    <div class="name">Daniel Grave</div>
                    <div class="character">Male Phone Voice (voice) (uncredited)</div>
                </div>
            </div>
        </div>
    </div>
    <div class="videoPopup ">
        <div class="opacityLayer"></div>
        <div class="videoPlayer">
            <span class="closeBtn">Close</span>
            <div style="width: 100%; height: 100%;">
            </div>
        </div>
    </div>
</div>

@php
    include public_path('themes/default/views/footer.blade.php');
@endphp

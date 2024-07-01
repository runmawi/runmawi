<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>AWS Elemental MediaTailor</title>

    <link href="//vjs.zencdn.net/7.3.0/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/7.3.0/video.min.js"></script>
</head>

<body>
    <h1>My Ads Featured Video</h1>
    <video id="my_video" class="video-js" controls preload="auto" width="960" height="400" withCredentials="true">
        <source
            src="https://7529ea7ef7344952b6acc12ff243ed43.mediatailor.us-west-2.amazonaws.com/v1/master/2d2d0d97b0e548f025b2598a69b55bf30337aa0e/npp_795/07VF419BOTBBVEGLG5ZA/hls3/now,-1m/m.m3u8?ads.app_bundle=%5BappBundle%5D&ads.app_name=%5BappName%5D&ads.app_platform=%5BOPERATING_SYSTEM%5D&ads.app_store_url=%5BAppStoreUrl%5D&ads.app_ver=%5BOPERATING_SYSTEM_VERSION%5D&ads.channel_name=FiredUp+Network&ads.content_cat=IAB17&ads.content_genre=Sports&ads.content_id=SFI100&ads.content_language=English&ads.content_title=chicago+style+part1&ads.coppa=0&ads.device_make=%5BDEVICE_MAKE%5D&ads.device_model=%5BDEVICE_MODEL%5D&ads.did=%5BDID%5D&ads.gdpr=%5BGdpr%5D&ads.gdpr_consent=%5Bgdprconsent%5D&ads.h=%5BplayerHeight%5D&ads.ic=%5BAppCat%5D&ads.livestream=1&ads.lmt=%5BLMT%5D&ads.provider=FiredUp&ads.rating=TVG&ads.schain=1&ads.url=%5BAppDomain%5D&ads.us_privacy=%5BusPrivacy%5D&ads.w=%5BplayerWidth%5D"
            type="application/x-mpegURL">
    </video>


    <ul id="adsUl"></ul>

    <script>
        // 1. VMAP File URL
        const vmapUrl = 'https://dev-automads-solution-ads-bucket.s3-eu-west-1.amazonaws.com/episode3/ad_breaks.vmap';

        // 2. [hours, minutes, seconds] expressed in seconds
        const smpteConversion = [3600, 60, 1];

        // 3. get hold of the player
        const player = videojs('my_video');

        // 4. get handle of the UL element
        const adsUl = document.querySelector('#adsUl');

        // 5. utility functions
        const map = fn => list => list.map(fn);
        const dot = x => y => x.reduce((acc, next, i) => acc + next * y[i], 0);
        const int10 = x => parseInt(x, 10);

        // 6. workflow steps
        const getVMAP = response => response.text();
        const parseVMAP = text => new DOMParser().parseFromString(text, 'text/xml');
        const getAdBreaks = xmlDoc => xmlDoc.getElementsByTagName('vmap:AdBreak');
        const getTimeOffsets = adBreak => adBreak.getAttribute('timeOffset');
        const splitSMPTEString = timeOffset => timeOffset.split(':');
        const SMPTEToSec = dot(smpteConversion);
        const minus5Sec = x => x > 5 ? x - 5 : 0;

        // 7. create <li> for a given ad-break timestamp
        const createAdLi = ts => {
            const li = document.createElement('li');
            li.setAttribute('data-ts', ts)
            li.appendChild(document.createTextNode(`ad-break at ${ts} sec`));
            li.addEventListener('click', liCallback);
            return li;
        };

        // 8. callback invoked when an <li> is clicked on
        const liCallback = ({
            target
        }) => {
            const ts = parseInt(target.getAttribute('data-ts'), 10);
            player.currentTime(ts);
            player.play();
        };

        // 9. append to <ul>
        const append = li => adsUl.appendChild(li);

        // 10. handles errors and returns an empty list
        const errorHandler = error => console.error(`error with VMAP file ${error}`) || [];

        // 11. the whole workflow
        fetch(vmapUrl)
            .then(getVMAP)
            .then(parseVMAP)
            .then(getAdBreaks)
            .then(Array.from)
            .then(map(getTimeOffsets))
            .then(map(splitSMPTEString))
            .then(map(map(int10)))
            .then(map(SMPTEToSec))
            .then(map(minus5Sec))
            .then(map(createAdLi))
            .then(map(append))
            .catch(errorHandler);
    </script>

</body>

</html>

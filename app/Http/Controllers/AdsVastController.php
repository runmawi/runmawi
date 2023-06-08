<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sokil\Vast\Ad;
use Sokil\Vast\Ad\InLine;
use Sokil\Vast\Ad\InLine\Creatives;
use Sokil\Vast\Ad\InLine\Creatives\Creative;
use Sokil\Vast\Ad\InLine\Creatives\Creative\Linear;
use Sokil\Vast\Ad\InLine\Creatives\Creative\Linear\MediaFiles;
use Sokil\Vast\Ad\InLine\Creatives\Creative\Linear\MediaFiles\MediaFile;
use Sokil\Vast\Document;
use Sokil\Vast\Tag;

class AdsVastController extends Controller
{
    public function index()
    {
        $factory = new \Sokil\Vast\Factory();
        $document = $factory->create('4.1');
        
        // insert Ad section
        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem('Ad Server Name')
            ->setAdTitle('Ad Title')
            ->addImpression('http://ad.server.com/impression', 'imp1');
        
        // create creative for ad section
        $linearCreative = $ad1
            ->createLinearCreative()
            ->setDuration(128)
            ->setId('013d876d-14fc-49a2-aefd-744fce68365b')
            ->setAdId('pre')
            ->setVideoClicksClickThrough('http://entertainmentserver.com/landing')
            ->addVideoClicksClickTracking('http://ad.server.com/videoclicks/clicktracking')
            ->addVideoClicksCustomClick('http://ad.server.com/videoclicks/customclick')
            ->addTrackingEvent('start', 'http://ad.server.com/trackingevent/start')
            ->addTrackingEvent('pause', 'http://ad.server.com/trackingevent/stop');
        
        $linearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setHeight(200)
            ->setWidth(200)
            ->setBitrate(2500)
            ->setUrl('http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4');
        
            // get dom document
        $domDocument = $document->toDomDocument();

        $xml = $domDocument->saveXML(); // Use the saveXML() method to convert the DOMDocument to a string
        
        $filePath = 'vast.xml';
        $domDocument->save($filePath);
        
    }
}

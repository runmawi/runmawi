<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>

<rss version="2.0">
    <channel>
        <title> <![CDATA[ {{ $title }} ]]> </title>
        <link>  <![CDATA[ {{  $link }} ]]> </link>
        <description> <![CDATA[ {{ $description }} ]]> </description>
        <language> {{ $language }} </language>
        <pubDate>  {{ $pubDate }}  </pubDate>
  
        @foreach( $videos as $key => $video )
            <item>
                <title> <![CDATA[{{ $video->title }}]]> </title>
                <link>  {{ $video->slug }} </link>
                <description> <![CDATA[{!! $video->description !!}]]> </description>
                <category> {{ $video->description }} </category>
                <author> <![CDATA[{{ $video->access }}]]> </author>
                <guid> {{ $video->id }} </guid>
                <pubDate> {{ $video->created_at->toRssString() }} </pubDate>
            </item>
        @endforeach
    </channel>
</rss>
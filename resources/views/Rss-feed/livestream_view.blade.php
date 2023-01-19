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
  
        @foreach( $livestreams as $key => $livestream )
            <item>
                <title> <![CDATA[{{ $livestream->title }}]]> </title>
                <link>  {{ $livestream->slug }} </link>
                <description> <![CDATA[{!! $livestream->description !!}]]> </description>
                <category> {{ $livestream->description }} </category>
                <author> <![CDATA[{{ $livestream->access }}]]> </author>
                <guid> {{ $livestream->id }} </guid>
                <pubDate> {{ $livestream->created_at->toRssString() }} </pubDate>
            </item>
        @endforeach
    </channel>
</rss>
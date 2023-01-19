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
  
        @foreach( $episodes as $key => $episode )
            <item>
                <title> <![CDATA[{{ $episode->title }}]]> </title>
                <link>  {{ $episode->slug }} </link>
                <description> <![CDATA[{!! $episode->description !!}]]> </description>
                <category> {{ $episode->description }} </category>
                <author> <![CDATA[{{ $episode->access }}]]> </author>
                <guid> {{ $episode->id }} </guid>
                <pubDate> {{ $episode->created_at->toRssString() }} </pubDate>
            </item>
        @endforeach
    </channel>
</rss>
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
  
        @foreach( $audios as $key => $audio )
            <item>
                <title> <![CDATA[{{ $audio->title }}]]> </title>
                <link>  {{ $audio->slug }} </link>
                <description> <![CDATA[{!! $audio->description !!}]]> </description>
                <category> {{ $audio->description }} </category>
                <author> <![CDATA[{{ $audio->access }}]]> </author>
                <guid> {{ $audio->id }} </guid>
                <pubDate> {{ $audio->created_at->toRssString() }} </pubDate>
            </item>
        @endforeach
    </channel>
</rss>
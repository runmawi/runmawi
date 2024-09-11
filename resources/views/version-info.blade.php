<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ ucwords(ltrim(Request::getPathInfo(), '/')) . ' | ' . GetWebsiteName() }}</title>

    <style>
        table {
            margin: 0 auto;
        }

        th,td {
            padding: 8px 7px !important;
            font-size: medium !important;
        }

        #protectedContent {
            display: none;
        }
    </style>
</head>

<body class="version-info">

    <div id="protectedContent">
        <table>
            <tbody>
                <caption>Config Version</caption>
    
                <tr class="h">
                    <th>Name</th>
                    <th>Current Version</th>
                </tr>
    
                <tr>
                    <td class="e">{{ ucwords('php version') }}</td>
                    <td class="v">{{ $php_version }}</td>
                </tr>
    
                <tr>
                    <td class="e">{{ ucwords('composer version') }}</td>
                    <td class="v">{{ $composer_version }}</td>
                </tr>
    
                <tr>
                    <td class="e">{{ ucwords('laravel version') }}</td>
                    <td class="v">{{ $laravel_version }}</td>
                </tr>
            </tbody>
        </table>
        <br><br>
    
        <table class="composer-json-table">
            <caption>Composer Json File</caption>
    
            <tbody>
                <tr class="h">
                    <th>Key</th>
                    <th>Value</th>
                </tr>
    
                @foreach($composer_json as $key => $value)
                    <tr>
                        <td class="e">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                        <td class="v">
                            @if(is_array($value))
                                <table>
                                    @foreach ($value as $key => $item)
                                        <tr>
                                            <td colspan="2">{{ $key }}</td>
                                            <td colspan="2">{!! !is_array($item) ?  htmlentities($item) : json_encode($item)!!}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ phpinfo() }}
    </div>
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var password = prompt("Please Enter your correct password (Only for developers):");

        if (password !== null && password.trim() == "13579@$^*)") {
            document.getElementById('protectedContent').style.display = 'block';
        } else {
            alert("Incorrect Password / Action canceled.");
            window.location.href = "<?php echo $redirect_url ?>";
        }
    });
</script>
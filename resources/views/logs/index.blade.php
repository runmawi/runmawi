<!DOCTYPE html>
<html>
<head>
    <title>Laravel Logs</title>
    <style>
        body { font-family: monospace; background: #1e1e1e; color: #d4d4d4; padding: 20px; }
        pre { white-space: pre-wrap; word-wrap: break-word; background: #2e2e2e; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
        .pagination { margin-top: 20px; }
        .pagination a { color: #fff; margin: 0 5px; text-decoration: none; }
        .pagination span { margin: 0 5px; }
        .pagination {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination a,
    .pagination span {
        padding: 8px 14px;
        font-size: 14px;
        border-radius: 6px;
        text-decoration: none;
        background-color: #1e1e1e;
        color: #0ff;
        border: 1px solid #444;
        transition: background-color 0.2s, color 0.2s;
    }

    .pagination a:hover {
        background-color: #0ff;
        color: #121212;
    }

    .pagination .active {
        background-color: #0ff;
        color: #121212;
        font-weight: bold;
    }

    .pagination .disabled {
        color: #666;
        pointer-events: none;
        background-color: #2b2b2b;
    }
    </style>
</head>
<body>
    <h2>Server Logs</h2>

    @forelse ($logs as $log)
        <pre>{{ $log }}</pre>
    @empty
        <p>No logs available.</p>
    @endforelse

    @if ($paginator->hasPages())
        <div class="pagination">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="disabled">&laquo; Prev</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Prev</a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a>
            @else
                <span class="disabled">Next &raquo;</span>
            @endif
        </div>
    @endif
</body>
</html>

<div id="episode-logs-table">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Episode Id</th>
                <th scope="col">Series Id</th>
                <th scope="col">Season Id</th>
                <th scope="col">Deleted By</th>
                <th scope="col">Deleted At</th>
                <th scope="col">PDF File</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($episodeLogs as $log)
                <tr>
                    <td>{{ $log->episode_id }}</td>
                    <td>{{ $log->series_id }}</td>
                    <td>{{ $log->season_id }}</td>
                    <td>{{ $log->user_id }}</td>
                    <td>{{ $log->updated_at }}</td>
                    <td>
                        <a href="{{ $log->pdf_path ? asset('public/deletedPDF/' . $log->pdf_path) : '#' }}" target="_blank">
                            {{ $log->pdf_path ? "Click to view" : 'N/A'}}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Separate div for pagination -->
<div class="d-flex justify-content-end" id="pagination-links-episode">
    {!! $episodeLogs->links() !!}
</div>

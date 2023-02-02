    <div class="card">
        <div class="card-body">
            <form method="get" action="<?= route('comments.store') ?>">
                <div class="form-group">
                    <label for="message">Add a comment:</label>
                    <textarea class="form-control"  name="message" rows="2" required></textarea>
                </div>

                <input type="hidden" name="source" value="<?= Route::currentRouteName() ?>">
                <input type="hidden" name="source_id" value="<?= $source_id ?>">

                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">Submit</button>
            </form>
        </div>
    </div>
    <br />
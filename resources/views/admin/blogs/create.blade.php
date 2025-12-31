<x-admin-layout title="Create Blog">
    <div class="card">
        <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" id="titleInput" required>
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="Cerita Artefak">Cerita Artefak</option>
                    <option value="News & Event">News & Event</option>
                </select>
            </div>
            <div class="form-group">
                <label>Excerpt</label>
                <textarea name="excerpt"></textarea>
            </div>
            <div class="form-group">
                <label>Content *</label>
                <textarea name="content" required style="min-height:200px"></textarea>
            </div>
            <div class="form-group">
                <label>Featured Image</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published" value="1" checked> Published
                </label>
            </div>
            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Blog</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

<x-admin-layout title="Edit Blog">
    <div class="card">
        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" value="{{ $blog->title }}" required>
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="Cerita Artefak" {{ $blog->category == 'Cerita Artefak' ? 'selected' : '' }}>Cerita Artefak</option>
                    <option value="News & Event" {{ $blog->category == 'News & Event' ? 'selected' : '' }}>News & Event</option>
                </select>
            </div>
            <div class="form-group">
                <label>Excerpt</label>
                <textarea name="excerpt">{{ $blog->excerpt }}</textarea>
            </div>
            <div class="form-group">
                <label>Content *</label>
                <textarea name="content" required style="min-height:200px">{{ $blog->content }}</textarea>
            </div>
            <div class="form-group">
                <label>Featured Image</label>
                @if($blog->image)
                    <img src="{{ asset('storage/'.$blog->image) }}" style="max-width:200px;margin-bottom:10px;display:block">
                @endif
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published" value="1" {{ $blog->is_published ? 'checked' : '' }}> Published
                </label>
            </div>
            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Blog</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

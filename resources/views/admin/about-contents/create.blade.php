<x-admin-layout title="Add About Content">
    <div class="card">
        <form method="POST" action="{{ route('admin.about-contents.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Section *</label>
                <select name="section" required>
                    <option value="">-- Select Section --</option>
                    <option value="achievement">Achievement</option>
                    <option value="history">History</option>
                    <option value="story">Story</option>
                </select>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}">
                <small style="color:#666;">Optional - for sections that need a title</small>
            </div>
            <div class="form-group">
                <label>Title (English)</label>
                <input type="text" name="title_en" value="{{ old('title_en') }}">
            </div>
            <div class="form-group">
                <label>Content *</label>
                <textarea name="content" required style="min-height:150px">{{ old('content') }}</textarea>
            </div>
            <div class="form-group">
                <label>Content (English)</label>
                <textarea name="content_en" style="min-height:150px">{{ old('content_en') }}</textarea>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" accept="image/*">
                <small style="color:#666;">Optional - recommended size: 800x600px</small>
            </div>
            <div class="form-group">
                <label>Order</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0">
                <small style="color:#666;">Display order (0 = first)</small>
            </div>
            <div class="form-group">
                <label>
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Active
                </label>
            </div>
            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Content</button>
                <a href="{{ route('admin.about-contents.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

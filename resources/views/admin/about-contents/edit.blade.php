<x-admin-layout title="Edit About Content">
    <div style="margin-bottom:20px">
        <a href="{{ route('admin.about-contents.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.about-contents.update', $aboutContent) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Section *</label>
                <select name="section" required>
                    <option value="">-- Select Section --</option>
                    <option value="achievement" {{ $aboutContent->section == 'achievement' ? 'selected' : '' }}>Achievement</option>
                    <option value="history" {{ $aboutContent->section == 'history' ? 'selected' : '' }}>History</option>
                    <option value="story" {{ $aboutContent->section == 'story' ? 'selected' : '' }}>Story</option>
                </select>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" value="{{ $aboutContent->title }}">
                <small style="color:#666;">Optional - for sections that need a title</small>
            </div>
            <div class="form-group">
                <label>Title (English)</label>
                <input type="text" name="title_en" value="{{ $aboutContent->title_en }}">
            </div>
            <div class="form-group">
                <label>Content *</label>
                <textarea name="content" required style="min-height:150px">{{ $aboutContent->content }}</textarea>
            </div>
            <div class="form-group">
                <label>Content (English)</label>
                <textarea name="content_en" style="min-height:150px">{{ $aboutContent->content_en }}</textarea>
            </div>
            <div class="form-group">
                <label>Image</label>
                @if($aboutContent->image)
                    <img src="{{ asset('storage/'.$aboutContent->image) }}" style="max-width:200px;margin-bottom:10px;display:block;border-radius:8px;">
                @endif
                <input type="file" name="image" accept="image/*">
                <small style="color:#666;">Leave empty to keep current image</small>
            </div>
            <div class="form-group">
                <label>Order</label>
                <input type="number" name="order" value="{{ $aboutContent->order }}" min="0">
                <small style="color:#666;">Display order (0 = first)</small>
            </div>
            <div class="form-group">
                <label>
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ $aboutContent->is_active ? 'checked' : '' }}> Active
                </label>
            </div>
            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Content</button>
                <a href="{{ route('admin.about-contents.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

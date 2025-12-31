<x-admin-layout title="Edit Collection">
    <div class="card">
        <form action="{{ route('admin.collections.update', $collection) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $collection->name) }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $collection->category) }}">
                @error('category') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Era</label>
                <input type="text" name="era" class="form-control" value="{{ old('era', $collection->era) }}" placeholder="e.g., Majapahit, Sriwijaya">
                @error('era') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Origin</label>
                <input type="text" name="origin" class="form-control" value="{{ old('origin', $collection->origin) }}" placeholder="e.g., Java, Sumatra">
                @error('origin') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $collection->description) }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Image</label>
                @if($collection->image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/'.$collection->image) }}" style="max-width: 200px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>3D Model</label>
                @if($collection->model_3d)
                    <div style="margin-bottom: 10px;">
                        <span class="badge badge-success">Model uploaded</span>
                    </div>
                @endif
                <input type="file" name="model_3d" class="form-control">
                @error('model_3d') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $collection->is_published) ? 'checked' : '' }}>
                    Published
                </label>
            </div>

            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Collection</button>
                <a href="{{ route('admin.collections.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

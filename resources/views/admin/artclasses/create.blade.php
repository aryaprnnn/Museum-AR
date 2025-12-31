<x-admin-layout title="Create Art Class">
    <div class="card">
        <form action="{{ route('admin.artclasses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" id="titleInput" class="form-control" value="{{ old('title') }}" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Level *</label>
                <select name="level" class="form-control" required>
                    <option value="">Select Level</option>
                    <option value="pemula" {{ old('level') == 'pemula' ? 'selected' : '' }}>Pemula</option>
                    <option value="menengah" {{ old('level') == 'menengah' ? 'selected' : '' }}>Menengah</option>
                    <option value="lanjutan" {{ old('level') == 'lanjutan' ? 'selected' : '' }}>Lanjutan</option>
                </select>
                @error('level') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Instructor</label>
                <input type="text" name="instructor" class="form-control" value="{{ old('instructor') }}">
                @error('instructor') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Schedule</label>
                <input type="text" name="schedule" class="form-control" value="{{ old('schedule') }}" placeholder="e.g., Every Saturday 10:00 - 12:00">
                @error('schedule') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Quota *</label>
                <input type="number" name="quota" class="form-control" value="{{ old('quota') }}" required>
                @error('quota') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Available *</label>
                <input type="number" name="available" class="form-control" value="{{ old('available') }}" required>
                @error('available') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Price (Rp) *</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Art Class</button>
                <a href="{{ route('admin.artclasses.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

<x-admin-layout title="Edit Educational Program">
    <div class="card">
        <form action="{{ route('admin.educational.update', $educationalProgram) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $educationalProgram->title) }}" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Type *</label>
                <select name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="workshop" {{ old('type', $educationalProgram->type) == 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="seminar" {{ old('type', $educationalProgram->type) == 'seminar' ? 'selected' : '' }}>Seminar</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Price * (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $educationalProgram->price) }}" required min="0">
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Facilitator</label>
                <input type="text" name="facilitator" class="form-control" value="{{ old('facilitator', $educationalProgram->facilitator) }}">
                @error('facilitator') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Schedule</label>
                <!-- Use datetime-local for calendar popup -->
                <input type="datetime-local" name="schedule" class="form-control" value="{{ old('schedule', $educationalProgram->schedule) }}">
                <small class="text-muted">Previous: {{ $educationalProgram->schedule }} (Update if needed)</small>
                @error('schedule') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $educationalProgram->location) }}">
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Target Audience</label>
                <input type="text" name="target_audience" class="form-control" value="{{ old('target_audience', $educationalProgram->target_audience) }}" placeholder="e.g., Pelajar, Mahasiswa, Umum">
                @error('target_audience') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $educationalProgram->description) }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Benefits</label>
                <textarea name="benefits" class="form-control" rows="3">{{ old('benefits', $educationalProgram->benefits) }}</textarea>
                @error('benefits') <span class="text-danger">{{ $message }}</span> @enderror
                <small class="form-text text-muted">Separate multiple benefits with newlines</small>
            </div>

            <div class="form-group">
                <label>Image</label>
                @if($educationalProgram->image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/'.$educationalProgram->image) }}" style="max-width: 200px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $educationalProgram->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Program</button>
                <a href="{{ route('admin.educational.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

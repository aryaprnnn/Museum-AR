<x-admin-layout title="Edit Exhibition">
    <div class="card">
        <form action="{{ route('admin.exhibitions.update', $exhibition) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $exhibition->title) }}" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Slug *</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug', $exhibition->slug) }}" required>
                @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Curator</label>
                <input type="text" name="curator" class="form-control" value="{{ old('curator', $exhibition->curator) }}">
                @error('curator') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" class="form-control" required>
                    <option value="">Select Status</option>
                    <option value="upcoming" {{ old('status', $exhibition->status) == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ old('status', $exhibition->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="past" {{ old('status', $exhibition->status) == 'past' ? 'selected' : '' }}>Past</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $exhibition->start_date) }}">
                @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $exhibition->end_date) }}">
                @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Time</label>
                <input type="text" name="time" class="form-control" value="{{ old('time', $exhibition->time) }}" placeholder="e.g., 09:00 - 17:00">
                @error('time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $exhibition->location) }}">
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $exhibition->description) }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Image</label>
                @if($exhibition->image)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/'.$exhibition->image) }}" style="max-width: 200px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $exhibition->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="form-group button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Exhibition</button>
                <a href="{{ route('admin.exhibitions.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

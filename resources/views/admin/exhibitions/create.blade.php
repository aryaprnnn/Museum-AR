<x-admin-layout title="Create Exhibition">
    <div class="card">
        <form action="{{ route('admin.exhibitions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Slug *</label>
                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Curator</label>
                <input type="text" name="curator" class="form-control" value="{{ old('curator') }}">
                @error('curator') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" class="form-control" required>
                    <option value="">Select Status</option>
                    <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="past" {{ old('status') == 'past' ? 'selected' : '' }}>Past</option>
                </select>
                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Start Date</label>
                <input type="text" name="start_date" class="form-control flatpickr-date" value="{{ old('start_date') }}" placeholder="Select Start Date">
                @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>End Date</label>
                <input type="text" name="end_date" class="form-control flatpickr-date" value="{{ old('end_date') }}" placeholder="Select End Date">
                @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            @php
                 $startTime = old('start_time');
                 $endTime = old('end_time');
            @endphp

            <div class="form-group">
                <label style="font-size: 1.1rem; font-weight: 600; margin-bottom: 15px; display: block;">Time</label>
                <div class="row">
                     <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between" style="gap: 15px;">
                            <div style="flex: 1;">
                                <input type="text" name="start_time" class="form-control flatpickr-time" value="{{ $startTime }}" required placeholder="Open Time" style="height: 45px; text-align: left;">
                            </div>
                            <div style="font-weight: bold; color: #666;">-</div>
                            <div style="flex: 1;">
                                <input type="text" name="end_time" class="form-control flatpickr-time" value="{{ $endTime }}" required placeholder="Close Time" style="height: 45px; text-align: left;">
                            </div>
                        </div>
                        @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                        @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
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
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Exhibition</button>
                <a href="{{ route('admin.exhibitions.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".flatpickr-date", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
        
        flatpickr(".flatpickr-time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    });
</script>

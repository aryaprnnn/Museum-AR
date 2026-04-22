<x-admin-layout title="Create Educational Program">
    <div class="card">
        <form action="{{ route('admin.educational.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" id="titleInput" class="form-control" value="{{ old('title') }}" required>
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Type *</label>
                <select name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="workshop" {{ old('type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="seminar" {{ old('type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Price * (Rp)</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0">
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Facilitator</label>
                <input type="text" name="facilitator" class="form-control" value="{{ old('facilitator') }}">
                @error('facilitator') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            @php
                 $dateVal = old('date');
                 $timeVal = old('time');
            @endphp
            
            <div class="form-group">
                <label style="font-size: 1.1rem; font-weight: 600; margin-bottom: 15px; display: block;">Schedule</label>
                
                <div class="row">
                    <!-- Date Section -->
                    <div class="col-md-12 mb-3">
                        <label class="text-muted" style="font-weight: 500; margin-bottom: 5px; display: block;">Date</label>
                        <input type="text" name="date" class="form-control flatpickr-date" value="{{ $dateVal }}" required placeholder="Select Date" style="height: 45px;">
                        @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Time Section -->
                    <div class="col-md-12">
                        <label class="text-muted" style="font-weight: 500; margin-bottom: 5px; display: block;">Time</label>
                        <input type="text" name="time" class="form-control flatpickr-time" value="{{ $timeVal }}" required placeholder="Select Time" style="height: 45px; text-align: left;">
                        @error('time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Target Audience</label>
                <input type="text" name="target_audience" class="form-control" value="{{ old('target_audience') }}" placeholder="e.g., Pelajar, Mahasiswa, Umum">
                @error('target_audience') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Benefits</label>
                <textarea name="benefits" class="form-control" rows="3">{{ old('benefits') }}</textarea>
                @error('benefits') <span class="text-danger">{{ $message }}</span> @enderror
                <small class="form-text text-muted">Separate multiple benefits with newlines</small>
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
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Program</button>
                <a href="{{ route('admin.educational.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
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

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

            @php
                 $day = old('day');
                 $startTime = old('start_time');
                 $endTime = old('end_time');
            @endphp
            <div class="form-group">
                <label style="font-size: 1.1rem; font-weight: 600; margin-bottom: 15px; display: block;">Schedule</label>
                
                <div class="row">
                    <!-- Day Section -->
                    <div class="col-md-12 mb-3">
                        <label class="text-muted" style="font-weight: 500; margin-bottom: 5px; display: block;">Day</label>
                        <select name="day" class="form-control" required style="height: 45px;">
                            <option value="">Select Day</option>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $d)
                                <option value="{{ $d }}" {{ $day == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endforeach
                        </select>
                        @error('day') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <!-- Time Section -->
                    <div class="col-md-12">
                        <label class="text-muted" style="font-weight: 500; margin-bottom: 5px; display: block;">Time</label>
                        <div class="d-flex align-items-center justify-content-between" style="gap: 15px;">
                            <div style="flex: 1;">
                                <input type="time" name="start_time" class="form-control" value="{{ $startTime }}" required placeholder="Start Time" style="height: 45px;">
                            </div>
                            <div style="font-weight: bold; color: #666;">-</div>
                            <div style="flex: 1;">
                                <input type="time" name="end_time" class="form-control" value="{{ $endTime }}" required placeholder="End Time" style="height: 45px;">
                            </div>
                        </div>
                        @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                        @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
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

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Art Class</button>
                <a href="{{ route('admin.artclasses.index') }}" class="btn btn-secondary ml-2">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("input[type=time]", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
        });
    </script>
</x-admin-layout>

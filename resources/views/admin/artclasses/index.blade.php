<x-admin-layout title="Art Classes">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.artclasses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Art Class</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Price</th>
                    <th>Quota</th>
                    <th>Available</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artclasses as $artclass)
                <tr>
                    <td>{{ $artclass->id }}</td>
                    <td>{{ $artclass->title }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($artclass->level) }}</span></td>
                    <td>Rp {{ number_format($artclass->price, 0, ',', '.') }}</td>
                    <td>{{ $artclass->quota }}</td>
                    <td>{{ $artclass->available }}</td>
                    <td>
                        <span class="badge {{ $artclass->is_active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $artclass->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="button-group">
                            <a href="{{ route('admin.artclasses.edit', $artclass) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.artclasses.destroy', $artclass) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #999;">No art classes found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>

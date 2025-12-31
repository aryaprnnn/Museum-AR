<x-admin-layout title="Exhibitions">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.exhibitions.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Exhibition</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Curator</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exhibitions as $exhibition)
                <tr>
                    <td>{{ $exhibition->id }}</td>
                    <td>{{ $exhibition->title }}</td>
                    <td>{{ $exhibition->curator }}</td>
                    <td>
                        <span class="badge 
                            @if($exhibition->status == 'ongoing') badge-success
                            @elseif($exhibition->status == 'upcoming') badge-info
                            @else badge-secondary
                            @endif">
                            {{ ucfirst($exhibition->status) }}
                        </span>
                    </td>
                    <td>{{ $exhibition->start_date ?? '-' }}</td>
                    <td>{{ $exhibition->end_date ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $exhibition->is_active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $exhibition->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="button-group">
                            <a href="{{ route('admin.exhibitions.edit', $exhibition) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.exhibitions.destroy', $exhibition) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No exhibitions found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>

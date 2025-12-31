<x-admin-layout title="Educational Programs">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.educational.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Program</a>
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
                    <th>Type</th>
                    <th>Facilitator</th>
                    <th>Active</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $program)
                <tr>
                    <td>{{ $program->id }}</td>
                    <td>{{ $program->title }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($program->type) }}</span></td>
                    <td>{{ $program->facilitator }}</td>
                    <td>
                        <span class="badge {{ $program->is_active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $program->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>{{ $program->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="button-group">
                            <a href="{{ route('admin.educational.edit', $program) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.educational.destroy', $program) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No educational programs found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>

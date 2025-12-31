<x-admin-layout title="Collections">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.collections.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Collection</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Era</th>
                    <th>Published</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collections as $collection)
                <tr>
                    <td>{{ $collection->id }}</td>
                    <td>{{ $collection->name }}</td>
                    <td>{{ $collection->category }}</td>
                    <td>{{ $collection->era }}</td>
                    <td>
                        <span class="badge {{ $collection->is_published ? 'badge-success' : 'badge-secondary' }}">
                            {{ $collection->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td>{{ $collection->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="button-group">
                            <a href="{{ route('admin.collections.edit', $collection) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.collections.destroy', $collection) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #999;">No collections found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>

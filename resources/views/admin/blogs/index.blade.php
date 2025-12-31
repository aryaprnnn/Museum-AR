<x-admin-layout title="Blogs">
    <div style="margin-bottom:20px">
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Blog</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                    <tr>
                        <td>{{ $blog->id }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->category }}</td>
                        <td>
                            @if($blog->is_published)
                                <span style="background:#28a745;color:#fff;padding:4px 8px;border-radius:4px;font-size:0.85rem">Yes</span>
                            @else
                                <span style="background:#6c757d;color:#fff;padding:4px 8px;border-radius:4px;font-size:0.85rem">No</span>
                            @endif
                        </td>
                        <td>{{ $blog->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="button-group">
                                <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" style="display:inline" onsubmit="return confirm('Delete this blog?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:#999">No blogs found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

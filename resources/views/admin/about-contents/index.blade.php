<x-admin-layout title="About Contents">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.about-contents.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Content</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Image</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contents as $content)
                <tr>
                    <td><span class="badge">{{ $content->section }}</span></td>
                    <td>{{ $content->title ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($content->content, 60) }}</td>
                    <td>
                        @if($content->image)
                            <img src="{{ asset('storage/'.$content->image) }}" style="width:60px;height:40px;object-fit:cover;border-radius:4px;">
                        @else
                            <span style="color:#999;">No image</span>
                        @endif
                    </td>
                    <td>{{ $content->order }}</td>
                    <td>
                        <span class="status-badge {{ $content->is_active ? 'status-active' : 'status-draft' }}">
                            {{ $content->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            {{-- Sembunyikan tombol Edit & Hapus jika section adalah hero, mission, atau vision --}}
                            @if(!in_array($content->section, ['hero', 'mission', 'vision']))
                                <a href="{{ route('admin.about-contents.edit', $content) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('admin.about-contents.destroy', $content) }}" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            @else
                                <span style="color:#aaa; font-style:italic; font-size: 0.85rem;">
                                    <i class="fas fa-lock"></i> Static Content
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:#999;">
                        <i class="fas fa-inbox" style="font-size:48px;opacity:0.3;display:block;margin-bottom:12px;"></i>
                        No content found. Add your first content!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>

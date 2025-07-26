{{-- resources/views/admin/stories/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Stories')
@section('page-title', 'Stories')

@section('page-actions')
<a href="{{ route('admin.stories.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Story
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stories as $story)
                        <tr>
                            <td>
                                <img src="{{ $story->image_url }}" alt="{{ $story->title_en }}" 
                                     style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                            </td>
                            <td>{{ $story->title_en }}</td>
                            <td>
                                @if($story->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $story->created_at->format('M j, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.stories.edit', $story) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.stories.destroy', $story) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No stories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $stories->links() }}
        </div>
    </div>
</div>
@endsection

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
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Image</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stories as $story)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $story->image_url }}" alt="{{ $story->title_en }}" 
                                     style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                            </td>
                            <td class="text-center">{{ $story->title_en }}</td>
                            <td class="text-center">
                                @if($story->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $story->created_at->format('M j, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.stories.edit', $story) }}" class="btn btn-sm btn-primary me-2">
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

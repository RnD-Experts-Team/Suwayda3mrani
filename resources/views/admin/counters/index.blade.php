{{-- resources/views/admin/counters/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Counters')
@section('page-title', 'Counters')

@section('page-actions')
<a href="{{ route('admin.counters.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Counter
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table rounded">
                <thead>
                    <tr>
                        <th class="text-center">Display</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Title</th>
                        <th class="text-center">Count</th>
                        <th class="text-center">Sort Order</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($counters as $counter)
                        <tr>
                            <td class="text-center">
                                @if($counter->type === 'image' && $counter->image_url)
                                    <img src="{{ $counter->image_url }}" alt="Counter" class="img-fluid" style="max-width: 40px; max-height: 40px;">
                                @elseif($counter->type === 'icon' && $counter->icon)
                                    <i class="{{ $counter->icon }} fa-2x text-brand"></i>
                                @else
                                    <span class="text-muted">No display</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $counter->type === 'image' ? 'success' : 'info' }}">
                                    {{ ucfirst($counter->type) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $counter->title_en }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary fs-6">{{ number_format($counter->count) }}</span>
                            </td>
                            <td class="text-center">{{ $counter->sort_order }}</td>
                            <td class="text-center">
                                @if($counter->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.counters.edit', $counter) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.counters.destroy', $counter) }}" method="POST" class="d-inline">
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
                            <td colspan="7" class="text-center">No counters found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $counters->links() }}
        </div>
    </div>
</div>
@endsection

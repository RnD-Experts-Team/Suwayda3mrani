{{-- resources/views/admin/translations/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Translations')
@section('page-title', 'Translations Management')

@section('page-actions')
<a href="{{ route('admin.translations.create') }}" class="btn btn-primary">
    <i class="fas fa-plus me-2"></i>Add New Translation
</a>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <form method="GET" action="{{ route('admin.translations.index') }}">
            <div class="input-group">
                <select name="group" class="form-select">
                    <option value="all" {{ $group === 'all' ? 'selected' : '' }}>All Groups</option>
                    @foreach($groups as $groupOption)
                        <option value="{{ $groupOption }}" {{ $group === $groupOption ? 'selected' : '' }}>
                            {{ ucfirst($groupOption) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline-secondary">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Key</th>
                        <th class="text-center">Group</th>
                        @foreach($languages as $language)
                            <th class="text-center">{{ $language->name }}</th>
                        @endforeach
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($translations as $translation)
                        <tr>
                            <td><code>{{ $translation->key }}</code></td>
                            <td><span class="badge bg-info">{{ $translation->group }}</span></td>
                            @foreach($languages as $language)
                                <td class="text-center">{{ Str::limit($translation->translations[$language->code] ?? '', 30) }}</td>
                            @endforeach
                            <td class="text-center">
                                @if($translation->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.translations.edit', $translation) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.translations.destroy', $translation) }}" method="POST" class="d-inline">
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
                            <td colspan="100%" class="text-center">No translations found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $translations->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection

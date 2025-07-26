{{-- resources/views/admin/translations/bulk-import.blade.php (Optional) --}}
@extends('admin.layouts.app')

@section('title', 'Bulk Import Translations')
@section('page-title', 'Bulk Import Translations')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Bulk Import Common Translations</h5>
    </div>
    <div class="card-body">
        <p>Click the button below to import common UI translations for your website:</p>
        
        <form action="{{ route('admin.translations.bulk-import') }}" method="POST">
            @csrf
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="overwrite" id="overwrite">
                    <label class="form-check-label" for="overwrite">
                        Overwrite existing translations
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Import Common Translations</button>
            <a href="{{ route('admin.translations.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
        
        <hr class="my-4">
        
        <h6>This will import the following translation groups:</h6>
        <ul>
            <li><strong>Navigation:</strong> Home, Media Gallery, About Us, etc.</li>
            <li><strong>Buttons:</strong> Read More, View Full Story, Back to Stories, etc.</li>
            <li><strong>Sections:</strong> Section titles and descriptions</li>
            <li><strong>General:</strong> Site name, descriptions, footer text</li>
            <li><strong>Forms:</strong> Submit, Cancel, Save, etc.</li>
        </ul>
    </div>
</div>
@endsection

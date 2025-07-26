{{-- resources/views/story.blade.php --}}
@extends('layouts.app')

@section('title', $story->getTitle(app()->getLocale()))

@section('content')
<!-- Story Header -->
<section class="story-header py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" data-aos="fade-up">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Story') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Story Content -->
<section class="story-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <img src="{{ $story->image_url }}" alt="{{ $story->getTitle($locale) }}" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="ps-lg-4">
                    <h1 class="display-5 fw-bold mb-4">{{ $story->getTitle($locale) }}</h1>
                    <div class="story-meta mb-4">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-2"></i>
                            {{ $story->created_at->format('F j, Y') }}
                        </small>
                    </div>
                    <div class="story-text">
                        {!! nl2br($story->getContent($locale)) !!}
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}#stories" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Stories') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Stories -->
<section class="related-stories py-5 bg-light">
    <div class="container">
        <h3 class="mb-4" data-aos="fade-up">{{ __('More Stories') }}</h3>
        <div class="row">
            @php
                $relatedStories = \App\Models\Story::where('is_active', true)
                    ->where('id', '!=', $story->id)
                    ->latest()
                    ->limit(3)
                    ->get();
            @endphp
            
            @foreach($relatedStories as $relatedStory)
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $relatedStory->image_url }}" class="card-img-top" alt="{{ $relatedStory->getTitle($locale) }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedStory->getTitle($locale) }}</h5>
                            <p class="card-text text-muted">{{ $relatedStory->getExcerpt($locale, 80) }}</p>
                            <a href="{{ route('story.show', $relatedStory->id) }}" class="btn btn-sm btn-outline-primary">
                                {{ __('Read More') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

{{-- resources/views/story.blade.php --}}
@extends('layouts.app')

@section('title', $story->getTitle(app()->getLocale()))

@section('content')
<!-- Story Header -->
<section class="story-header py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" data-aos="fade-up">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i>{{ __('Home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}#stories" class="text-decoration-none">{{ __('Stories') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ Str::limit($story->getTitle(app()->getLocale()), 30) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Story Content -->
<section class="story-content py-5">
    <div class="container">
        <!-- Story Header with Image and Title -->
        <div class="row mb-5">
            <div class="col-12" data-aos="fade-up">
                <div class="story-header-section text-center">
                    <div class="story-image-wrapper-main mb-4">
                        <img src="{{ $story->image_url }}" 
                             alt="{{ $story->getTitle(app()->getLocale()) }}" 
                             class="img-fluid rounded-3 shadow-lg story-featured-image"
                             onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPk5vIEltYWdlIEF2YWlsYWJsZTwvdGV4dD48L3N2Zz4=';">
                        <div class="story-badge-overlay">
                            <div class="story-category-badge">
                                <i class="fas fa-heart me-2"></i>{{ __('Story of Hope') }}
                            </div>
                        </div>
                    </div>
                    
                    <h1 class="story-main-title display-5 fw-bold mb-4">{{ $story->getTitle(app()->getLocale()) }}</h1>
                    
                    <div class="story-meta-info d-flex flex-wrap justify-content-center gap-4 mb-4">
                        <div class="meta-item">
                            <i class="fas fa-calendar text-brand me-2"></i>
                            <span class="text-muted">{{ $story->created_at->format('F j, Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock text-brand me-2"></i>
                            <span class="text-muted">{{ ceil(str_word_count(strip_tags($story->getContent(app()->getLocale()))) / 200) }} min read</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-eye text-brand me-2"></i>
                            <span class="text-muted">{{ rand(150, 500) }} views</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Story Body - Single Column Layout -->
        <div class="row">
            <div class="col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="200">
                <div class="story-body-content">
                    <!-- Full HTML Content -->
                    <div class="story-html-content">
                        {!! $story->getContent(app()->getLocale()) !!}
                    </div>
                    
                    <!-- Story Actions -->
                    <div class="story-actions mt-5 pt-4 border-top">
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('home') }}#stories" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Stories') }}
                            </a>
                            <button class="btn btn-outline-secondary" onclick="shareStory()">
                                <i class="fas fa-share-alt me-2"></i>{{ __('Share Story') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Smaller Related Stories Section -->
<section class="related-stories py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-4">
                    <h4 class="section-title fw-bold mb-2" data-aos="fade-up">{{ __('More Stories') }}</h4>
                    <p class="section-subtitle text-muted small mb-0" data-aos="fade-up" data-aos-delay="100">{{ __('Continue reading other inspiring stories') }}</p>
                </div>
            </div>
        </div>
        
        <div class="row g-3">
            @php
                $relatedStories = \App\Models\Story::where('is_active', true)
                    ->where('id', '!=', $story->id)
                    ->latest()
                    ->limit(3)
                    ->get();
            @endphp
            
           @forelse($relatedStories as $relatedStory)
    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="related-story-card-small h-100">
            <div class="related-story-image-small">
                <img src="{{ $relatedStory->image_url }}" 
                     class="related-story-img-small" 
                     alt="{{ $relatedStory->getTitle(app()->getLocale()) }}"
                     loading="lazy"
                     onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjUwIiBoZWlnaHQ9IjE0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlPC90ZXh0Pjwvc3ZnPg==';">
                <div class="related-story-overlay-small">
                    <div class="related-story-date-small">
                        {{ $relatedStory->created_at->format('M d') }}
                    </div>
                </div>
            </div>
            <div class="related-story-content-small p-3">
                <h6 class="related-story-title-small mb-2">{{ Str::limit($relatedStory->getTitle(app()->getLocale()), 60) }}</h6>
                <p class="related-story-excerpt-small text-muted small mb-3">{{ $relatedStory->getExcerpt(app()->getLocale(), 80) }}</p>
                <div class="related-story-footer-small d-flex justify-content-between align-items-center">
                    <a href="{{ route('story.show', $relatedStory->id) }}"
                       style="
                           background-color: #2f9319;
                           color: #fff;
                           padding: 0.4rem 1rem;
                           font-size: 0.875rem;
                           font-weight: 600;
                           border-radius: 6px;
                           text-decoration: none;
                           transition: all 0.3s ease;
                           display: inline-flex;
                           align-items: center;
                           gap: 0.5rem;
                           border: 2px solid #2f9319;
                       "
                       onmouseover="this.style.backgroundColor='#267b15'"
                       onmouseout="this.style.backgroundColor='#2f9319'">
                        <i class="fas fa-book-open"></i> {{ __('Read') }}
                    </a>
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        {{ ceil(str_word_count(strip_tags($relatedStory->getContent(app()->getLocale()))) / 200) }}m
                    </small>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="text-center py-4">
            <i class="fas fa-book-open fa-2x text-muted mb-2"></i>
            <h6 class="text-muted mb-1">{{ __('No more stories available') }}</h6>
            <p class="text-muted small mb-3">{{ __('Check back soon for more inspiring stories') }}</p>
            <a href="{{ route('home') }}#stories" 
               style="
                   background-color: #2f9319;
                   color: #fff;
                   padding: 0.5rem 1.25rem;
                   font-size: 0.875rem;
                   font-weight: 600;
                   border-radius: 6px;
                   text-decoration: none;
                   border: 2px solid #2f9319;
                   display: inline-block;
                   transition: all 0.3s ease;
               "
               onmouseover="this.style.backgroundColor='#267b15'"
               onmouseout="this.style.backgroundColor='#2f9319'">
               {{ __('View All Stories') }}
            </a>
        </div>
    </div>
@endforelse

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function shareStory() {
    if (navigator.share) {
        navigator.share({
            title: '{{ addslashes($story->getTitle(app()->getLocale())) }}',
            text: '{{ addslashes($story->getExcerpt(app()->getLocale(), 100)) }}',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('{{ __("Story link copied to clipboard!") }}');
        }).catch(() => {
            // Final fallback
            const dummy = document.createElement('textarea');
            document.body.appendChild(dummy);
            dummy.value = url;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            alert('{{ __("Story link copied to clipboard!") }}');
        });
    }
}
</script>
@endpush

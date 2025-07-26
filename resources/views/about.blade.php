{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('title', trans_dynamic('page.about_us_title', app()->getLocale()))

@section('content')
<!-- Page Header -->
<section class="page-header position-relative overflow-hidden">
    @php
        $aboutHeaderBg = \App\Models\SiteContent::getContent('page_headers', app()->getLocale())['about_us']['background_image'] ?? null;
    @endphp
    
    @if($aboutHeaderBg)
        <div class="page-header-bg" style="background-image: url('{{ $aboutHeaderBg }}')"></div>
        <div class="page-header-overlay"></div>
    @else
        <div class="page-header-gradient"></div>
    @endif
    
    <div class="container position-relative">
        <div class="row min-vh-50 align-items-center text-white">
            <div class="col-12 text-center py-5">
                <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">
                    {{ trans_dynamic('page.about_us', app()->getLocale()) }}
                </h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="200">
                    {{ trans_dynamic('page.about_us_desc', app()->getLocale()) }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                @if(isset($data['about']))
                <div class="about-content mb-5" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4 text-center">
                        {{ $data['about']['title'] ?? trans_dynamic('section.about_us', app()->getLocale()) }}
                    </h2>
                    <div class="content-text">
                        {!! $data['about']['content'] ?? trans_dynamic('content.about_us_placeholder', app()->getLocale()) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Vision Section -->
<section class="vision-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                @if(isset($data['vision']))
                <div class="vision-content" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-4 text-center">
                        {{ $data['vision']['title'] ?? trans_dynamic('section.our_vision', app()->getLocale()) }}
                    </h2>
                    <div class="content-text">
                        {!! $data['vision']['content'] ?? trans_dynamic('content.our_vision_placeholder', app()->getLocale()) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-content text-center" data-aos="fade-up">
                    <h2 class="display-5 fw-bold mb-5">
                        {{ $data['contact']['title'] ?? trans_dynamic('section.contact_us', app()->getLocale()) }}
                    </h2>
                    
                    <div class="row g-4">
                        @if(isset($data['contact']['phone']))
                        <div class="col-md-6">
                            <div class="contact-item p-4 bg-light rounded">
                                <div class="contact-icon mb-3">
                                    <i class="fas fa-phone fa-2x text-primary"></i>
                                </div>
                                <h5>{{ trans_dynamic('contact.phone', app()->getLocale()) }}</h5>
                                <p class="mb-0">
                                    <a href="tel:{{ $data['contact']['phone'] }}" class="text-decoration-none">
                                        {{ $data['contact']['phone'] }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($data['contact']['whatsapp']))
                        <div class="col-md-6">
                            <div class="contact-item p-4 bg-light rounded">
                                <div class="contact-icon mb-3">
                                    <i class="fab fa-whatsapp fa-2x text-success"></i>
                                </div>
                                <h5>{{ trans_dynamic('contact.whatsapp', app()->getLocale()) }}</h5>
                                <p class="mb-0">
                                    <a href="https://wa.me/{{ $data['contact']['whatsapp'] }}" class="text-decoration-none" target="_blank">
                                        {{ $data['contact']['whatsapp'] }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($data['contact']['email']))
                        <div class="col-md-6">
                            <div class="contact-item p-4 bg-light rounded">
                                <div class="contact-icon mb-3">
                                    <i class="fas fa-envelope fa-2x text-info"></i>
                                </div>
                                <h5>{{ trans_dynamic('contact.email', app()->getLocale()) }}</h5>
                                <p class="mb-0">
                                    <a href="mailto:{{ $data['contact']['email'] }}" class="text-decoration-none">
                                        {{ $data['contact']['email'] }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        @if(isset($data['contact']['address']))
                        <div class="col-md-6">
                            <div class="contact-item p-4 bg-light rounded">
                                <div class="contact-icon mb-3">
                                    <i class="fas fa-map-marker-alt fa-2x text-danger"></i>
                                </div>
                                <h5>{{ trans_dynamic('contact.address', app()->getLocale()) }}</h5>
                                <p class="mb-0">{{ $data['contact']['address'] }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

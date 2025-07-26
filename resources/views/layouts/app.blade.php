{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', trans_dynamic('site.title', app()->getLocale()))</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @if(app()->getLocale() === 'ar')
        <link href="{{ asset('css/rtl.css') }}" rel="stylesheet">
    @endif
</head>
<body>
    <!-- Header -->
    <header class="header fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Dynamic Logo -->
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    @php
                        $logoData = \App\Models\SiteContent::getContent('site_logo', app()->getLocale());
                    @endphp
                    
                    @if($logoData && !empty($logoData['logo_url']))
                        <img src="{{ $logoData['logo_url'] }}" alt="{{ $logoData['alt_text'] ?? 'Logo' }}" height="40" class="me-2 site-logo">
                    @else
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="40" class="me-2 site-logo">
                    @endif
                    <span class="fw-bold text-primary">{{ trans_dynamic('site.name', app()->getLocale()) }}</span>
                </a>

                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                {{ trans_dynamic('nav.home', app()->getLocale()) }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('media') ? 'active' : '' }}" href="{{ route('media') }}">
                                {{ trans_dynamic('nav.media_gallery', app()->getLocale()) }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                                {{ trans_dynamic('nav.about_us', app()->getLocale()) }}
                            </a>
                        </li>
                        
                        <!-- Language Switcher -->
                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-globe me-1"></i>
                                @php
                                    $currentLang = \App\Models\Language::where('code', app()->getLocale())->first();
                                @endphp
                                {{ $currentLang ? $currentLang->name : 'Language' }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(\App\Models\Language::getActive() as $language)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('lang.switch', $language->code) }}">
                                            {{ $language->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>{{ trans_dynamic('site.name', app()->getLocale()) }}</h5>
                    <p class="text-muted">{{ trans_dynamic('site.description', app()->getLocale()) }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="social-links">
                        @foreach(\App\Models\SocialIcon::getActive() as $social)
                            <a href="{{ $social->url }}" class="text-white me-3" target="_blank" 
                               style="color: {{ $social->color }} !important;">
                                <i class="{{ $social->icon_class }}" title="{{ $social->name }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ trans_dynamic('footer.rights', app()->getLocale()) }}</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
    
    @stack('scripts')
</body>
</html>

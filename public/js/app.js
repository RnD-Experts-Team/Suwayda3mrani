/**
 * ===================================
 * LARAVEL PROJECT - MAIN JAVASCRIPT
 * ===================================
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    /**
     * ===================================
     * UTILITY FUNCTIONS
     * ===================================
     */
    
    // Debounce function for performance optimization
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func.apply(this, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(this, args);
        };
    }

    // Throttle function for scroll events
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Format time helper
    function formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = Math.floor(seconds % 60);
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text ? text.replace(/[&<>"']/g, function(m) { return map[m]; }) : '';
    }

    // Test Media URL Function
    function testMediaUrl(url, type) {
        return new Promise((resolve, reject) => {
            if (type === 'image') {
                const img = new Image();
                img.onload = () => resolve(true);
                img.onerror = () => reject(false);
                img.src = url;
            } else if (type === 'video') {
                const video = document.createElement('video');
                video.oncanplay = () => resolve(true);
                video.onerror = () => reject(false);
                video.src = url;
            }
        });
    }

    /**
     * ===================================
     * COUNTER ANIMATION
     * ===================================
     */
    
    function initializeCounters() {
        const counters = document.querySelectorAll('.counter-number');
        
        if (counters.length === 0) return;

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    entry.target.classList.add('animated');
                    animateCounter(entry.target);
                }
            });
        }, observerOptions);

        counters.forEach(counter => {
            observer.observe(counter);
        });
    }

    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const startTime = performance.now();
        
        function updateCounter(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            
            // Easing function for smooth animation
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(easeOut * target);
            
            element.textContent = current.toLocaleString();
            
            if (progress < 1) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        }
        
        requestAnimationFrame(updateCounter);
    }

    /**
     * ===================================
     * MEDIA PREVIEW FUNCTIONALITY
     * ===================================
     */
    
    // Global media preview function for home page
    window.showHomePreview = function(title, type, url) {
        const modal = new bootstrap.Modal(document.getElementById('homePreviewModal'));
        const modalTitle = document.querySelector('#homePreviewModal .modal-title');
        const previewContent = document.getElementById('homePreviewContent');
        
        modalTitle.textContent = `Preview: ${escapeHtml(title)}`;
        
        if (type === 'image') {
            previewContent.innerHTML = `
                <img src="${escapeHtml(url)}" class="img-fluid" style="max-height: 70vh;" 
                     onerror="this.onerror=null; this.outerHTML='<div class=\\'text-danger\\'>Failed to load image</div>';">
            `;
        } else {
            previewContent.innerHTML = `
                <video controls class="w-100" style="max-height: 70vh;" preload="metadata">
                    <source src="${escapeHtml(url)}" type="video/mp4">
                    <source src="${escapeHtml(url)}" type="video/webm">
                    <source src="${escapeHtml(url)}" type="video/ogg">
                    <p class="text-danger">Your browser doesn't support video playback.</p>
                </video>
            `;
        }
        
        modal.show();
    };

    // Global media preview function for media page
    window.showMediaPreview = function(title, type, url) {
        const modal = new bootstrap.Modal(document.getElementById('mediaPreviewModal'));
        const modalTitle = document.querySelector('#mediaPreviewModal .modal-title');
        const previewContent = document.getElementById('mediaPreviewContent');
        
        modalTitle.textContent = `Preview: ${escapeHtml(title)}`;
        
        if (type === 'image') {
            previewContent.innerHTML = `
                <img src="${escapeHtml(url)}" class="img-fluid" style="max-height: 70vh;" 
                     onerror="this.onerror=null; this.outerHTML='<div class=\\'text-danger\\'>Failed to load image</div>';">
            `;
        } else {
            previewContent.innerHTML = `
                <video controls class="w-100" style="max-height: 70vh;" preload="metadata">
                    <source src="${escapeHtml(url)}" type="video/mp4">
                    <source src="${escapeHtml(url)}" type="video/webm">
                    <source src="${escapeHtml(url)}" type="video/ogg">
                    <p class="text-danger">Your browser doesn't support video playback.</p>
                </video>
            `;
        }
        
        modal.show();
    };

    // Global media preview function for admin
    window.showPreview = function(title, type, url) {
        const modal = new bootstrap.Modal(document.getElementById('previewModal'));
        const modalTitle = document.querySelector('#previewModal .modal-title');
        const previewContent = document.getElementById('previewContent');
        
        modalTitle.textContent = `Preview: ${escapeHtml(title)}`;
        
        if (type === 'image') {
            previewContent.innerHTML = `
                <img src="${escapeHtml(url)}" class="img-fluid" style="max-height: 70vh;" 
                     onerror="this.onerror=null; this.outerHTML='<div class=\\'text-danger\\'>Failed to load image</div>';">
            `;
        } else {
            previewContent.innerHTML = `
                <video controls class="w-100" style="max-height: 70vh;" preload="metadata">
                    <source src="${escapeHtml(url)}" type="video/mp4">
                    <source src="${escapeHtml(url)}" type="video/webm">
                    <source src="${escapeHtml(url)}" type="video/ogg">
                    <p class="text-danger">Your browser doesn't support video playback.</p>
                </video>
            `;
        }
        
        modal.show();
    };

    /**
     * ===================================
     * MODAL CLEANUP
     * ===================================
     */
    
    function setupModalCleanup() {
        // Clean up home preview modal
        const homePreviewModal = document.getElementById('homePreviewModal');
        if (homePreviewModal) {
            homePreviewModal.addEventListener('hidden.bs.modal', function() {
                const video = document.querySelector('#homePreviewContent video');
                if (video) {
                    video.pause();
                    video.src = '';
                    video.load();
                }
                document.getElementById('homePreviewContent').innerHTML = '';
            });
        }

        // Clean up media preview modal
        const mediaPreviewModal = document.getElementById('mediaPreviewModal');
        if (mediaPreviewModal) {
            mediaPreviewModal.addEventListener('hidden.bs.modal', function() {
                const video = document.querySelector('#mediaPreviewContent video');
                if (video) {
                    video.pause();
                    video.src = '';
                    video.load();
                }
                document.getElementById('mediaPreviewContent').innerHTML = '';
            });
        }

        // Clean up admin preview modal
        const previewModal = document.getElementById('previewModal');
        if (previewModal) {
            previewModal.addEventListener('hidden.bs.modal', function() {
                const video = document.querySelector('#previewContent video');
                if (video) {
                    video.pause();
                    video.src = '';
                    video.load();
                }
                document.getElementById('previewContent').innerHTML = '';
            });
        }
    }

    /**
     * ===================================
     * MEDIA FILTERING
     * ===================================
     */
    
    function initializeMediaFilters() {
        const filterButtons = document.querySelectorAll('[data-filter]');
        const mediaItems = document.querySelectorAll('.media-grid-item');
        
        if (filterButtons.length === 0) return;

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.dataset.filter;
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter items with animation
                mediaItems.forEach((item, index) => {
                    if (filter === 'all' || item.dataset.type === filter) {
                        item.style.display = 'block';
                        item.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s both`;
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    /**
     * ===================================
     * SMOOTH SCROLLING
     * ===================================
     */
    
    function initializeSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (href === '#' || href === '#top') {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    return;
                }

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerHeight = document.querySelector('.header')?.offsetHeight || 80;
                    const targetPosition = target.offsetTop - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    /**
     * ===================================
     * NAVBAR SCROLL EFFECTS
     * ===================================
     */
    
    function initializeNavbarEffects() {
        const navbar = document.querySelector('.navbar');
        if (!navbar) return;

        const handleScroll = throttle(() => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        }, 100);

        window.addEventListener('scroll', handleScroll);
    }

    /**
     * ===================================
     * FORM ENHANCEMENTS
     * ===================================
     */
    
    function initializeFormEnhancements() {
        // Auto-resize textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });

        // Form validation feedback
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    }

    /**
     * ===================================
     * LAZY LOADING
     * ===================================
     */
    
    function initializeLazyLoading() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        }
    }

    /**
     * ===================================
     * TOOLTIP INITIALIZATION
     * ===================================
     */
    
    function initializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    /**
     * ===================================
     * POPOVER INITIALIZATION
     * ===================================
     */
    
    function initializePopovers() {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }

    /**
     * ===================================
     * PERFORMANCE MONITORING
     * ===================================
     */
    
    function logPerformanceMetrics() {
        if ('performance' in window) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    if (perfData) {
                        console.group('Performance Metrics');
                        console.log('Page Load Time:', Math.round(perfData.loadEventEnd - perfData.fetchStart) + 'ms');
                        console.log('DOM Content Loaded:', Math.round(perfData.domContentLoadedEventEnd - perfData.fetchStart) + 'ms');
                        console.log('First Paint:', Math.round(perfData.responseStart - perfData.fetchStart) + 'ms');
                        console.groupEnd();
                    }
                }, 1000);
            });
        }
    }

    /**
     * ===================================
     * ERROR HANDLING
     * ===================================
     */
    
    function setupErrorHandling() {
        // Global error handler
        window.addEventListener('error', function(e) {
            console.error('Global Error:', {
                message: e.message,
                filename: e.filename,
                lineno: e.lineno,
                colno: e.colno,
                error: e.error
            });
        });

        // Unhandled promise rejection handler
        window.addEventListener('unhandledrejection', function(e) {
            console.error('Unhandled Promise Rejection:', e.reason);
        });
    }

    /**
     * ===================================
     * ACCESSIBILITY ENHANCEMENTS
     * ===================================
     */
    
    function initializeAccessibility() {
        // Skip to main content
        const skipLink = document.createElement('a');
        skipLink.href = '#main-content';
        skipLink.textContent = 'Skip to main content';
        skipLink.className = 'sr-only sr-only-focusable';
        skipLink.style.cssText = `
            position: absolute;
            top: -40px;
            left: 6px;
            z-index: 1050;
            background: #000;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            transition: top 0.3s;
        `;
        
        skipLink.addEventListener('focus', function() {
            this.style.top = '6px';
        });
        
        skipLink.addEventListener('blur', function() {
            this.style.top = '-40px';
        });
        
        document.body.insertBefore(skipLink, document.body.firstChild);

        // Keyboard navigation for modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    const modal = bootstrap.Modal.getInstance(openModal);
                    if (modal) modal.hide();
                }
            }
        });
    }

    /**
     * ===================================
     * THEME MANAGEMENT
     * ===================================
     */
    
    function initializeThemeManagement() {
        const themeToggle = document.querySelector('[data-theme-toggle]');
        if (!themeToggle) return;

        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);

        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }

    /**
     * ===================================
     * INITIALIZATION
     * ===================================
     */
    
    // Initialize all functionality
    try {
        initializeCounters();
        setupModalCleanup();
        initializeMediaFilters();
        initializeSmoothScrolling();
        initializeNavbarEffects();
        initializeFormEnhancements();
        initializeLazyLoading();
        initializeTooltips();
        initializePopovers();
        initializeAccessibility();
        initializeThemeManagement();
        setupErrorHandling();
        
        // Log performance metrics in development
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            logPerformanceMetrics();
        }
        
        console.log('✅ App.js initialized successfully');
        
    } catch (error) {
        console.error('❌ Error initializing app.js:', error);
    }

    /**
     * ===================================
     * CUSTOM EVENTS
     * ===================================
     */
    
    // Dispatch custom event when app is ready
    const appReadyEvent = new CustomEvent('appReady', {
        detail: {
            timestamp: Date.now(),
            userAgent: navigator.userAgent
        }
    });
    
    document.dispatchEvent(appReadyEvent);
});

/**
 * ===================================
 * UTILITY FUNCTIONS (GLOBAL SCOPE)
 * ===================================
 */

// Enhanced Media Preview Helper
function createMediaPreview(title, type, url, description) {
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text ? text.replace(/[&<>"']/g, function(m) { return map[m]; }) : '';
    }
    
    const safeTitle = escapeHtml(title);
    const safeDescription = escapeHtml(description);
    const safeUrl = escapeHtml(url);
    
    return {
        title: safeTitle,
        description: safeDescription,
        url: safeUrl,
        type: type,
        hasDescription: description && description.trim() !== ''
    };
}

// Dynamic counter font sizing
function adjustCounterFontSize() {
    const counterNumbers = document.querySelectorAll('.counter-number-display');
    
    counterNumbers.forEach(function(element) {
        const count = parseInt(element.dataset.count);
        const text = element.textContent;
        
        // Determine font size based on character length and number value
        if (text.length <= 2) {
            element.style.fontSize = '3rem';
        } else if (text.length <= 4) {
            element.style.fontSize = '2.5rem';
        } else if (text.length <= 6) {
            element.style.fontSize = '2rem';
        } else if (text.length <= 8) {
            element.style.fontSize = '1.8rem';
        } else {
            element.style.fontSize = '1.5rem';
        }
        
        element.classList.add('display-counter');
    });
}

// Console styling for development
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    console.log(
        '%c🚀 Laravel Project Loaded Successfully!',
        'background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 10px 20px; border-radius: 8px; font-size: 16px; font-weight: bold;'
    );
}

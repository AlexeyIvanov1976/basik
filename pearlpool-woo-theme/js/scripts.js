/**
 * Main JavaScript for PearlPool WooCommerce Theme
 */

(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        
        // Mobile menu toggle
        initMobileMenu();
        
        // Smooth scroll for anchor links
        initSmoothScroll();
        
        // Header cart functionality
        initHeaderCart();
        
        // Product image hover effect
        initProductHover();
        
        // Sticky header
        initStickyHeader();
        
        // Search functionality
        initSearch();
        
        // Quick view modal
        initQuickView();
        
        // Wishlist functionality
        initWishlist();
        
        // Compare functionality
        initCompare();
        
        // Lazy loading images
        initLazyLoad();
        
        // Newsletter form
        initNewsletterForm();
        
        // Back to top button
        initBackToTop();
    });

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        var $menuToggle = $('.menu-toggle');
        var $navigation = $('.primary-navigation');
        
        $menuToggle.on('click', function() {
            $navigation.toggleClass('active');
            $(this).attr('aria-expanded', $navigation.hasClass('active'));
            
            // Toggle icon
            if ($navigation.hasClass('active')) {
                $(this).html('✕');
                $('body').addClass('menu-open');
            } else {
                $(this).html('☰');
                $('body').removeClass('menu-open');
            }
        });
        
        // Close menu on outside click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.primary-navigation, .menu-toggle').length) {
                $navigation.removeClass('active');
                $menuToggle.html('☰');
                $('body').removeClass('menu-open');
            }
        });
        
        // Submenu toggle for mobile
        $('.menu-item-has-children > a').on('click', function(e) {
            if ($(window).width() <= 768) {
                e.preventDefault();
                $(this).next('.sub-menu').slideToggle(300);
                $(this).parent().toggleClass('menu-open');
            }
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 800);
            }
        });
    }

    /**
     * Header Cart Functionality
     */
    function initHeaderCart() {
        var $headerCart = $('.header-cart');
        var $miniCart = $('.mini-cart');
        
        // Show/hide mini cart on hover (desktop)
        if ($(window).width() > 768) {
            $headerCart.hover(
                function() {
                    $miniCart.stop(true, true).fadeIn(300);
                },
                function() {
                    $miniCart.stop(true, true).fadeOut(300);
                }
            );
        }
        
        // Update cart count via AJAX
        $(document.body).on('added_to_cart removed_from_cart', function() {
            $.ajax({
                url: pearlpool_woo_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_header_cart_fragment'
                },
                success: function(response) {
                    if (response.success) {
                        $('.cart-contents').html(response.data.html);
                    }
                }
            });
        });
    }

    /**
     * Product Image Hover Effect
     */
    function initProductHover() {
        $('.product').hover(
            function() {
                $(this).find('.product-image-wrapper img').css('transform', 'scale(1.05)');
            },
            function() {
                $(this).find('.product-image-wrapper img').css('transform', 'scale(1)');
            }
        );
    }

    /**
     * Sticky Header
     */
    function initStickyHeader() {
        var $header = $('.site-header');
        var lastScrollTop = 0;
        
        $(window).scroll(function() {
            var scrollTop = $(window).scrollTop();
            
            if (scrollTop > 200) {
                $header.addClass('sticky');
                
                // Hide header on scroll down, show on scroll up
                if (scrollTop > lastScrollTop) {
                    $header.addClass('hide');
                } else {
                    $header.removeClass('hide');
                }
            } else {
                $header.removeClass('sticky hide');
            }
            
            lastScrollTop = scrollTop;
        });
    }

    /**
     * Search Functionality
     */
    function initSearch() {
        var $searchToggle = $('.search-toggle');
        var $searchForm = $('.search-form');
        var $searchInput = $searchForm.find('input[type="search"]');
        
        $searchToggle.on('click', function(e) {
            e.preventDefault();
            $searchForm.toggleClass('active');
            
            if ($searchForm.hasClass('active')) {
                $searchInput.focus();
            }
        });
        
        // Close search on outside click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-form, .search-toggle').length) {
                $searchForm.removeClass('active');
            }
        });
        
        // Live search (optional, requires backend support)
        $searchInput.on('input', function() {
            var query = $(this).val();
            
            if (query.length >= 3) {
                // Debounce the search
                clearTimeout($.data(this, 'searchTimer'));
                var searchTimer = setTimeout(function() {
                    performLiveSearch(query);
                }, 300);
                $.data(this, 'searchTimer', searchTimer);
            }
        });
    }

    /**
     * Perform Live Search
     */
    function performLiveSearch(query) {
        $.ajax({
            url: pearlpool_woo_params.ajax_url,
            type: 'POST',
            data: {
                action: 'pearlpool_live_search',
                query: query
            },
            beforeSend: function() {
                $('.search-results').html('<div class="loading">Searching...</div>');
            },
            success: function(response) {
                if (response.success) {
                    $('.search-results').html(response.data.html);
                }
            }
        });
    }

    /**
     * Quick View Modal
     */
    function initQuickView() {
        var $quickViewBtn = $('.quick-view-button');
        var $modal = $('#quick-view-modal');
        
        $quickViewBtn.on('click', function(e) {
            e.preventDefault();
            
            var productId = $(this).data('product_id');
            
            $.ajax({
                url: pearlpool_woo_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'pearlpool_quick_view',
                    product_id: productId
                },
                beforeSend: function() {
                    $modal.html('<div class="loading">Loading...</div>').fadeIn(300);
                },
                success: function(response) {
                    if (response.success) {
                        $modal.html(response.data.html).fadeIn(300);
                    }
                }
            });
        });
        
        // Close modal
        $(document).on('click', '.quick-view-close, .modal-overlay', function() {
            $modal.fadeOut(300);
        });
        
        // Close on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $modal.fadeOut(300);
            }
        });
    }

    /**
     * Wishlist Functionality
     */
    function initWishlist() {
        $(document).on('click', '.wishlist-button', function(e) {
            e.preventDefault();
            
            var $btn = $(this);
            var productId = $btn.data('product_id');
            
            $.ajax({
                url: pearlpool_woo_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'pearlpool_toggle_wishlist',
                    product_id: productId
                },
                beforeSend: function() {
                    $btn.addClass('loading');
                },
                success: function(response) {
                    if (response.success) {
                        $btn.toggleClass('active');
                        
                        // Show notification
                        showNotification(response.data.message);
                    }
                    
                    $btn.removeClass('loading');
                }
            });
        });
    }

    /**
     * Compare Functionality
     */
    function initCompare() {
        $(document).on('click', '.compare-button', function(e) {
            e.preventDefault();
            
            var $btn = $(this);
            var productId = $btn.data('product_id');
            
            $.ajax({
                url: pearlpool_woo_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'pearlpool_toggle_compare',
                    product_id: productId
                },
                beforeSend: function() {
                    $btn.addClass('loading');
                },
                success: function(response) {
                    if (response.success) {
                        $btn.toggleClass('active');
                        showNotification(response.data.message);
                    }
                    
                    $btn.removeClass('loading');
                }
            });
        });
    }

    /**
     * Lazy Loading Images
     */
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Newsletter Form
     */
    function initNewsletterForm() {
        var $newsletterForm = $('.newsletter-form');
        
        $newsletterForm.on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var email = $form.find('input[type="email"]').val();
            
            $.ajax({
                url: pearlpool_woo_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'pearlpool_subscribe_newsletter',
                    email: email
                },
                beforeSend: function() {
                    $form.find('button').prop('disabled', true).text('Subscribing...');
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.data.message, 'success');
                        $form[0].reset();
                    } else {
                        showNotification(response.data.message, 'error');
                    }
                    
                    $form.find('button').prop('disabled', false).text('Subscribe');
                }
            });
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        var $backToTop = $('<button class="back-to-top" aria-label="Back to top">↑</button>');
        $('body').append($backToTop);
        
        $(window).scroll(function() {
            if ($(window).scrollTop() > 500) {
                $backToTop.addClass('visible');
            } else {
                $backToTop.removeClass('visible');
            }
        });
        
        $backToTop.on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 800);
        });
    }

    /**
     * Show Notification
     */
    function showNotification(message, type) {
        type = type || 'info';
        
        var $notification = $('<div class="notification notification-' + type + '">' + message + '</div>');
        
        $('body').append($notification);
        
        setTimeout(function() {
            $notification.addClass('show');
        }, 100);
        
        setTimeout(function() {
            $notification.removeClass('show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 3000);
    }

})(jQuery);

// Global params for JavaScript
var pearlpool_woo_params = {
    ajax_url: '/wp-admin/admin-ajax.php',
    theme_uri: '/wp-content/themes/pearlpool-woo-theme/',
    is_mobile: window.innerWidth <= 768
};

// Update is_mobile on resize
window.addEventListener('resize', function() {
    pearlpool_woo_params.is_mobile = window.innerWidth <= 768;
});

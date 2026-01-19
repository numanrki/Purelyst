/**
 * Purelyst Theme Main JavaScript
 *
 * @package Purelyst
 */

(function () {
    'use strict';

    /**
     * Mobile Menu Toggle
     */
    const initMobileMenu = () => {
        const menuToggle = document.querySelector('[data-menu-toggle]');
        const mobileMenu = document.getElementById('mobile-menu');

        if (!menuToggle || !mobileMenu) return;

        menuToggle.addEventListener('click', () => {
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('is-open');

            // Update icon
            const icon = menuToggle.querySelector('.material-symbols-outlined');
            if (icon) {
                icon.textContent = isExpanded ? 'menu' : 'close';
            }
        });

        // Close menu on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileMenu.classList.contains('is-open')) {
                menuToggle.setAttribute('aria-expanded', 'false');
                mobileMenu.classList.remove('is-open');
                const icon = menuToggle.querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.textContent = 'menu';
                }
            }
        });
    };

    /**
     * Search Toggle
     */
    const initSearchToggle = () => {
        const searchToggle = document.querySelector('[data-search-toggle]');

        if (!searchToggle) return;

        searchToggle.addEventListener('click', () => {
            // Simple search functionality - can be extended
            const searchQuery = prompt('Search for:');
            if (searchQuery && searchQuery.trim()) {
                window.location.href = `${window.location.origin}/?s=${encodeURIComponent(searchQuery.trim())}`;
            }
        });
    };

    /**
     * Load More Posts (AJAX)
     */
    const initLoadMore = () => {
        const loadMoreBtn = document.querySelector('.btn-load-more');

        if (!loadMoreBtn || typeof purelystData === 'undefined') return;

        loadMoreBtn.addEventListener('click', async () => {
            const currentPage = parseInt(loadMoreBtn.dataset.page, 10) || 1;
            const maxPages = parseInt(loadMoreBtn.dataset.maxPages, 10);
            const exclude = loadMoreBtn.dataset.exclude || '';

            // Disable button and show loading state
            loadMoreBtn.disabled = true;
            loadMoreBtn.textContent = 'Loading...';

            try {
                const formData = new FormData();
                formData.append('action', 'purelyst_load_more');
                formData.append('nonce', purelystData.nonce);
                formData.append('page', currentPage + 1);
                formData.append('exclude', exclude);

                const response = await fetch(purelystData.ajaxUrl, {
                    method: 'POST',
                    body: formData,
                });

                const data = await response.json();

                if (data.success && data.data.html) {
                    // Append new posts
                    const grid = document.querySelector('.articles-grid');
                    if (grid) {
                        grid.insertAdjacentHTML('beforeend', data.data.html);
                    }

                    // Update button state
                    loadMoreBtn.dataset.page = currentPage + 1;

                    if (!data.data.has_more) {
                        loadMoreBtn.remove();
                    } else {
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = purelystData.loadMoreText || 'Load More Stories';
                    }
                } else {
                    loadMoreBtn.remove();
                }
            } catch (error) {
                console.error('Error loading more posts:', error);
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = purelystData.loadMoreText || 'Load More Stories';
            }
        });
    };

    /**
     * Smooth scroll for anchor links
     */
    const initSmoothScroll = () => {
        document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener('click', (e) => {
                const targetId = anchor.getAttribute('href');
                if (targetId === '#') return;

                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                    });
                }
            });
        });
    };

    /**
     * Header scroll behavior
     */
    const initHeaderScroll = () => {
        const header = document.querySelector('.site-header');
        if (!header) return;

        let lastScrollY = window.scrollY;
        let ticking = false;

        const updateHeader = () => {
            const currentScrollY = window.scrollY;

            if (currentScrollY > 100) {
                header.style.boxShadow = 'var(--shadow-soft)';
            } else {
                header.style.boxShadow = 'none';
            }

            lastScrollY = currentScrollY;
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });
    };

    /**
     * Dark mode toggle (optional enhancement)
     */
    const initDarkMode = () => {
        // Check for saved preference or system preference
        const savedTheme = localStorage.getItem('purelyst_theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            document.documentElement.classList.add('dark');
        }

        // Listen for system preference changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('purelyst_theme')) {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        });
    };

    /**
     * Newsletter form submission
     */
    const initNewsletterForm = () => {
        const forms = document.querySelectorAll('.newsletter-form, .newsletter-form-single');
        
        forms.forEach((form) => {
            if (!form || form.getAttribute('action') !== '#') return;

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const emailInput = form.querySelector('input[type="email"]');
                if (emailInput && emailInput.value) {
                    alert('Thank you for subscribing! (Configure your email service in Theme Customizer)');
                    emailInput.value = '';
                }
            });
        });
    };

    /**
     * Reading Progress Bar
     */
    const initReadingProgress = () => {
        const progressBar = document.getElementById('reading-progress');
        const article = document.querySelector('.single-article, .post-content');

        if (!progressBar || !article) return;

        const updateProgress = () => {
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollY = window.scrollY;

            // Calculate how far we've scrolled through the article
            const start = articleTop - windowHeight / 2;
            const end = articleTop + articleHeight - windowHeight / 2;
            const progress = Math.max(0, Math.min(1, (scrollY - start) / (end - start)));

            progressBar.style.width = `${progress * 100}%`;
        };

        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    updateProgress();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        // Initial update
        updateProgress();
    };

    /**
     * Share Button Functionality
     */
    const initShareButton = () => {
        const shareButtons = document.querySelectorAll('.share-btn');

        shareButtons.forEach((btn) => {
            btn.addEventListener('click', async () => {
                const url = btn.dataset.url || window.location.href;
                const title = btn.dataset.title || document.title;

                // Use Web Share API if available
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: title,
                            url: url,
                        });
                    } catch (err) {
                        // User cancelled or error
                        if (err.name !== 'AbortError') {
                            copyToClipboard(url);
                        }
                    }
                } else {
                    // Fallback: copy to clipboard
                    copyToClipboard(url);
                }
            });
        });
    };

    /**
     * Copy to Clipboard Helper
     */
    const copyToClipboard = (text) => {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link copied to clipboard!');
            }).catch(() => {
                fallbackCopyToClipboard(text);
            });
        } else {
            fallbackCopyToClipboard(text);
        }
    };

    const fallbackCopyToClipboard = (text) => {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-9999px';
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            alert('Link copied to clipboard!');
        } catch (err) {
            alert('Could not copy link. Please copy manually: ' + text);
        }
        document.body.removeChild(textArea);
    };

    /**
     * Initialize all functions on DOM ready
     */
    const init = () => {
        initMobileMenu();
        initSearchToggle();
        initLoadMore();
        initSmoothScroll();
        initHeaderScroll();
        initDarkMode();
        initNewsletterForm();
        initReadingProgress();
        initShareButton();
    };

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

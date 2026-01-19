/**
 * Purelyst Theme Customizer Preview
 *
 * @package Purelyst
 */

(function ($) {
    'use strict';

    // Site title
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.logo-text, .footer-logo-text').text(to);
        });
    });

    // Hero badge text
    wp.customize('purelyst_hero_badge', function (value) {
        value.bind(function (to) {
            $('.featured-badge').contents().last().replaceWith(to);
        });
    });

    // Hero button text
    wp.customize('purelyst_hero_button_text', function (value) {
        value.bind(function (to) {
            $('.hero-cta .btn-primary').contents().first().replaceWith(to + ' ');
        });
    });

    // Newsletter title
    wp.customize('purelyst_newsletter_title', function (value) {
        value.bind(function (to) {
            $('.newsletter-title').text(to);
        });
    });

    // Newsletter description
    wp.customize('purelyst_newsletter_description', function (value) {
        value.bind(function (to) {
            $('.newsletter-description').text(to);
        });
    });

    // Newsletter button text
    wp.customize('purelyst_newsletter_button_text', function (value) {
        value.bind(function (to) {
            $('.btn-newsletter').text(to);
        });
    });

    // Newsletter disclaimer
    wp.customize('purelyst_newsletter_disclaimer', function (value) {
        value.bind(function (to) {
            $('.newsletter-disclaimer').text(to);
        });
    });

    // Footer tagline
    wp.customize('purelyst_footer_tagline', function (value) {
        value.bind(function (to) {
            $('.footer-tagline').text(to);
        });
    });

    // Subscribe button text
    wp.customize('purelyst_header_subscribe_text', function (value) {
        value.bind(function (to) {
            $('.btn-subscribe').text(to);
        });
    });

    // Recent posts title
    wp.customize('purelyst_recent_posts_title', function (value) {
        value.bind(function (to) {
            $('.section-title').first().text(to);
        });
    });

    // Popular topics title
    wp.customize('purelyst_topics_title', function (value) {
        value.bind(function (to) {
            $('.widget-topics-title').text(to);
        });
    });

    // Load more button text
    wp.customize('purelyst_load_more_text', function (value) {
        value.bind(function (to) {
            $('.btn-load-more').text(to);
        });
    });

    // Primary color
    wp.customize('purelyst_primary_color', function (value) {
        value.bind(function (to) {
            document.documentElement.style.setProperty('--color-primary', to);
        });
    });

    // Accent color
    wp.customize('purelyst_accent_color', function (value) {
        value.bind(function (to) {
            document.documentElement.style.setProperty('--color-accent', to);
        });
    });

})(jQuery);

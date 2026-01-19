/**
 * Purelyst Theme Admin JavaScript
 *
 * @package Purelyst
 */

(function($) {
    'use strict';

    /**
     * Purelyst Admin Controller
     */
    const PurelystAdmin = {
        
        /**
         * Initialize
         */
        init: function() {
            this.bindEvents();
            this.initColorPickers();
            this.initRangeSliders();
        },

        /**
         * Bind Events
         */
        bindEvents: function() {
            // Tab switching
            $(document).on('click', '.purelyst-tab', this.handleTabSwitch);

            // Save settings
            $(document).on('click', '#purelyst-save-btn', this.handleSave);

            // Reset settings
            $(document).on('click', '#purelyst-reset-btn', this.handleReset);

            // Device preview toggle
            $(document).on('click', '.purelyst-device-btn', this.handleDeviceToggle);

            // Update preview on input change
            $(document).on('change input', '#purelyst-settings-form input, #purelyst-settings-form select', this.updatePreview);

            // Media uploads
            $(document).on('click', '#upload-logo-btn', this.handleLogoUpload);
            $(document).on('click', '#remove-logo-btn', this.handleLogoRemove);
            $(document).on('click', '#upload-favicon-btn', this.handleFaviconUpload);
            $(document).on('click', '#remove-favicon-btn', this.handleFaviconRemove);
        },

        /**
         * Handle Logo Upload
         */
        handleLogoUpload: function(e) {
            e.preventDefault();
            
            const frame = wp.media({
                title: 'Select or Upload Logo',
                button: { text: 'Use as Logo' },
                multiple: false
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                $('#site_logo').val(attachment.id);
                $('#logo-preview')
                    .addClass('has-image')
                    .html('<img src="' + attachment.url + '" alt="">');
                $('#remove-logo-btn').show();
            });

            frame.open();
        },

        /**
         * Handle Logo Remove
         */
        handleLogoRemove: function(e) {
            e.preventDefault();
            $('#site_logo').val('');
            $('#logo-preview')
                .removeClass('has-image')
                .html('<span class="material-symbols-outlined">add_photo_alternate</span><span class="purelyst-media-text">Upload Logo</span>');
            $('#remove-logo-btn').hide();
        },

        /**
         * Handle Favicon Upload
         */
        handleFaviconUpload: function(e) {
            e.preventDefault();
            
            const frame = wp.media({
                title: 'Select or Upload Favicon',
                button: { text: 'Use as Favicon' },
                multiple: false
            });

            frame.on('select', function() {
                const attachment = frame.state().get('selection').first().toJSON();
                $('#site_favicon').val(attachment.id);
                $('#favicon-preview')
                    .addClass('has-image')
                    .html('<img src="' + attachment.url + '" alt="">');
                $('#remove-favicon-btn').show();
            });

            frame.open();
        },

        /**
         * Handle Favicon Remove
         */
        handleFaviconRemove: function(e) {
            e.preventDefault();
            $('#site_favicon').val('');
            $('#favicon-preview')
                .removeClass('has-image')
                .html('<span class="material-symbols-outlined">add_photo_alternate</span>');
            $('#remove-favicon-btn').hide();
        },

        /**
         * Initialize Color Pickers
         */
        initColorPickers: function() {
            $('.purelyst-color-picker').wpColorPicker({
                change: function(event, ui) {
                    PurelystAdmin.updatePreview();
                },
                clear: function() {
                    PurelystAdmin.updatePreview();
                }
            });
        },

        /**
         * Initialize Range Sliders
         */
        initRangeSliders: function() {
            $('.purelyst-range').each(function() {
                const $range = $(this);
                const $field = $range.closest('.purelyst-field');
                const $value = $field.find('.purelyst-range-value, .purelyst-range-badge');

                $range.on('input', function() {
                    const val = $(this).val();
                    const name = $(this).attr('name');
                    
                    if (name === 'container_width' || name === 'body_font_size') {
                        $value.text(val + 'px');
                    } else {
                        $value.text(val);
                    }
                });
            });
        },

        /**
         * Handle Tab Switch
         */
        handleTabSwitch: function(e) {
            e.preventDefault();
            
            const $tab = $(this);
            const tabId = $tab.data('tab');

            // Update tab states
            $('.purelyst-tab').removeClass('active');
            $tab.addClass('active');

            // Update panel states
            $('.purelyst-tab-panel').removeClass('active');
            $(`.purelyst-tab-panel[data-panel="${tabId}"]`).addClass('active');
        },

        /**
         * Handle Device Toggle
         */
        handleDeviceToggle: function(e) {
            e.preventDefault();
            
            const $btn = $(this);
            const device = $btn.data('device');

            // Update button states
            $('.purelyst-device-btn').removeClass('active');
            $btn.addClass('active');

            // Could add preview scaling logic here for mobile preview
            if (device === 'mobile') {
                $('.purelyst-preview-card').css({
                    'max-width': '320px',
                    'margin': '0 auto'
                });
            } else {
                $('.purelyst-preview-card').css({
                    'max-width': 'none',
                    'margin': '0'
                });
            }
        },

        /**
         * Handle Save
         */
        handleSave: function(e) {
            e.preventDefault();

            const $btn = $(this);
            const originalText = $btn.html();

            // Show loading state
            $btn.prop('disabled', true).html('<span class="purelyst-spinner"></span> ' + purelystAdmin.saving);

            // Collect settings
            const settings = PurelystAdmin.collectSettings();

            // Send AJAX request
            $.ajax({
                url: purelystAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'purelyst_save_settings',
                    nonce: purelystAdmin.nonce,
                    settings: settings
                },
                success: function(response) {
                    if (response.success) {
                        PurelystAdmin.showToast(purelystAdmin.saved, 'success');
                    } else {
                        PurelystAdmin.showToast(response.data.message || purelystAdmin.error, 'error');
                    }
                },
                error: function() {
                    PurelystAdmin.showToast(purelystAdmin.error, 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        },

        /**
         * Handle Reset
         */
        handleReset: function(e) {
            e.preventDefault();

            if (!confirm(purelystAdmin.resetConfirm)) {
                return;
            }

            const $btn = $(this);
            const originalText = $btn.html();

            // Show loading state
            $btn.prop('disabled', true).html('<span class="purelyst-spinner"></span> ' + purelystAdmin.resetting);

            // Send AJAX request
            $.ajax({
                url: purelystAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'purelyst_reset_settings',
                    nonce: purelystAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Reload page to show default values
                        window.location.reload();
                    } else {
                        PurelystAdmin.showToast(response.data.message || purelystAdmin.error, 'error');
                    }
                },
                error: function() {
                    PurelystAdmin.showToast(purelystAdmin.error, 'error');
                },
                complete: function() {
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        },

        /**
         * Collect Settings from Form
         */
        collectSettings: function() {
            const settings = {};
            const $form = $('#purelyst-settings-form');

            // Text inputs and selects
            $form.find('input[type="text"], input[type="number"], input[type="range"], select').each(function() {
                const $input = $(this);
                const name = $input.attr('name');
                
                if (name && !$input.hasClass('wp-color-picker')) {
                    settings[name] = $input.val();
                }
            });

            // Hidden inputs (for logo and favicon)
            $form.find('input[type="hidden"]').each(function() {
                const $input = $(this);
                const name = $input.attr('name');
                
                if (name) {
                    settings[name] = $input.val();
                }
            });

            // Checkboxes (toggles)
            $form.find('input[type="checkbox"]').each(function() {
                const $input = $(this);
                const name = $input.attr('name');
                
                if (name) {
                    settings[name] = $input.is(':checked') ? 1 : 0;
                }
            });

            // Color pickers
            $form.find('.purelyst-color-picker').each(function() {
                const $input = $(this);
                const name = $input.attr('name');
                
                if (name) {
                    settings[name] = $input.wpColorPicker('color');
                }
            });

            return settings;
        },

        /**
         * Update Preview (live updates)
         */
        updatePreview: function() {
            const settings = PurelystAdmin.collectSettings();
            const $previewCard = $('.purelyst-preview-card');
            const $previewTitle = $previewCard.find('.purelyst-preview-title');
            const $previewExcerpt = $previewCard.find('.purelyst-preview-excerpt');

            // Update title font weight
            if (settings.heading_weight) {
                $previewTitle.css('font-weight', settings.heading_weight);
            }

            // Update title letter spacing
            if (settings.heading_letter_spacing) {
                $previewTitle.css('letter-spacing', settings.heading_letter_spacing);
            }

            // Update title line height
            if (settings.heading_line_height) {
                $previewTitle.css('line-height', settings.heading_line_height);
            }

            // Update body font size
            if (settings.body_font_size) {
                $previewExcerpt.css('font-size', settings.body_font_size + 'px');
            }

            // Update colors
            if (settings.primary_color) {
                $previewCard.find('.purelyst-preview-badge').css('color', settings.primary_color);
                $previewTitle.css('color', settings.primary_color);
            }

            if (settings.accent_color) {
                $previewCard.find('.purelyst-preview-author-avatar').css('background-color', settings.accent_color);
            }
        },

        /**
         * Show Toast Notification
         */
        showToast: function(message, type) {
            // Remove existing toast
            $('.purelyst-toast').remove();

            // Create toast
            const icon = type === 'success' ? 'check_circle' : 'error';
            const $toast = $(`
                <div class="purelyst-toast ${type}">
                    <span class="material-symbols-outlined">${icon}</span>
                    <span>${message}</span>
                </div>
            `);

            // Append to body
            $('body').append($toast);

            // Show toast
            setTimeout(function() {
                $toast.addClass('show');
            }, 100);

            // Auto hide after 3 seconds
            setTimeout(function() {
                $toast.removeClass('show');
                setTimeout(function() {
                    $toast.remove();
                }, 300);
            }, 3000);
        }
    };

    /**
     * Document Ready
     */
    $(document).ready(function() {
        PurelystAdmin.init();
    });

})(jQuery);

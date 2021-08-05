define([
    'jquery',
    'TYPO3/CMS/Skins/ColorPicker'
], function(
    $,
    ColorPicker
) {

    let extension = '#rubb1-skins-toolbar-darkmode';

    // prevent dropdown from closing
    $(extension+ ' .dropdown-menu').click(function (e) {
        e.stopPropagation()
    })

    // custom checkbox - change value of input
    $('.custom-skin-change-trigger label').click(function () {
        if ($(this).siblings('input').val() === "0") {
            $(this).siblings('input').val(1)
        } else {
            $(this).siblings('input').val(0)
        }
    })

    /**
     * init color picker
     * https://www.jqueryscript.net/other/Color-Picker-Plugin-jQuery-MiniColors.html
     */
    $('.colorpicker-input').minicolors({

        // animation speed
        animationSpeed: 50,

        // easing function
        animationEasing: 'swing',

        // defers the change event from firing while the user makes a selection
        changeDelay: 0,

        // hue, brightness, saturation, or wheel
        control: 'hue',

        // default color
        defaultValue: '',

        // hex or rgb
        format: 'rgb',

        // show/hide speed
        showSpeed: 100,
        hideSpeed: 100,

        // is inline mode?
        inline: false,

        // a comma-separated list of keywords that the control should accept (e.g. inherit, transparent, initial).
        //keywords: 'transparent',

        // uppercase or lowercase
        letterCase: 'lowercase',

        // enables opacity slider
        opacity: true,

        // custom position
        position: 'bottom left',

        // additional theme class
        //theme: 'default',

        // an array of colors that will show up under the main color <a href="https://www.jqueryscript.net/tags.php?/grid/">grid</a>
        swatches: [],

        // Fires when the value of the color picker changes
        change: function () {
            // change css variables instantly to receive a preview in the live backend
            let colorId = $(this).data('color-id');
            let colorVal = $(this).val();
            document.documentElement.style.setProperty('--color-'+colorId, colorVal);
            let iframe = $("#typo3-contentIframe").contents().find("head");
            iframe.find('#color-'+colorId).remove();
            iframe.append('<style id="color-'+colorId+'">:root {--color-'+colorId+': '+colorVal+'; }</style>');
        },

        // Fires when the color picker is hidden.
        hide: null,

        // Fires when the color picker is shown.
        show: null

    });

    // load user settings for color picker
    require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
        new AjaxRequest(TYPO3.settings.ajaxUrls.load_settings)
            .get()
            .then(async function (response) {
                const resolved = await response.resolve();

                // set variables
                let color1 = resolved.result['tx_skins_custom_color_1'],
                    color2 = resolved.result['tx_skins_custom_color_2'],
                    color4 = resolved.result['tx_skins_custom_color_4'],
                    color5 = resolved.result['tx_skins_custom_color_5'],
                    color6 = resolved.result['tx_skins_custom_color_6'],
                    color7 = resolved.result['tx_skins_custom_color_7'],
                    color8 = resolved.result['tx_skins_custom_color_8'],
                    customSkinStatus = resolved.result['tx_skins_darkmode'];

                let skinsToolbar = $('#rubb1-skins-toolbar-darkmode');

                // custom skin checkbox
                if (customSkinStatus) {
                    skinsToolbar.find('#custom-skin').trigger('click');
                    skinsToolbar.find('#custom-skin').val(1);
                } else {
                    skinsToolbar.find('#custom-skin').val(0);
                }

                // color 1
                skinsToolbar.find('.color-1 input').val(color1);
                skinsToolbar.find('.color-1 .minicolors-swatch-color').css('background-color',color1);

                // color 2
                skinsToolbar.find('.color-2 input').val(color2);
                skinsToolbar.find('.color-2 .minicolors-swatch-color').css('background-color',color2);

                // color 4
                skinsToolbar.find('.color-4 input').val(color4);
                skinsToolbar.find('.color-4 .minicolors-swatch-color').css('background-color',color4);

                // color 5
                skinsToolbar.find('.color-5 input').val(color5);
                skinsToolbar.find('.color-5 .minicolors-swatch-color').css('background-color',color5);

                // color 6
                skinsToolbar.find('.color-6 input').val(color6);
                skinsToolbar.find('.color-6 .minicolors-swatch-color').css('background-color',color6);

                // color 7
                skinsToolbar.find('.color-7 input').val(color7);
                skinsToolbar.find('.color-7 .minicolors-swatch-color').css('background-color',color7);

                // color 8
                skinsToolbar.find('.color-8 input').val(color8);
                skinsToolbar.find('.color-8 .minicolors-swatch-color').css('background-color',color8);
            });
    });

    // save color settings to be user
    $('.save-skin-settings').click(function () {
        require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
            let settingsArray = [];
            $('#rubb1-skins-toolbar-darkmode input').each(function(){
                settingsArray[$(this).attr('id')] = $(this).val();
            })
            new AjaxRequest(TYPO3.settings.ajaxUrls.save_settings)
                .withQueryArguments({input: settingsArray})
                .get()
                .then(async function (response) {
                    const resolved = await response.resolve();
                    if (resolved['result']) {
                        location.reload();
                    }
                });
        });
    })


    return true;
});
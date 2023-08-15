define([
    'jquery',
], function (
    $,
    ColorPicker
) {

    let extension = '#rubb1-skins-toolbar-darkmode';

    // prevent dropdown from closing
    $(extension + ' .dropdown-menu').click(function (e) {
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

    $('.colorpicker-input').change(function () {
        // change css variables instantly to receive a preview in the live backend
        let colorId = $(this).data('color-id');
        let colorVal = $(this).val();
        document.documentElement.style.setProperty('--color-' + colorId, colorVal);
        let iframe = $("#typo3-contentIframe").contents().find("head");
        iframe.find('#color-' + colorId).remove();
        iframe.append('<style id="color-' + colorId + '">:root {--color-' + colorId + ': ' + colorVal + '; }</style>');
    })

    // load user settings for color picker
    require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
        new AjaxRequest(TYPO3.settings.ajaxUrls.load_settings)
            .get()
            .then(async function (response) {
                const resolved = await response.resolve();
                const settingsObject = JSON.parse(resolved.result.tx_skins_dark_mode_settings);

                let skinsToolbar = $(extension);

                for (const key in settingsObject) {
                    // set color
                    skinsToolbar.find('.' + key + ' input').val(settingsObject[key]);
                    skinsToolbar.find('.' + key + ' .minicolors-swatch-color').css('background-color', settingsObject[key]);
                }

                skinsToolbar.find('#tx_skins_active').val(0);
                // custom skin checkbox
                if (resolved.result.tx_skins_active > 0) {
                    skinsToolbar.find('#tx_skins_active').trigger('click');
                    skinsToolbar.find('#tx_skins_active').val(1);
                }
            });
    });

    // save color settings to be user
    $('.save-skin-settings').click(function () {
        require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
            let settingsArray = {};
            $('#rubb1-skins-toolbar-darkmode .colorpicker-input').each(function () {
                settingsArray[$(this).attr('id')] = $(this).val();
            })
            let requestArray = [];
            requestArray['tx_skins_active'] = $('#rubb1-skins-toolbar-darkmode #tx_skins_active').val();
            requestArray['tx_skins_dark_mode_settings'] = JSON.stringify(settingsArray);
            new AjaxRequest(TYPO3.settings.ajaxUrls.save_settings)
                .withQueryArguments({input: requestArray})
                .get()
                .then(async function (response) {
                    const resolved = await response.resolve();
                    if (resolved.result) {
                        location.reload();
                    }
                });
        });
    })


    return true;
});
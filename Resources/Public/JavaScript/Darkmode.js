define([], function () {

    const extension = document.getElementById('rubb1-skins-toolbar-darkmode');

    // prevent dropdown from closing
    extension.querySelectorAll('.dropdown-menu')[0].addEventListener("click", function (e) {
        e.stopPropagation();
    });

    // custom checkbox - change value of input
    extension.querySelectorAll('.custom-skin-change-trigger label').forEach((element) => {
        element.addEventListener("click", function () {
            if (this.previousElementSibling.value === "0") {
                this.previousElementSibling.value = 1;
            } else {
                this.previousElementSibling.value = 0;
            }
        })
    })

    extension.querySelectorAll('.colorpicker-input').forEach((element) => {
        element.addEventListener("input", function () {
            // change css variables instantly to receive a preview in the live backend
            let colorId = this.dataset.colorId;
            let colorVal = this.value;
            document.documentElement.style.setProperty('--color-' + colorId, colorVal);
            let iframe = document.getElementById("typo3-contentIframe");
            let iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            if (iframeDocument) {
                let iframeHead = iframeDocument.querySelectorAll("head")[0];

                if (iframeHead.querySelectorAll('#color-' + colorId).length) {
                    iframeHead.querySelectorAll('#color-' + colorId)[0].remove();
                }

                // create style tag
                let style = document.createElement("style");
                let styleContent = document.createTextNode(":root {--color-" + colorId + ": " + colorVal + "; }");
                style.appendChild(styleContent);
                style.setAttribute("id", "color-" + colorId);
                iframeHead.appendChild(style);
            }
        })
    })

    // load user settings for color picker
    require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
        new AjaxRequest(TYPO3.settings.ajaxUrls.load_settings)
            .get()
            .then(async function (response) {
                const resolved = await response.resolve();
                const settingsObject = JSON.parse(resolved.result.tx_skins_dark_mode_settings);

                for (const key in settingsObject) {
                    // set color
                    extension.querySelectorAll('.' + key + ' input')[0].value = settingsObject[key];
                }

                extension.querySelectorAll('#tx_skins_active').value = 0;
                // custom skin checkbox
                if (resolved.result.tx_skins_active > 0) {
                    extension.querySelectorAll('#tx_skins_active')[0].click();
                    extension.querySelectorAll('#tx_skins_active')[0].value = 1;
                }
            });
    });

    // save color settings to be user
    extension.querySelectorAll('.save-skin-settings')[0].addEventListener("click", function () {
        require(['TYPO3/CMS/Core/Ajax/AjaxRequest'], function (AjaxRequest) {
            let settingsArray = {};
            extension.querySelectorAll('.colorpicker-input').forEach((element) => {
                settingsArray[element.getAttribute("id")] = element.value;
            })
            let requestArray = [];
            requestArray['tx_skins_active'] = extension.querySelectorAll('#rubb1-skins-toolbar-darkmode #tx_skins_active')[0].value;
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
    });

    return true;
});

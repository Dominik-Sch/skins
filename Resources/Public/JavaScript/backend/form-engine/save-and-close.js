import FormEngine from '@typo3/backend/form-engine.js';
import Icons from '@typo3/backend/icons.js';

/** @type {HTMLButtonElement | null} */
const button = document.querySelector('[name="_skins_saveandclosedok"]');
if (button) {
    button.addEventListener('click', e => {
        e.preventDefault();
        button.disabled = true;
        FormEngine.saveAndCloseDocument();
        Icons.getIcon('spinner-circle-light', Icons.sizes.small, null, 'disabled').then(icon => {
            button.querySelector('.t3js-icon').outerHTML = icon;
        });
    });
}

// copying iframe text, to include in another page

const copyButton = document.querySelector('.iframe__copy');

copyButton.addEventListener('click', e => {
    e.preventDefault();
    let copyText = document.querySelector('.iframe__text');
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    document.execCommand("copy");
    copyText.setSelectionRange(0, 0);
})
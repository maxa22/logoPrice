 const file = document.getElementById('calculator-logo');

 file.addEventListener('change', e => {
    const container = e.target.parentElement;
    const span = container.querySelector('span');
    const label = container.querySelector('label');
    if(e.target.files.length > 0) {
        span.innerHTML = e.target.files[0].name;
        label.innerHTML = 'Logo uploaded';
    }
});

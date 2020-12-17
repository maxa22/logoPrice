const addOption = document.querySelector('.add-option');

addOption.addEventListener('click', e => {
        e.preventDefault();
        let optionContainer = document.querySelector('.calculator-option');
        let optionCount = optionContainer.querySelectorAll('.edit-form__option').length + 1;   

        const optionDiv = document.createElement('div');
        optionDiv.classList.add('edit-form__option');
        optionDiv.innerHTML = `
                <h3>Option ${optionCount}</h3>
                <div>
                        <label for="name-${optionCount}">Answer</label>
                        <input type="text" name="${optionCount}name" id="name-${optionCount}" placeholder="Answer">
                </div>
                <div>
                        <label for="price-${optionCount}">Price</label>
                        <input type="number" name="${optionCount}price" id="price-${optionCount}" placeholder="Price">
                </div>
                <div>
                        <label for="url-${optionCount}" class="file__label">Upload Image</label>
                        <input type="file" name="${optionCount}url" id="url-${optionCount}" class="new-option">
                        <span class="file__name"></span>
                </div>
        
        `
        optionContainer.appendChild(optionDiv);
})

const message = document.querySelector('.message');

setTimeout(hide, 3000 );

function hide() {
        message.style.display= 'none';
}
const files = document.querySelectorAll('input[type="file"]');


for(const file of files) {
        file.addEventListener('change', () => {
            const container = file.parentElement;
            const span = container.querySelector('span');
            const label = container.querySelector('label');
            if(file.files.length > 0) {
                span.innerHTML = file.files[0].name;
                label.innerHTML = 'Image uploaded';
            }
        })
    }

document.querySelector('.calculator-option').addEventListener('click', e => {
        if(e.target.classList.contains('new-option')) {
            e.target.addEventListener('change', () => {
                const container = e.target.parentElement;
                const span = container.querySelector('span');
                const label = container.querySelector('label');
                if(e.target.files.length > 0) {
                    span.innerHTML = e.target.files[0].name;
                    label.innerHTML = 'Image uploaded';
            }
            })
        }
});
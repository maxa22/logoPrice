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
                        <input type="text" name="name${optionCount}" id="name-${optionCount}" placeholder="Answer">
                </div>
                <div>
                        <label for="price-${optionCount}">Price</label>
                        <input type="number" name="${optionCount}price" id="price-${optionCount}" placeholder="Price">
                </div>
                <div>
                        <label for="url-${optionCount}">Image Url</label>
                        <input type="text" name="url${optionCount}" id="url-${optionCount}" placeholder="Image url">
                </div>
        
        `
        optionContainer.appendChild(optionDiv);
})


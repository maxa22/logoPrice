const editbtns = document.querySelectorAll('.form .edit-icon');
const calcelBtns = document.querySelectorAll('.cancel');
const options = document.querySelectorAll('.edit-form__option');
const questions = document.querySelectorAll('.edit-form__question-container');



for(let edit of editbtns) {
    edit.addEventListener('click', e => {
        disableInput();
        curentOption = e.currentTarget.parentElement.parentElement;
        curentOption.classList.remove('disabled');
        curentOption.classList.add('active');
        const inputs = curentOption.querySelectorAll('input');
        for(let input of inputs) {
            input.removeAttribute('disabled');
        }
    })
}

for(const cancel of calcelBtns) {
    cancel.addEventListener('click', e => {
        e.preventDefault();
        removeClasses();
        const currentOption = e.currentTarget.parentElement;
        const inputs = currentOption.querySelectorAll('input');
        for(let input of inputs) {
            input.setAttribute('disabled', 'true');
        }
    })
}

const addOptions = document.querySelectorAll('.add-option');

for(const addOption of addOptions) {
    addOption.addEventListener('click', e => {
            e.preventDefault();
            const questionContainer = e.currentTarget.parentElement;
            const optionContainer = questionContainer.querySelector('.calculator-option');
            const optionCount = optionContainer.querySelectorAll('.edit-form__option').length + 1;   
            const optionDiv = document.createElement('div');
            optionDiv.classList.add('edit-form__option');
            optionDiv.classList.add('active');
            console.log({questionContainer});
            const id = questionContainer.getAttribute('data-id');
            optionDiv.innerHTML = `
                    <h3>Option ${optionCount}</h3>
                    <div>
                            <label for="name-${optionCount}">Answer</label>
                            <input type="text" name="${id}-name" id="name-${optionCount}" placeholder="Answer">
                    </div>
                    <div>
                            <label for="price-${optionCount}">Price</label>
                            <input type="number" name="${id}-price" id="price-${optionCount}" placeholder="Price">
                    </div>
                    <div>
                            <label for="url-${optionCount}">Image Url</label>
                            <input type="text" name="${id}-url" id="url-${optionCount}" placeholder="Image url">
                    </div>
                    <button name="submit" class="save"> Save </button>
                    <button class="cancel addCancel"> Cancel </button>
            `
            optionContainer.appendChild(optionDiv);
            disableInput();
    })
}

const calculatorOptions = document.querySelectorAll('.calculator-option');
for(let calculatorOption of calculatorOptions) {
    calculatorOption.addEventListener('click', e =>{
        if(e.target.classList.contains('addCancel')) {
            e.currentTarget.removeChild(e.currentTarget.lastElementChild);
            removeClasses();
        }
    })
}   

function disableInput() {
    for(let option of options) {
        option.classList.add('disabled');
    }
    for(let question of questions) {
        question.classList.add('disabled');
    }
}

function removeClasses() {
    for(let option of options) {
        option.classList.remove('active');
        option.classList.remove('disabled');
    }
    for(let question of questions) {
        question.classList.remove('active');
        question.classList.remove('disabled');
    }
}
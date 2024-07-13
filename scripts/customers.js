document.addEventListener('DOMContentLoaded', () => {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', () => {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        togglePassword.classList.toggle('fa-eye-slash');
    });

    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#confirm_password');
    toggleConfirmPassword.addEventListener('click', () => {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        toggleConfirmPassword.classList.toggle('fa-eye-slash');
    });
});

"use strict";


document.addEventListener('DOMContentLoaded', () => {
    const $fs = (form, selector) => form.querySelector(selector);

    const customerForm = $fs(document, "main > section form:nth-of-type(1)");
    const billingAddressForm = $fs(document, "main > section form:nth-of-type(2)");
    const shippingAddressForm = $fs(document, "main > section form:nth-of-type(3)");



    customerForm.addEventListener("submit", function (event) {
        if (!validateCustomerInfo()) {
            event.preventDefault();
        }
    });

    billingAddressForm.addEventListener("submit", function (event) {
        if (!validateBillingAddress()) {
            event.preventDefault();
        }
    });

    shippingAddressForm.addEventListener("submit", function (event) {
        if (!validateShippingAddress()) {
            event.preventDefault();
        }
    });



    // Event functions:

    function validateCustomerInfo() {
        const emailRegex = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
        const passwordRegex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

        const validationData = [
            {element: 'first_name', regex: null},
            {element: 'last_name', regex: null},
            {element: 'email_address', regex: emailRegex},
            {element: 'password', regex: passwordRegex},
            {element: 'confirm_password', regex: passwordRegex}
        ];

        let isValid = true;

        validationData.forEach(data => {
            const label = $fs(customerForm, `label[for="${data.element}"]`);
            const inputElement = $fs(customerForm, `input[name="${data.element}"]`);
            const inputValue = inputElement.value.trim();

            if (data.element !== 'password' && data.element !== 'confirm_password') {
                isValid = isValid && isValidInput(label, true, data.regex);
            } else if (data.element === 'password' && inputValue !== '') {
                isValid = isValid && isValidInput(label, false, data.regex);
            } else if (data.element === 'confirm_password' && inputValue !== '') {
                const passwordElement = $fs(customerForm, 'input[name="password"]');
                const passwordValue = passwordElement.value.trim();
                const confirmationElement = inputElement.nextElementSibling;

                isValid = isValid && inputValue === passwordValue;
                isValid = isValid && isValidInput(label, true, data.regex);
            }
        });

        return isValid;
    }

    function validateBillingAddress() {
        return validateAddress(billingAddressForm);
    }

    function validateShippingAddress() {
        return validateAddress(shippingAddressForm);
    }

   

    function validateAddress(addressForm) {
        const zipRegex = /^\d{5}(-\d{4})?(?!-)/;
        const phoneRegex = /^(1\s?)?(\d{3}|\(\d{3}\))[\s\-]?\d{3}[\s\-]?\d{4}$/gm;

        const validationData = [
            {element: 'line1', regex: null},
            {element: 'line2', regex: null},
            {element: 'city', regex: null},
            {element: 'state', regex: null},
            {element: 'zip_code', regex: zipRegex},
            {element: 'phone', regex: phoneRegex}
        ];

        let isValid = true;

        validationData.forEach(data => {
            const label = $fs(addressForm, `label[for="${data.element}"]`);
            isValid = isValid && isValidInput(label, data.element !== 'line2', data.regex);
        });

        return isValid;
    }

    function isValidInput(labelElement, isRequired, regex) {
        const inputLabel = labelElement.textContent.trim().replace(/:/g, '');
        const inputElement = labelElement.nextElementSibling;
        const inputValue = inputElement.value.trim();
        const confirmationElement = inputElement.nextElementSibling;

        let isValid = true;

        if (confirmationElement) {
            confirmationElement.textContent = '';
        }

        if (isRequired && inputValue === '') {
            isValid = false;
            showError(confirmationElement, inputLabel + ' required.');
        }

        if (inputValue !== '' && regex && !regex.test(inputValue)) {
            isValid = false;
            showError(confirmationElement, 'Invalid format for ' + inputLabel);
        }

        toggleInvalidClass(inputElement, !isValid);
        return isValid;
    }

    function showError(confirmationElement, message) {
        if (confirmationElement && !message) {
            confirmationElement.value = '';
        } else if (confirmationElement) {
            confirmationElement.value = message;
        } else {
            alert(message);
        }
    }

    function toggleInvalidClass(inputElement, addClass) {
        if (addClass) {
            inputElement.classList.add('invalid');
        } else {
            inputElement.classList.remove('invalid');
        }
    }

});

function toggleDropdownMenu() {
    var dropdown = document.getElementById("dropdownMenu");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}



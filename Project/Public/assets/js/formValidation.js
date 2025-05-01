function clearErrors() {
    const errorElements = document.querySelectorAll('.error-message');
    errorElements.forEach(el => el.textContent = '');
}

function valide() {
    clearErrors();
    let isValid = true;

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const telephone = document.getElementById('telephone').value.trim();
    const datetime = document.getElementById('date').value.trim();

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^\d{8}$/;

    if (nom === '') {
        showError('nom', 'Nom is required.');
        isValid = false;
    }
    if (prenom === '') {
        showError('prenom', 'Prenom is required.');
        isValid = false;
    }
    if (email === '') {
        showError('email', 'Email is required.');
        isValid = false;
    } else if (!emailPattern.test(email)) {
        showError('email', 'Please enter a valid email address.');
        isValid = false;
    }
    if (telephone === '') {
        showError('telephone', 'Telephone is required.');
        isValid = false;
    } else if (!phonePattern.test(telephone)) {
        showError('telephone', 'Telephone must be exactly 8 digits.');
        isValid = false;
    }
    if (datetime === '') {
        showError('date', 'Date is required.');
        isValid = false;
    }

    return isValid;
}

function showError(inputId, message) {
    let field = document.getElementById(inputId);
    let error = document.getElementById(inputId + '-error');
    if (!error) {
        error = document.createElement('span');
        error.id = inputId + '-error';
        error.className = 'error-message';
        field.parentNode.appendChild(error);
    }
    error.textContent = message;
}

function validee() {
    clearErrors();
    let isValid = true;

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const telephone = document.getElementById('telephone').value.trim();
    const datetime = document.getElementById('datetime').value.trim();

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^\d{8}$/;

    if (nom === '') {
        showError('nom', 'Nom is required.');
        isValid = false;
    }
    if (prenom === '') {
        showError('prenom', 'Prenom is required.');
        isValid = false;
    }
    if (email === '') {
        showError('email', 'Email is required.');
        isValid = false;
    } else if (!emailPattern.test(email)) {
        showError('email', 'Please enter a valid email address. ("@" , ".")');
        isValid = false;
    }
    if (telephone === '') {
        showError('telephone', 'Telephone is required.');
        isValid = false;
    } else if (!phonePattern.test(telephone)) {
        showError('telephone', 'Telephone must be exactly 8 digits.');
        isValid = false;
    }
    if (datetime === '') {
        showError('datetime', 'Date is required.');
        isValid = false;
    }

    return isValid;
}

function showError(inputId, message) {
    let field = document.getElementById(inputId);
    let error = document.getElementById(inputId + '-error');
    if (!error) {
        error = document.createElement('span');
        error.id = inputId + '-error';
        error.className = 'error-message';
        field.parentNode.appendChild(error);
    }
    error.textContent = message;
}
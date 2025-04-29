function valideContenue() {
    // Get form inputs
    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const email = document.getElementById('email').value.trim();
    const telephone = document.getElementById('telephone').value.trim();
    const date = document.getElementById('date').value.trim();

    // Initialize error message
    let errorMessage = '';

    // Validate Nom
    if (nom === '') {
        errorMessage += 'Nom is required.\n';
    }

    // Validate Prenom
    if (prenom === '') {
        errorMessage += 'Prenom is required.\n';
    }

    // Validate Email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email) {
        errorMessage += 'Email is required.\n';
    } else if (!emailPattern.test(email)) {
        errorMessage += 'Please enter a valid email address (must contain @ and .).\n';
    }

    // Validate Telephone
    const phonePattern = /^\d{8}$/;
    if (!telephone) {
        errorMessage += 'Telephone is required.\n';
    } else if (!phonePattern.test(telephone)) {
        errorMessage += 'Telephone must be exactly 8 digits.\n';
    }

    // Validate Date
    if (date === '') {
        errorMessage += 'Date is required.\n';
    }

    // Display errors or submit form
    if (errorMessage) {
        alert(errorMessage);
        return false;
    }
    
    return true;
}
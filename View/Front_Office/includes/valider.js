function valideContenue() {
    let nom = document.getElementById("nom");
    let prenom = document.getElementById("prenom");
    let email = document.getElementById("email");
    let telephone = document.getElementById("telephone");
    let CV = document.getElementById("CV");

    let test = true;

    // Check for empty fields
    if (nom.value.trim() === "") {
        alert("The last name is required.");
        test = false;
    }

    if (prenom.value.trim() === "") {
        alert("The first name is required.");
        test = false;
    }

    // Email validation
    if (email.value.trim() === "") {
        alert("The email is required.");
        test = false;
    } else if (!validateEmail(email.value.trim())) {
        alert("The email must contain '@' and a valid domain.");
        test = false;
    }

    // Phone number validation
    if (telephone.value.trim() === "") {
        alert("The phone number is required.");
        test = false;
    } else if (!validatePhone(telephone.value.trim())) {
        alert("The phone number must contain exactly 8 digits.");
        test = false;
    }

   /* if (CV.files.length === 0) {
        alert("Please upload your CV.");
        test = false;
    }*/

    return test;
}

// Function to validate email format
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple regex for email validation
    return emailRegex.test(email);
}

// Function to validate phone number format (8 digits)
function validatePhone(phone) {
    const phoneRegex = /^\d{8}$/; // Regex for exactly 8 digits
    return phoneRegex.test(phone);
}



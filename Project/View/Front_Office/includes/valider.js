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


// Sample form validation
function validateForm() {
    let date = document.getElementById('date').value;
    let lien = document.getElementById('lien_entretient').value;
  
    // Check if date and link are filled out
    if (!date || !lien) {
      alert("All fields are required.");
      return false;
    }
  
    // Validate the interview link
    if (!lien.startsWith("https://meet.google.com/")) {
      alert("The interview link must start with 'https://meet.google.com/'");
      return false;
    }
  
    return true;
  }


  function validateUpdateForm() {
    const date = document.getElementById('date_entretien');
    const lien = document.getElementById('lien_entretient');
    const evaluation = document.getElementById('Evaluation_entretient');
    const status = document.getElementById('Status_entretient');
  
    let isValid = true;
  
    // Reset any previous styles
    [date, lien, evaluation, status].forEach(el => {
      el.style.border = "";
    });
  
    if (!date.value.trim()) {
      alert("Interview date is required.");
      date.style.border = "2px solid red";
      date.focus();
      isValid = false;
    }
  
    if (!lien.value.trim()) {
      alert("Interview link is required.");
      lien.style.border = "2px solid red";
      lien.focus();
      isValid = false;
    } else if (!lien.value.trim().startsWith("https://meet.google.com/")) {
      alert("The interview link must start with 'https://meet.google.com/'.");
      lien.style.border = "2px solid red";
      lien.focus();
      isValid = false;
    }
  
    if (!status.value.trim()) {
      alert("Please select a status.");
      status.style.border = "2px solid red";
      status.focus();
      isValid = false;
    }
  
    if (!evaluation.value.trim()) {
      alert("Evaluation must not be empty.");
      evaluation.style.border = "2px solid red";
      evaluation.focus();
      isValid = false;
    }
  
    return isValid;
  }
  
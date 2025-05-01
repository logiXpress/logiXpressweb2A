
    
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
  

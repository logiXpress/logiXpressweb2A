document.addEventListener('DOMContentLoaded', function() {
    // Find all delete forms
    const deleteForms = document.querySelectorAll('form[action="conSupprimerCandidat.php"]');
    
    deleteForms.forEach(form => {
        const deleteButton = form.querySelector('button[type="submit"]');
        deleteButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            // Confirm deletion
            if (confirm("Are you sure you want to delete this candidate?")) {
                // Submit the specific form
                form.submit();
            }
        });
    });
});
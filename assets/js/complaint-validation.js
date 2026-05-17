document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("complaintForm");
    
    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Get form fields
            const name = document.getElementById("name").value.trim();
            const contact = document.getElementById("contact").value.trim();
            const category = document.getElementById("category").value;
            const area = document.getElementById("area").value.trim();
            const description = document.getElementById("description").value.trim();
            
            // Validation rules
            if (!name || !contact || !category || !area || !description) {
                Swal.fire('Error', 'Please fill in all fields', 'error');
                return;
            }
            
            if (!/^\d+$/.test(contact)) {
                Swal.fire('Error', 'Contact number must contain only numbers', 'error');
                return;
            }
            
            if (description.length < 10) {
                Swal.fire('Error', 'Description must be at least 10 characters long', 'error');
                return;
            }
            
            // Show loading spinner on button
            const submitBtn = document.getElementById("submitBtn");
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
            submitBtn.disabled = true;
            
            // Form is valid, submit
            form.submit();
        });
    }
});

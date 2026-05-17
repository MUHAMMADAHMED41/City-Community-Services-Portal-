// Main Javascript file for global interactions

document.addEventListener("DOMContentLoaded", () => {
    // Add fade-in animation to main sections
    const mainSections = document.querySelectorAll("main > .container, .hero-section");
    mainSections.forEach(section => {
        section.classList.add("animate-fade-in");
    });

    // Check for success or error messages in URL parameters to show SweetAlert
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.has('success')) {
        let msg = urlParams.get('success');
        let title = 'Success!';
        if (msg === 'complaint') title = 'Complaint Submitted!';
        if (msg === 'login') title = 'Login Successful!';
        
        Swal.fire({
            icon: 'success',
            title: title,
            text: 'Action completed successfully.',
            confirmButtonColor: '#0d6efd'
        });
    }

    if (urlParams.has('error')) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: '#0d6efd'
        });
    }
});

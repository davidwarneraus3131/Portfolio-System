// Add your JavaScript code here for interactivity
document.addEventListener('DOMContentLoaded', () => {
    // Example: Alert on form submission
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', () => {
            alert('Form submitted!');
        });
    });
});



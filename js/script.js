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


// resume maker js


const canvas = new fabric.Canvas('resumeCanvas');

// Add Text
document.getElementById('addText').addEventListener('click', function () {
    const text = new fabric.Textbox('Your Name', {
        left: 100,
        top: 50,
        fontSize: 20,
        fill: 'black'
    });
    canvas.add(text);
});

// Upload Image
document.getElementById('uploadImage').addEventListener('click', function () {
    document.getElementById('imageInput').click();
});

document.getElementById('imageInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (f) {
            fabric.Image.fromURL(f.target.result, function (img) {
                img.scale(0.5);
                canvas.add(img);
            });
        };
        reader.readAsDataURL(file);
    }
});

// Save Resume Data
document.getElementById('saveResume').addEventListener('click', function () {
    const resumeData = JSON.stringify(canvas.toJSON());
    
    fetch('save_resume.php', {
        method: 'POST',
        body: JSON.stringify({ data: resumeData }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.text())
    .then(data => alert(data));
});

// Download as PDF
document.getElementById('downloadPDF').addEventListener('click', function () {
    fetch('generate_pdf.php')
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'resume.pdf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
});

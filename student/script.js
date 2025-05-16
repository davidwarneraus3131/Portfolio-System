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
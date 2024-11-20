<?php include('./includes/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif; /* Professional font style */
    scroll-behavior: smooth; /* Smooth scrolling effect */
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
    background-image: linear-gradient(to right, #3b5757, #020d1b); /* Gradient from blue-900 to gray-800 */
    padding: 1rem; /* Equivalent to p-4 in Tailwind (1rem = 16px) */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow equivalent to shadow-lg */
    color:rgb(193 193 193);
        }
        .animation-container {
            max-width: 300px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-lg w-full">
        <h2 class="text-3xl font-bold mb-4">Thank You!</h2>
        <p class="text-gray-600 mb-4">Your message has been successfully sent. We appreciate you reaching out!</p>
        
        <div class="animation-container mb-4" id="lottie-animation"></div>
        
        <button onclick="window.location.href='contact.php'" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
            Return to Contact Page
        </button>
    </div>

    <script>
        // Lottie Animation
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie-animation'), // the dom element that will contain the animation
            renderer: 'svg',
            loop: true, // Loop the animation
            autoplay: true, // Start playing the animation
            path: 'https://assets6.lottiefiles.com/packages/lf20_MiJ8Bc.json' // Replace with your Lottie JSON URL
        });
    </script>
</body>
</html>
<?php include('./includes/footer.php'); ?>

<?php include('../includes/header.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom animation for button hover */
        .btn-hover {
            background-size: 200% 200%;
            background-image: linear-gradient(to right, #3b5757, #020d1b);
            transition: all 0.4s ease;
        }
        .btn-hover:hover {
            background-position: right center;
            transform: scale(1.05);
        }
        body {
            font-family: 'Arial', sans-serif;
            scroll-behavior: smooth;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(to right, #3b5757, #020d1b);
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: rgb(193, 193, 193);
        }
        .head {
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: rgb(193, 193, 193);
        }

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 768px) {
            .head h1 {
                font-size: 1.5rem; /* Smaller font size for mobile */
            }
            .head p {
                font-size: 0.9rem; /* Smaller paragraph text */
            }
            .container {
                padding: 0 1rem; /* Adjust padding for small screens */
            }
            .text-2xl {
                font-size: 1.5rem; /* Smaller headings on mobile */
            }
            .text-lg {
                font-size: 1rem; /* Smaller text for mobile */
            }
        }

        @media (max-width: 640px) {
            .p-6 {
                padding: 1rem; /* Adjust padding for small devices */
            }
            .w-full {
                width: 100%; /* Ensure full width on small screens */
            }
            .space-y-4 > * {
                margin-bottom: 1rem; /* Add spacing between items */
            }
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class=" text-white py-6 p-7 head">
        <div class="container mx-auto text-center">
            <h1 class="text-3xl font-extrabold">Get in Touch with Us</h1>
            <p class="mt-2 text-lg">We'd love to hear from you! Feel free to reach out with any questions or inquiries. (Update Your Portfolio Details)</p>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="container mx-auto p-6 my-12 bg-white shadow-lg rounded-lg">
        <div class="flex flex-col md:flex-row">
            <!-- Contact Form -->
            <div class="w-full md:w-1/2 p-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Send Us a Message</h2>
                <form action="submit_contact.php" method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block font-semibold text-gray-600">Full Name</label>
                        <input type="text" id="name" name="name" class="text-black w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($_SESSION['name']) ?? ""; ?>" required>
                    </div>

                    <div>
                        <label for="email" class="block font-semibold text-gray-600">Email Address</label>
                        <input type="email" id="email" name="email" class="text-black w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" value="<?php echo htmlspecialchars($_SESSION['email']) ?? ""; ?>" required>
                    </div>
                    <div>
                        <label for="message" class="block font-semibold text-gray-600">Your Message</label>
                        <textarea id="message" name="message" rows="5" class="text-black w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" required></textarea>
                    </div>
                    <button type="submit" class="w-full p-3 text-white font-semibold btn-hover rounded transition duration-300">Send Message</button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="w-full md:w-1/2 p-6 mt-8 md:mt-0">
                <h2 class="text-2xl font-bold mb-4 text-gray-700">Contact Information</h2>
                <p class="text-gray-600 mb-6">Our team is here to answer any questions you may have.</p>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M21 8h-6a1 1 0 000 2h5v9H4V10h5a1 1 0 000-2H3c-1.1 0-2 .9-2 2v12a2 2 0 002 2h18c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z"/><path d="M12 1C8.69 1 6 3.69 6 7s2.69 6 6 6 6-2.69 6-6S15.31 1 12 1zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/></svg>
                        <span>Chennai</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4c4.41 0 8 3.59 8 8s-3.59 8-8 8-8-3.59-8-8 3.59-8 8-8zm0 16c4.42 0 8-3.58 8-8s-3.58-8-8-8-8 3.58-8 8 3.58 8 8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                        <span>Monday - Friday: 9:00 AM - 5:00 PM</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M11 10H9V7h2v3zm1-5c1.38 0 2.5 1.12 2.5 2.5S13.38 10 12 10s-2.5-1.12-2.5-2.5S10.62 5 12 5zm3 14H9v-2h6v2zm0-4H9v-2h6v2zm0-4H9v-2h6v2zm0-4H9V7h6v2z"/></svg>
                        <span>Email: potterharry623016@gmail.com</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M10.2 19.41l-2.39.95a.92.92 0 01-1.19-.47A15.1 15.1 0 011.14 4.59a.92.92 0 01.47-1.2l2.39-.95a.92.92 0 011.19.47l1.32 3.16a.92.92 0 01-.11.97L5.41 9.1a11.64 11.64 0 006.48 6.49l1.56-1.56a.92.92 0 01.96-.11l3.16 1.32a.92.92 0 01.47 1.19z"/></svg>
                        <span>+91 6369752557</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Placeholder for Map Integration) -->
    <section class="container mx-auto my-12 p-6 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-4">
            <h2 class="text-2xl font-bold text-gray-700">Visit Our Office</h2>
            <p class="text-gray-600">Find us on the map below and stop by our office for a chat!</p>
        </div>
        <div class="w-full h-64 rounded-lg overflow-hidden">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3898.8076142704894!2d80.12117771482096!3d12.922904890886401!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a52f73f78b84963%3A0x7aef1f7f8d7ed540!2sTambaram%2C%20Chennai%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1614001450930!5m2!1sen!2sin"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </section>

</body>
</html>
<?php include('../includes/footer.php'); ?>

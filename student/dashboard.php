<?php
session_start();
include("../database/db.php");
;
if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
}

include('../includes/header.php');
?>

<style>
    /* Glowing Effect for Modal Background */
    .glow-effect {
        background: linear-gradient(135deg, rgba(255, 140, 0, 0.2), rgba(0, 204, 255, 0.2));
        box-shadow: 0 0 25px rgba(255, 140, 0, 0.5), 0 0 50px rgba(0, 204, 255, 0.5);
    }

    /* Gradient and Glowing Effect for Icons */
    .gradient-icon {
        background: linear-gradient(135deg, #ff6b6b, #f8e71c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        box-shadow: 0 0 10px rgba(255, 107, 107, 0.5), 0 0 20px rgba(248, 231, 28, 0.5);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .device-icon:hover .gradient-icon {
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(255, 107, 107, 1), 0 0 25px rgba(248, 231, 28, 1);
    }

    /* Device Frame Styles */
    .device-frame-mobile {
        width: 375px;
        height: 600px;
        border: 16px solid #000;
        border-radius: 25px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
        background-color: white;
        margin: 0 auto; /* Center the device frame */
    }

    .device-frame-tablet {
        width: 768px;
        height: 600px; /* Decreased height for tablet */
        border: 16px solid #000;
        border-radius: 25px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
        background-color: white;
        margin: 0 auto; /* Center the device frame */
    }

    .device-frame-pc {
        width: 1200px; /* Fixed width for PC */
        height: 600px; /* Decreased height for PC */
        border: 16px solid #000;
        border-radius: 25px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        position: relative;
        overflow: hidden;
        background-color: white;
        margin: 0 auto; /* Center the device frame */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .device-frame-pc {
            height: 500px; /* Further adjust height for smaller screens */
            width: 100%; /* Make it responsive */
        }
    }
</style>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container mx-auto p-4">
<?php
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest'; // Default to 'Guest' if not set
?>
<h1 class="text-2xl font-bold mb-4 text-center p-t-5">Welcome, <?php echo $name; ?>!</h1>

    
    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2 text-center">Available Templates</h2><br>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <?php
    $templates = mysqli_query($conn, "SELECT * FROM templates");
   while ($template = mysqli_fetch_assoc($templates)) {
    echo '<div class="rounded-lg bg-black shadow-lg transition-transform transform hover:scale-105 hover:shadow-2xl duration-300 text-center border border-transparent hover:border-yellow-500 hover:border-1">';
    // Updated border color and added hover shadow
    echo '<img src="../assets/' . htmlspecialchars(string: $template['template_image'] ?? '') . '" alt="' . htmlspecialchars($template['text'] ?? 'Template Image') . '" class=" rounded-t-lg w-full h-40 object-cover cursor-pointer template-img" />';
    echo '<div class="p-4">';
    echo '<h3 class="font-semibold text-lg">' . htmlspecialchars($template['text'] ?? 'Demo Template') . '</h3>';
    echo '<a href="#" class="block bg-green-500 text-white p-2 mt-2 text-center rounded hover:bg-green-600 transition duration-300 ease-in-out preview-link" data-url="' . htmlspecialchars($template['preview_link'] ?? '#') . '">Preview <i class="fas fa-eye"></i></a>';
    echo '<a href="select_template.php?id=' . htmlspecialchars($template['id'] ?? '') . '" class="block bg-blue-500 text-white p-2 mt-2 text-center rounded hover:bg-blue-600 transition duration-300 ease-in-out">Select Template</a>';
    echo '</div>';
    echo '</div>';
}
?>
        </div>
    </div>
    
    <!-- Modal for Preview Link -->
    <div id="linkModal" class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-75 hidden">
        <div class="relative  rounded-lg p-8 mb-8 glow-effect">
            

            <!-- Device Selection Icons inside Modal -->
            <div class="text-center mb-4">
                <label class="block text-lg font-semibold">Select Device Type:</label>
                <div class="flex justify-center space-x-4">
                    <div class="cursor-pointer device-icon" id="mobileIcon" data-device="mobile" data-size="375x667">
                        <i class="fas fa-mobile-alt text-3xl gradient-icon"></i>
                        <p class="text-sm">Mobile</p>
                    </div>
                    <div class="cursor-pointer device-icon" id="tabletIcon" data-device="tablet" data-size="768x1024">
                        <i class="fas fa-tablet-alt text-3xl gradient-icon"></i>
                        <p class="text-sm">Tablet</p>
                    </div>
                    <div class="cursor-pointer device-icon" id="pcIcon" data-device="pc" data-size="1366x768">
                        <i class="fas fa-laptop text-3xl gradient-icon"></i>
                        <p class="text-sm">PC/Laptop</p>
                    </div>
                </div>
                <div id="screenSize" class="mt-2 text-lg font-medium text-white-400">Screen Size: N/A</div>
            </div>

            <div id="deviceFrame" class="device-frame-mobile my-4">
                <iframe id="previewFrame" class="w-full h-full rounded-lg" frameborder="0"></iframe>
            </div>
            <span id="closeLinkModal" class="absolute top-0 right-0 text-white bg-black text-2xl cursor-pointer">&times;</span>

        </div>
    </div>
</div>



<script>
    const linkModal = document.getElementById('linkModal');
    const closeLinkModal = document.getElementById('closeLinkModal');
    const previewFrame = document.getElementById('previewFrame');
    const deviceFrame = document.getElementById('deviceFrame');

    document.querySelectorAll('.preview-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            const url = this.getAttribute('data-url');
            previewFrame.src = url; // Set iframe source to the preview link URL
            linkModal.classList.remove('hidden'); // Show the link modal
        });
    });

    closeLinkModal.addEventListener('click', function() {
        linkModal.classList.add('hidden');
        previewFrame.src = ''; // Clear the iframe source
    });

    window.addEventListener('click', function(event) {
        if (event.target === linkModal) {
            linkModal.classList.add('hidden');
            previewFrame.src = ''; // Clear the iframe source
        }
    });

    // Device icon selection functionality
    document.querySelectorAll('[id$="Icon"]').forEach(icon => {
        icon.addEventListener('click', function() {
            const deviceType = this.getAttribute('data-device');
            const screenSize = this.getAttribute('data-size');
            document.getElementById('screenSize').textContent = 'Screen Size: ' + screenSize;

            // Update device frame based on selection
            if (deviceType === 'mobile') {
                deviceFrame.className = 'device-frame-mobile my-4'; // Added margin here
            } else if (deviceType === 'tablet') {
                deviceFrame.className = 'device-frame-tablet my-4'; // Added margin here
            } else if (deviceType === 'pc') {
                deviceFrame.className = 'device-frame-pc my-4'; // Added margin here
            }
        });
    });
</script>

<?php include('../includes/footer.php'); ?>

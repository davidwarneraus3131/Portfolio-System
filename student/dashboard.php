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
    /* CSS Variables for Color Palette */
    :root {
        --dark-navy: #0B0F19;
        --deep-gray: #1A1F2B;
        --neon-purple: #7C3AED;
        --electric-blue: #3B82F6;
        --aqua-accent: #22D3EE;
        --gradient-1: linear-gradient(135deg, var(--dark-navy) 0%, var(--deep-gray) 100%);
        --gradient-2: linear-gradient(135deg, var(--neon-purple) 0%, var(--electric-blue) 100%);
        --gradient-3: linear-gradient(135deg, var(--electric-blue) 0%, var(--aqua-accent) 100%);
        --gradient-border: linear-gradient(135deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
    }

    /* Main Container */
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        font-family: 'Poppins', sans-serif;
    }

    /* Welcome Header */
    .welcome-header {
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
    }

    .welcome-header h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        background: var(--gradient-2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        display: inline-block;
    }

    .welcome-header h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: var(--gradient-3);
        border-radius: 3px;
    }

    /* Section Header */
    .section-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .section-header h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    /* Template Grid */
    .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    /* Template Card */
    .template-card {
        background: rgba(26, 31, 43, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(124, 58, 237, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        position: relative;
    }

    .template-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 16px;
        padding: 2px;
        background: var(--gradient-border);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .template-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        border-color: rgba(124, 58, 237, 0.4);
    }

    .template-card:hover::before {
        opacity: 1;
    }

    .template-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .template-card:hover .template-img {
        transform: scale(1.05);
    }

    .template-content {
        padding: 1.5rem;
    }

    .template-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        color: #fff;
    }

    .template-actions {
        display: flex;
        gap: 1rem;
    }

    .btn {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-preview {
        background: var(--gradient-2);
        color: white;
    }

    .btn-select {
        background: var(--gradient-3);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 15, 25, 0.9);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        padding: 1rem;
        box-sizing: border-box;
    }

    .modal.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background: rgba(26, 31, 43, 0.9);
        border-radius: 20px;
        padding: 2rem;
        width: 100%;
        max-width: 1200px;
        max-height: 95vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(124, 58, 237, 0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.5rem;
        color: #fff;
    }

    .close-btn {
        background: none;
        border: none;
        color: #fff;
        font-size: 1.5rem;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(90deg);
    }

    /* Device Selection */
    .device-selection {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .device-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .device-option:hover {
        transform: translateY(-5px);
    }

    .device-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(26, 31, 43, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .device-option.active .device-icon {
        border-color: var(--aqua-accent);
        box-shadow: 0 0 15px rgba(34, 211, 238, 0.5);
    }

    .device-icon i {
        font-size: 1.5rem;
        background: var(--gradient-2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .device-label {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.9rem;
        color: #fff;
    }

    .screen-size {
        text-align: center;
        margin-bottom: 1.5rem;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        color: var(--aqua-accent);
    }

    /* Device Frames */
    .device-frame-container {
        display: flex;
        justify-content: center;
        width: 100%;
        overflow: hidden;
    }

    .device-frame {
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(124, 58, 237, 0.3);
        transition: all 0.3s ease;
    }

    .device-frame.mobile {
        width: 375px;
        height: 667px;
    }

    .device-frame.tablet {
        width: 768px;
        height: 1024px;
    }

    .device-frame.pc {
        width: 100%;
        max-width: 1200px;
        height: 700px;
    }

    .preview-frame {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 16px;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .device-frame.pc {
            width: 100%;
            height: 600px;
        }
    }

    @media (max-width: 992px) {
        .template-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
        
        .device-frame.pc {
            height: 500px;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        .template-grid {
            grid-template-columns: 1fr;
        }
        
        .device-selection {
            gap: 1rem;
        }
        
        .modal-content {
            padding: 1.5rem;
        }
        
        .device-frame.tablet {
            width: 100%;
            max-width: 500px;
            height: 600px;
        }
        
        .device-frame.mobile {
            width: 100%;
            max-width: 375px;
            height: 500px;
        }
    }

    @media (max-width: 480px) {
        .welcome-header h1 {
            font-size: 2rem;
        }
        
        .section-header h2 {
            font-size: 1.5rem;
        }
        
        .modal-content {
            padding: 1rem;
        }
        
        .device-frame.mobile {
            height: 400px;
        }
        
        .device-frame.tablet {
            height: 450px;
        }
        
        .device-frame.pc {
            height: 400px;
        }
    }
</style>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container">
    <?php
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest'; // Default to 'Guest' if not set
    ?>
    <div class="welcome-header">
        <h1>Welcome, <?php echo $name; ?>!</h1>
    </div>
    
    <div class="section-header">
        <h2>Available Templates</h2>
    </div>

    <div class="template-grid">
        <?php
        $templates = mysqli_query($conn, "SELECT * FROM templates");
        while ($template = mysqli_fetch_assoc($templates)) {
            echo '<div class="template-card">';
            echo '<img src="../assets/' . htmlspecialchars(string: $template['template_image'] ?? '') . '" alt="' . htmlspecialchars($template['text'] ?? 'Template Image') . '" class="template-img" />';
            echo '<div class="template-content">';
            echo '<h3 class="template-title">' . htmlspecialchars($template['text'] ?? 'Demo Template') . '</h3>';
            echo '<div class="template-actions">';
            echo '<a href="#" class="btn btn-preview preview-link" data-url="' . htmlspecialchars($template['preview_link'] ?? '#') . '"><i class="fas fa-eye"></i> Preview</a>';
            echo '<a href="select_template.php?id=' . htmlspecialchars($template['id'] ?? '') . '" class="btn btn-select"><i class="fas fa-check"></i> Select</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- Modal for Preview Link -->
<div id="linkModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Template Preview</h3>
            <button id="closeLinkModal" class="close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Device Selection -->
        <div class="device-selection">
            <div class="device-option active" id="mobileOption" data-device="mobile">
                <div class="device-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <span class="device-label">Mobile</span>
            </div>
            <div class="device-option" id="tabletOption" data-device="tablet">
                <div class="device-icon">
                    <i class="fas fa-tablet-alt"></i>
                </div>
                <span class="device-label">Tablet</span>
            </div>
            <div class="device-option" id="pcOption" data-device="pc">
                <div class="device-icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <span class="device-label">PC/Laptop</span>
            </div>
        </div>
        
        <div class="screen-size" id="screenSize">Screen Size: Mobile (375x667)</div>
        
        <div class="device-frame-container">
            <div class="device-frame mobile" id="deviceFrame">
                <iframe id="previewFrame" class="preview-frame" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    const linkModal = document.getElementById('linkModal');
    const closeLinkModal = document.getElementById('closeLinkModal');
    const previewFrame = document.getElementById('previewFrame');
    const deviceFrame = document.getElementById('deviceFrame');
    const screenSizeDisplay = document.getElementById('screenSize');
    const deviceOptions = document.querySelectorAll('.device-option');

    document.querySelectorAll('.preview-link').forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            const url = this.getAttribute('data-url');
            previewFrame.src = url; // Set iframe source to the preview link URL
            linkModal.classList.add('active'); // Show the link modal
        });
    });

    closeLinkModal.addEventListener('click', function() {
        linkModal.classList.remove('active');
        previewFrame.src = ''; // Clear the iframe source
    });

    window.addEventListener('click', function(event) {
        if (event.target === linkModal) {
            linkModal.classList.remove('active');
            previewFrame.src = ''; // Clear the iframe source
        }
    });

    // Device icon selection functionality
    deviceOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            deviceOptions.forEach(opt => opt.classList.remove('active'));
            
            // Add active class to clicked option
            this.classList.add('active');
            
            const deviceType = this.getAttribute('data-device');
            
            // Update device frame based on selection
            deviceFrame.className = 'device-frame ' + deviceType;
            
            // Update screen size display
            if (deviceType === 'mobile') {
                screenSizeDisplay.textContent = 'Screen Size: Mobile (375x667)';
            } else if (deviceType === 'tablet') {
                screenSizeDisplay.textContent = 'Screen Size: Tablet (768x1024)';
            } else if (deviceType === 'pc') {
                screenSizeDisplay.textContent = 'Screen Size: PC/Laptop (1920x1080)';
            }
        });
    });

    // Handle window resize to adjust modal content
    window.addEventListener('resize', function() {
        if (linkModal.classList.contains('active')) {
            // Adjust iframe dimensions if needed
            const deviceType = document.querySelector('.device-option.active').getAttribute('data-device');
            if (deviceType === 'pc') {
                // For PC view, adjust height based on viewport
                const viewportHeight = window.innerHeight * 0.6;
                deviceFrame.style.height = Math.min(viewportHeight, 700) + 'px';
            }
        }
    });
</script>

<?php include('../includes/footer.php'); ?>
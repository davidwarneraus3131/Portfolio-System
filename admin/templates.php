<?php
session_start(); // Start session at top

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Include necessary files
include('../includes/header.php');
include("../database/db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Templates Management</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --dark-navy: #0B0F19;
            --deep-gray: #1A1F2B;
            --neon-purple: #7C3AED;
            --electric-blue: #3B82F6;
            --aqua-accent: #22D3EE;
            --text-primary: #d1d5db;
            --text-secondary: #9ca3af;
            --text-muted: #6b7280;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--dark-navy);
            color: var(--text-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        .bg-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(124, 58, 237, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%);
            z-index: -1;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 15px;
            padding-top: 140px; /* Increased from 100px to 140px for more gap */
            animation: fadeIn 0.5s ease-out;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px; /* Increased from 20px to 30px */
            flex-wrap: wrap;
            gap: 15px;
            position: relative;
            z-index: 1000; /* Higher than header */
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--neon-purple), var(--electric-blue));
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(124, 58, 237, 0.3);
        }
        
        .icon-wrapper i {
            font-size: 1.1rem;
            color: white;
        }
        
        h2 {
            font-weight: 600;
            font-size: 1.5rem;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .btn {
            padding: 8px 16px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            z-index: 1001; /* Higher than header */
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 58, 237, 0.4);
        }
        
        .table-wrapper {
            background: linear-gradient(145deg, rgba(26, 31, 43, 0.95), rgba(11, 15, 25, 0.95));
            border-radius: 12px;
            padding: 15px;
            box-shadow: 
                0 8px 20px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(124, 58, 237, 0.2);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .table-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
        }
        
        .table-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .search-box {
            position: relative;
            flex: 1;
            max-width: 280px;
        }
        
        .search-box input {
            width: 100%;
            padding: 8px 12px 8px 35px;
            background: rgba(26, 31, 43, 0.6);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 8px;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15);
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }
        
        .entries-select {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-primary);
        }
        
        .entries-select select {
            padding: 6px 10px;
            background: rgba(26, 31, 43, 0.6);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 6px;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            cursor: pointer;
        }
        
        .templates-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }
        
        .templates-table thead th {
            background: rgba(26, 31, 43, 0.7);
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--aqua-accent);
            border-bottom: 2px solid rgba(124, 58, 237, 0.3);
            white-space: nowrap;
        }
        
        .templates-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(124, 58, 237, 0.1);
        }
        
        .templates-table tbody tr:hover {
            background: rgba(59, 130, 246, 0.08);
        }
        
        .templates-table tbody td {
            padding: 12px 10px;
            font-size: 0.85rem;
            color: var(--text-primary);
            vertical-align: middle;
        }
        
        .template-img {
            width: 80px;
            height: 55px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid rgba(124, 58, 237, 0.3);
        }
        
        .actions-container {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, var(--aqua-accent), #06b6d4);
        }
        
        .btn-edit:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(34, 211, 238, 0.3);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #dc2626, #991b1b);
        }
        
        .btn-delete:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.3);
        }
        
        /* Modal Styling */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1002; /* Higher than header and button */
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            padding: 20px;
        }
        
        .modal.active {
            opacity: 1;
            visibility: visible;
        }
        
        .modal-content {
            background: linear-gradient(145deg, rgba(26, 31, 43, 0.98), rgba(11, 15, 25, 0.98));
            border-radius: 12px;
            padding: 20px;
            max-width: 500px;
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(124, 58, 237, 0.3);
            transform: translateY(20px);
            transition: all 0.3s ease;
        }
        
        .modal.active .modal-content {
            transform: translateY(0);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(124, 58, 237, 0.2);
        }
        
        .modal-title {
            font-weight: 600;
            font-size: 1.2rem;
            background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .close-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .close-btn:hover {
            color: var(--text-primary);
            background: rgba(124, 58, 237, 0.2);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--aqua-accent);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 12px;
            background: rgba(26, 31, 43, 0.6);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: 8px;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--electric-blue);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.15);
        }
        
        textarea.form-control {
            min-height: 80px;
            resize: vertical;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        .btn-cancel {
            background: rgba(107, 114, 128, 0.5);
        }
        
        .btn-cancel:hover {
            background: rgba(107, 114, 128, 0.7);
            box-shadow: 0 3px 8px rgba(107, 114, 128, 0.3);
        }
        
        .dataTables_paginate .paginate_button {
            color: var(--text-primary) !important;
            background: rgba(26, 31, 43, 0.6) !important;
            border: 1px solid rgba(124, 58, 237, 0.2) !important;
            border-radius: 4px !important;
            margin: 0 2px !important;
            padding: 4px 8px !important;
            font-size: 0.8rem !important;
        }
        
        .dataTables_paginate .paginate_button.current {
            background: var(--neon-purple) !important;
            border-color: var(--neon-purple) !important;
        }
        
        .dataTables_paginate .paginate_button:hover {
            background: var(--electric-blue) !important;
            border-color: var(--electric-blue) !important;
        }
        
        .dataTables_info {
            color: var(--text-primary) !important;
            font-size: 0.8rem !important;
        }
        
        .dataTables_length label {
            color: var(--text-primary) !important;
            font-size: 0.8rem !important;
        }
        
        .dataTables_filter label {
            color: var(--text-primary) !important;
            font-size: 0.8rem !important;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                padding: 12px;
                padding-top: 140px; /* Match desktop */
            }
            
            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding-top: 160px; /* Increased for mobile */
            }
            
            .header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
                gap: 10px;
            }
            
            .header-left {
                justify-content: center;
            }
            
            h2 {
                font-size: 1.3rem;
            }
            
            .table-wrapper {
                padding: 12px;
                overflow-x: auto;
            }
            
            .templates-table {
                min-width: 600px;
            }
            
            .templates-table thead th, 
            .templates-table tbody td {
                padding: 10px 8px;
                font-size: 0.8rem;
            }
            
            .template-img {
                width: 70px;
                height: 50px;
            }
            
            .actions-container {
                flex-direction: column;
                gap: 4px;
            }
            
            .action-btn {
                font-size: 0.7rem;
                padding: 5px 8px;
                justify-content: center;
            }
            
            .modal-content {
                padding: 15px;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding-top: 160px; /* Consistent for small screens */
            }
            
            .btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            .modal-title {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    
    <div class="container">
        <div class="header">
            <div class="header-left">
                <div class="icon-wrapper">
                    <i class="fas fa-layer-group"></i>
                </div>
                <h2>Templates Management</h2>
            </div>
            <!-- Add Template Button - Fixed -->
            <button type="button" id="addTemplateButton" class="btn">
                <i class="fas fa-plus"></i> 
                <span>Add Template</span>
            </button>
        </div>
        
        <div class="table-wrapper">
            <div class="table-controls">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search templates...">
                </div>
                <div class="entries-select">
                    <label for="entriesSelect">Show:</label>
                    <select id="entriesSelect">
                        <option value="10">10 entries</option>
                        <option value="25">25 entries</option>
                        <option value="50">50 entries</option>
                        <option value="100">100 entries</option>
                    </select>
                </div>
            </div>
            
            <div style="overflow-x: auto;">
                <table class="templates-table" id="templatesTable">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Template Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $templates = mysqli_query($conn, "SELECT * FROM templates");
                        while ($template = mysqli_fetch_assoc($templates)) {
                            echo '<tr>';
                            echo '<td><img src="../assets/' . htmlspecialchars($template['template_image'] ?? '') . '" class="template-img" alt="Template Image"></td>';
                            echo '<td>' . htmlspecialchars($template['text'] ?? 'N/A') . '</td>';
                            echo '<td>' . htmlspecialchars($template['description'] ?? 'N/A') . '</td>';
                            echo '<td>
                                <div class="actions-container">
                                    <button class="action-btn btn-edit edit-template" data-id="'. $template['id'] . '" data-image="' . htmlspecialchars($template['template_image'] ?? '') . '" data-text="' . htmlspecialchars($template['text'] ?? '') . '" data-description="' . htmlspecialchars($template['description'] ?? '') . '" data-preview="' . htmlspecialchars($template['preview_link'] ?? '') . '" data-actual-price="' . htmlspecialchars($template['actual_price'] ?? '') . '" data-price="' . htmlspecialchars($template['price'] ?? '') . '">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <a href="templates.php?delete_template_id=' . $template['id'] . '" class="action-btn btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add/Edit Template Modal -->
    <div id="templateModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add/Edit Template</h3>
                <button class="close-btn" id="closeModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="templateForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="template_id" id="template_id">
                
                <div class="form-group">
                    <label for="template_text">Template Name</label>
                    <input type="text" name="text" id="template_text" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="template_image">Image</label>
                    <input type="file" name="image" id="template_image" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="template_description">Description</label>
                    <textarea name="description" id="template_description" class="form-control" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="template_preview">Preview Link</label>
                    <input type="url" name="preview_link" id="template_preview" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="template_actual_price">Actual Price</label>
                    <input type="number" name="actual_price" id="template_actual_price" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="template_price">Price</label>
                    <input type="number" name="price" id="template_price" class="form-control" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Submit
                    </button>
                    <button type="button" id="cancelBtn" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#templatesTable').DataTable({
                "pageLength": 10,
                "responsive": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "language": {
                    "search": "Search templates:",
                    "lengthMenu": "Show _MENU_ templates per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ templates",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });

            // Open Add Template Modal
            $('#addTemplateButton').on('click', function() {
                console.log('Add button clicked');
                $('#templateForm')[0].reset();
                $('#template_id').val('');
                $('#templateForm input[name="action"]').val('add');
                $('#templateModal').addClass('active');
            });

            // Close Modal
            $('#closeModal, #cancelBtn').on('click', function() {
                $('#templateModal').removeClass('active');
            });

            // Edit Template Modal
            $('.edit-template').on('click', function() {
                const templateData = $(this).data();
                $('#template_id').val(templateData.id);
                $('#template_text').val(templateData.text);
                $('#template_description').val(templateData.description);
                $('#template_preview').val(templateData.preview);
                $('#template_actual_price').val(templateData.actualPrice);
                $('#template_price').val(templateData.price);
                $('#templateForm input[name="action"]').val('edit');
                $('#templateModal').addClass('active');
            });

            // Close modal when clicking outside
            $(window).on('click', function(event) {
                if ($(event.target).is('#templateModal')) {
                    $('#templateModal').removeClass('active');
                }
            });
            
            // Close modal with Escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape') {
                    $('#templateModal').removeClass('active');
                }
            });
        });
        
        // Handle delete confirmation
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const deleteUrl = $(this).attr('href');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7C3AED',
                cancelButtonColor: '#3B82F6',
                confirmButtonText: 'Yes, delete it!',
                background: 'var(--deep-gray)',
                color: '#d1d5db'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    </script>
</body>
</html>

<?php
// Handle add, edit, delete templates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $template_id = $_POST['template_id'] ?? null;
    $image = $_FILES['image']['name'] ?? null;
    $text = $_POST['text'];
    $description = $_POST['description'];
    $preview_link = $_POST['preview_link'];
    $actual_price = $_POST['actual_price'];
    $price = $_POST['price'];

    // Validate required fields
    if (empty($text) || empty($description) || empty($preview_link) || empty($actual_price) || empty($price)) {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'All fields are required!',
                icon: 'error',
                background: 'var(--deep-gray)',
                color: '#d1d5db'
            });
        </script>";
        exit();
    }

    if ($action == 'add') {
        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../assets/" . $image);
        }
        mysqli_query($conn, "INSERT INTO templates (template_image, text, description, preview_link, actual_price, price) VALUES ('$image', '$text', '$description', '$preview_link', '$actual_price', '$price')");
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Template added successfully!',
                icon: 'success',
                background: 'var(--deep-gray)',
                color: '#d1d5db'
            }).then(() => window.location = 'templates.php');
        </script>";
    } elseif ($action == 'edit') {
        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../assets/" . $image);
            mysqli_query($conn, "UPDATE templates SET template_image='$image', text='$text', description='$description', preview_link='$preview_link', actual_price='$actual_price', price='$price' WHERE id='$template_id'");
        } else {
            mysqli_query($conn, "UPDATE templates SET text='$text', description='$description', preview_link='$preview_link', actual_price='$actual_price', price='$price' WHERE id='$template_id'");
        }
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Template updated successfully!',
                icon: 'success',
                background: 'var(--deep-gray)',
                color: '#d1d5db'
            }).then(() => window.location = 'templates.php');
        </script>";
    }
} elseif (isset($_GET['delete_template_id'])) {
    $template_id = $_GET['delete_template_id'];
    mysqli_query($conn, "DELETE FROM templates WHERE id='$template_id'");
    echo "<script>
        Swal.fire({
            title: 'Deleted!',
            text: 'Template has been deleted.',
            icon: 'success',
            background: 'var(--deep-gray)',
            color: '#d1d5db'
        }).then(() => window.location = 'templates.php');
    </script>";
}
?>

<?php include('../includes/footer.php'); ?>
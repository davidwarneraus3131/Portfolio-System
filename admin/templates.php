<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Include SweetAlert CSS and JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../includes/header.php');

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
        echo "<script>Swal.fire('Error!', 'All fields are required!', 'error');</script>";
        exit();
    }

    if ($action == 'add') {
        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../assets/" . $image);
        }
        mysqli_query($conn, "INSERT INTO templates (template_image, text, description, preview_link, actual_price, price) VALUES ('$image', '$text', '$description', '$preview_link', '$actual_price', '$price')");
        echo "<script>Swal.fire('Success!', 'Template added successfully!', 'success').then(() => window.location = 'templates.php');</script>";
    } elseif ($action == 'edit') {
        if (!empty($image)) {
            move_uploaded_file($_FILES['image']['tmp_name'], "../assets/" . $image);
            mysqli_query($conn, "UPDATE templates SET template_image='$image', text='$text', description='$description', preview_link='$preview_link', actual_price='$actual_price', price='$price' WHERE id='$template_id'");
        } else {
            mysqli_query($conn, "UPDATE templates SET text='$text', description='$description', preview_link='$preview_link', actual_price='$actual_price', price='$price' WHERE id='$template_id'");
        }
        echo "<script>Swal.fire('Success!', 'Template updated successfully!', 'success').then(() => window.location = 'templates.php');</script>";
    }
} elseif (isset($_GET['delete_template_id'])) {
    $template_id = $_GET['delete_template_id'];
    mysqli_query($conn, "DELETE FROM templates WHERE id='$template_id'");
    echo "<script>Swal.fire('Deleted!', 'Template has been deleted.', 'success').then(() => window.location = 'templates.php');</script>";
}

?>

<style>
      .table-bg {
      /* background: linear-gradient(to right, #3b5757, #020d1b); */
      color: black;
    }
    /* Adjust table header for better visibility */
    .table-header {
     
       background: linear-gradient(to right, #3b5757, #020d1b);

    }
</style>

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">All Templates</h1>
        <button id="addTemplateButton" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-2 rounded shadow-lg hover:shadow-xl transition transform hover:scale-105 focus:outline-none relative overflow-hidden">
            <span class="shine absolute left-0 top-0 w-full h-full bg-gradient-to-r from-transparent to-white opacity-50 animate-shine"></span>
            Add New Template
        </button>
    </div>
  

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        
        <table id="templatesTable" class="min-w-full bg-white border border-gray-200">
            
    
      <thead class="table-header text-black">
          
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 text-left">Image</th>
                    <th class="py-3 px-4 text-left">Template Name</th>
                    <th class="py-3 px-4 text-left">Description</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            
            <tbody class="table-bg">
    <?php
    $templates = mysqli_query($conn, "SELECT * FROM templates");
    while ($template = mysqli_fetch_assoc($templates)) {
        echo '<tr>';
        echo '<td class="py-2 px-4 border"><img src="../assets/' . htmlspecialchars($template['template_image'] ?? '') . '" class="w-35 h-28 rounded"></td>';
        echo '<td class="py-2 px-4 border">' . htmlspecialchars($template['text'] ?? 'N/A') . '</td>';
        echo '<td class="py-2 px-4 border">' . htmlspecialchars($template['description'] ?? 'N/A') . '</td>';
        echo '<td class="py-2 px-4 border">
            <button class="bg-yellow-500 text-white p-2 rounded edit-template" data-id="' . $template['id'] . '" data-image="' . htmlspecialchars($template['template_image'] ?? '') . '" data-text="' . htmlspecialchars($template['text'] ?? '') . '" data-description="' . htmlspecialchars($template['description'] ?? '') . '" data-preview="' . htmlspecialchars($template['preview_link'] ?? '') . '" data-actual-price="' . htmlspecialchars($template['actual_price'] ?? '') . '" data-price="' . htmlspecialchars($template['price'] ?? '') . '">Edit</button>
            <a href="templates.php?delete_template_id=' . $template['id'] . '" class="bg-red-500 text-white p-2 rounded ml-2">Delete</a>
        </td>';
        echo '</tr>';
    }
    ?>
</tbody>

        </table>
    </div>

    <!-- Add/Edit Template Modal -->
    <div id="templateModal" class="hidden fixed inset-0 z-50 overflow-auto bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <div class="relative p-8 bg-white w-full max-w-md m-auto flex-col rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold mb-4 text-center">Add/Edit Template</h3>
            <form id="templateForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="template_id" id="template_id">
                <div class="mt-2">
                    <label class="block text-sm font-medium text-black text-black">Template Name</label>
                    <input type="text" name="text" id="template_text" class="border p-2 w-full text-black" required>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-black">Image</label>
                    <input type="file" name="image" id="template_image" class="border p-2 w-full text-black">
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-black">Description</label>
                    <textarea name="description" id="template_description" class="border p-2 w-full text-black" required></textarea>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-black">Preview Link</label>
                    <input type="url" name="preview_link" id="template_preview" class="border p-2 w-full text-black" required>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-black">Actual Price</label>
                    <input type="number" name="actual_price" id="template_actual_price" class="border p-2 w-full text-black" required>
                </div>
                <div class="mt-2">
                    <label class="block text-sm font-medium text-black">Price</label>
                    <input type="number" name="price" id="template_price" class="border p-2 w-full text-black" required>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">Submit</button>
                    <button type="button" id="closeModal" class="bg-gray-300 text-black p-2 rounded hover:bg-gray-400 transition">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Shine effect for the button */
@keyframes shine {
    0% {
        background-position: -100%;
    }
    100% {
        background-position: 100%;
    }
}

.animate-shine {
    animation: shine 1.5s linear infinite;
    background-size: 200%;
}
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#templatesTable').DataTable();

    // Open Add Template Modal
    $('#addTemplateButton').on('click', function() {
        $('#templateForm')[0].reset();
        $('#template_id').val('');
        $('#templateForm input[name="action"]').val('add');
        $('#templateModal').removeClass('hidden');
    });

    // Close Modal
    $('#closeModal').on('click', function() {
        $('#templateModal').addClass('hidden');
    });

    // Open Edit Template Modal
    $('.edit-template').on('click', function() {
        const templateData = $(this).data();
        $('#template_id').val(templateData.id);
        $('#template_text').val(templateData.text);
        $('#template_description').val(templateData.description);
        $('#template_preview').val(templateData.preview);
        $('#template_actual_price').val(templateData.actual_price);
        $('#template_price').val(templateData.price);
        $('#templateForm input[name="action"]').val('edit');
        $('#templateModal').removeClass('hidden');
    });

    // Close modal when clicking outside
    $(window).on('click', function(event) {
        if ($(event.target).is('#templateModal')) {
            $('#templateModal').addClass('hidden');
        }
    });
});
</script>

<?php include('../includes/footer.php'); ?>

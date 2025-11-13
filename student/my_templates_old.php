<?php
ob_start();
session_start();
header("Cache-Control: no-cache, must-revalidate"); // Prevents caching

include("../database/db.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
}
include('../includes/header.php');

// Handle removing a template
if (isset($_GET['remove_id'])) {
    $remove_id = $_GET['remove_id'];
    mysqli_query($conn, "DELETE FROM portfolios WHERE template_id	='$remove_id' AND user_id='{$_SESSION['user_id']}'");
    header("Location: my_templates.php");
}


// Handle form submission for payment

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_POST['user_id'];
  $template_id = $_POST['template_id'];
  $amount = $_POST['amount'];
  $sender_UPI_id = $_POST['sender_UPI_id'];
  $username = $_POST['username'];

  // Upload proof image
  $proof_image = $_FILES['proof_image']['name'];
  $target_dir = "../assets/pay_proof/";
  $target_file = $target_dir . basename($proof_image);

  if (move_uploaded_file($_FILES['proof_image']['tmp_name'], $target_file)) {
      // Update portfolios table with dynamic template_id
      $update_query = "UPDATE portfolios 
                       SET amount = '$amount', 
                           proof_image = '$proof_image', 
                           payment_status = 'verify', 
                           created_at = NOW(), 
                           username = '$username', 
                           sender_UPI_id = '$sender_UPI_id' 
                       WHERE user_id = '$user_id' AND template_id = '$template_id'";

      if (mysqli_query($conn, $update_query)) {
          echo "<script>
              window.onload = function() {
                  Swal.fire({
                      title: 'Payment Successful',
                      text: 'Your payment has been submitted for verification!',
                      icon: 'success',
                      confirmButtonText: 'OK'
                  }).then(function() {
                      window.location.href = 'my_templates.php';
                  });
              };
          </script>";
      } else {
          echo "<script>alert('Error updating record: " . mysqli_error($conn) . "');</script>";
      }
  } else {
      echo "<script>alert('Error uploading file.');</script>";
  }
}



?>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<!-- Include Lottie -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>

<style>
  .table-bg {
      background: linear-gradient(to right, #3b5757, #020d1b);
      color: black;
    }
    /* Adjust table header for better visibility */
    .table-header {
      background-color: #2c2c2c; /* Darker color for the header */
    }

    .progress{
      border:1px solid gray;
    }
</style>

<div class="container mx-auto p-4">
  <h1 class="text-2xl font-bold text-center p-10">My Templates Tracking Status</h1>
  
  <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table id="templatesTable" class="min-w-full display">
            <thead class="table-header text-white">


  
      <tr>
        <th>Template Image</th>
        <th>Template Name</th>
        <th>Progress</th>
        <th>Payment Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody class="table-bg">
    <?php
    $user_id = $_SESSION['user_id'];
    $portfolios = mysqli_query($conn, "SELECT portfolios.id, templates.template_name, templates.template_image, templates.price,templates.id, portfolios.status, portfolios.payment_status, portfolios.template_id
                                        FROM portfolios 
                                        INNER JOIN templates ON portfolios.template_id = templates.id 
                                      
                                        WHERE portfolios.user_id='$user_id'");

    while ($portfolio = mysqli_fetch_assoc($portfolios)) {
        $status = $portfolio['status'];
        $price = $portfolio['price'];
        
        $progress = 0;
        if ($status == 'pending') {
            $progress = 20;
        } elseif ($status == 'in progress') {
            $progress = 50;
        } elseif ($status == 'review') {
            $progress = 80;
        } elseif ($status == 'completed') {
            $progress = 100;
        }

        $payment_status = $portfolio['payment_status'] ?? 'pending';

        echo '<tr>';
        echo '<td><img src="../assets/' . $portfolio['template_image'] . '" alt="Template Image" class="w-62 h-36 rounded object-cover"></td>';

        echo '<td>' . $portfolio['template_name'] . '</td>';
        echo '<td>';
        echo '<div class="w-full bg-gray-200 rounded-full progress">';
        echo '<div class="bg-green-500 text-xs font-medium text-white text-center p-0.5 leading-none rounded-full " style="width: ' . $progress . '%"> ' . $progress . '%</div>';
        echo '</div>';
        echo '</td>';

        echo '<td>';
        if ($payment_status == 'completed' ) {
          echo ' <button class="bg-green-500 text-white p-2 rounded"> Verified</button>';
        } else {
          echo ' <button class="bg-red-500 text-white p-2 rounded"> Pending </button>';
        }

        if ($payment_status == 'completed') {
            echo ' <button class="bg-gray-500 text-white p-2 rounded" disabled>Pay Now</button>';
        } elseif ($payment_status == 'verify') {
            echo ' <button class="bg-yellow-500 text-white p-2 rounded"> Admin Verify Your Payment Details</button>';
        } elseif ($payment_status == 'failed') {
            echo ' <button class="bg-red-500 text-white p-2 rounded"> Failed</button>';
        } else {
            // Modify this line in your PHP loop where Pay Now button is created
echo ' <button class="bg-green-500 text-white p-2 rounded shine" onclick="openPaymentModal(' . $portfolio['id'] . ', ' . $user_id . ', ' . $price . ')">Pay Now</button>';


            
        }
        echo '</td>';
        // echo print_r($portfolio);
        echo '<td>';
        // if ($status == 'pending' || ($status == 'completed' && $payment_status == 'completed')) {
        if ($status == 'pending') {
            echo '<a href="update_details_form.php?template_id=' . $portfolio['template_id'] . '&user_id=' . $user_id . '" class="bg-blue-500 text-white p-2 rounded shine">Update Details</a>';
        }

        if ($status == 'pending') {
            echo ' <a href="my_templates.php?remove_id=' . $portfolio['template_id'] . '" class="bg-red-500 text-white p-2 rounded shine">Remove</a>';
        } else {
            echo ' <button class="bg-gray-500 text-white p-2 rounded" disabled>Remove</button>';
        }
        echo '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
  </table>
</div>
</div>

<!-- Payment Modal --> 
<div id="paymentModal" class="hidden fixed z-50 inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center ">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
    <h2 class="text-xl font-bold mb-4 text-black">Complete Your Payment</h2>
    <form method="POST" enctype="multipart/form-data" id="paymentForm">
      <input type="hidden" name="user_id" id="user_id">
      <input type="hidden" name="template_id" id="template_id">
      <input type="hidden" name="username" value="<?php echo $_SESSION['name']; ?>">

      <div class="mb-4 flex items-center justify-between">
        <label for="receiver_UPI_id" class="block text-sm font-bold text-black">Receiver UPI ID</label>
        <div class="flex items-center space-x-2">
          <p id="upiText" class="text-black">sridhar623016@okaxis</p>
          <button type="button" onclick="copyUPI()" class="text-blue-500 hover:text-blue-700" title="Copy UPI ID">
            📋
          </button>
        </div>
      </div>

      <!-- QR Code Image Section -->
      <div class="mb-4">
        <label class="block text-sm font-bold text-black">Receiver QR Code</label>
        <img src="../assets/pay_proof/qr.jpg" alt="Receiver QR Code" class="w-32 h-32 mx-auto border border-gray-300 rounded-lg hover:shadow-lg transition-transform duration-300 transform hover:scale-110">
      </div>

      <div class="mb-4">
        <label for="sender_UPI_id" class="block text-sm font-bold text-black">Username</label>
        <input type="text" name="username" value="<?php echo $_SESSION['name']; ?>" id="sender_UPI_id" class="w-full border border-gray-300 rounded p-2 text-black" disabled>
      </div>

      <div class="mb-4">
        <label for="sender_UPI_id" class="block text-sm font-bold text-black">Enter Your UPI ID</label>
        <input type="text" name="sender_UPI_id" id="sender_UPI_id" class="w-full border border-gray-300 rounded p-2 text-black" required>
      </div>

      <div class="mb-4">
        <label for="amount" class="block text-sm font-bold text-black">Amount</label>
        <input type="text" id="amount_display" class="w-full border border-gray-300 rounded p-2 text-black" value="<?php echo '₹ ' . $price; ?>" disabled>
        <input type="hidden" name="amount" id="amount" value="<?php echo $price; ?>">
      </div>

      <div class="mb-4">
        <label for="proof_image" class="block text-sm font-bold text-black">Proof of Payment (Image)</label>
        <input type="file" name="proof_image" id="proof_image" class="w-full border border-gray-300 rounded p-2 hover:border-blue-500 hover:shadow-lg transition-transform duration-300 transform hover:scale-105" required>
      </div>

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shine hover:bg-blue-600 transition-colors duration-200">Submit Payment</button>
      <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded ml-2 hover:bg-gray-600" onclick="closePaymentModal()">Cancel</button>
    </form>
  </div>
</div>


<script>
  // Copy UPI ID to clipboard
  function copyUPI() {
    const upiText = document.getElementById("upiText").innerText;
    navigator.clipboard.writeText(upiText).then(() => {
      alert("UPI ID copied!");
    });
  }

  // Close payment modal function
  function closePaymentModal() {
    document.getElementById("paymentModal").classList.add("hidden");
  }
</script>

<style>


  /* Animation for hover effects on input fields */
  #proof_image:hover {
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
  }
</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#templatesTable').DataTable();
    

    // Initialize Lottie Animation
    var animation = lottie.loadAnimation({
      container: document.getElementById('lottie'),
      path: 'path/to/animation.json', // Specify the path to your Lottie animation
      renderer: 'svg',
      loop: true,
      autoplay: true
    });
});


function openPaymentModal(templateId, userId, price) {
    document.getElementById('template_id').value = templateId;
    document.getElementById('user_id').value = userId;
    document.getElementById('amount').value = price; // Set the actual amount value
    document.getElementById('amount_display').value = '₹ ' + price; // Display formatted price in the modal
    document.getElementById('paymentModal').classList.remove('hidden');

  
}


// Close payment modal
function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

// Add shine effect to buttons
$('.shine').hover(function() {
    $(this).toggleClass('shine-effect');
}); 
</script>

<style>
/* Shine Effect */
.shine {
    position: relative;
    overflow: hidden;
    display: inline-block; /* Make sure the shine effect only applies to the button */
}

.shine-effect::before {
    content: '';
    position: absolute;
    top: -100%;
    left: -100%;
    width: 200%;
    height: 200%;
    background: rgba(255, 255, 255, 0.4);
    transform: rotate(130deg);
    animation: shine 0.4s forwards;
}

@keyframes shine {
    to {
        top: 100%;
        left: 100%;
    }
}

/* Optional: Button hover effect */
.shine:hover .shine-effect::before {
    animation: shine 0.3s forwards; /* Reset shine effect on hover */
}

</style>

<?php include('../includes/footer.php'); ?>
<?php
// Flush output buffer
ob_end_flush();
?>




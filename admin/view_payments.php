<?php
session_start();
include("../database/db.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
}

// Fetch all payment data with corresponding usernames
 $portfolios = mysqli_query($conn, "
    SELECT portfolios.id, portfolios.amount, portfolios.proof_image, portfolios.payment_status, portfolios.created_at, users.name, users.email
    FROM portfolios 
    JOIN users ON portfolios.user_id = users.id
");

// Fetch only completed portfolios
 $completed_portfolios = mysqli_query($conn, "
    SELECT portfolios.id, portfolios.amount, portfolios.proof_image, portfolios.payment_status, portfolios.created_at, users.name, users.email 
    FROM portfolios 
    JOIN users ON portfolios.user_id = users.id 
    WHERE portfolios.payment_status = 'completed'
");

include('../includes/header.php');
?>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Include Poppins Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --dark-navy: #0B0F19;
        --deep-gray: #1A1F2B;
        --neon-purple: #7C3AED;
        --electric-blue: #3B82F6;
        --aqua-accent: #22D3EE;
        --light-text: #E2E8F0;
        --medium-text: #94A3B8;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        background: linear-gradient(135deg, var(--dark-navy) 0%, var(--deep-gray) 100%);
        font-family: 'Poppins', sans-serif;
        color: var(--light-text);
        min-height: 100vh;
        line-height: 1.6;
    }
    
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }
    
    .header-section {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
    }
    
    .header-section h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 3rem;
        margin-bottom: 15px;
        background: linear-gradient(135deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: textGlow 3s ease-in-out infinite alternate;
    }
    
    @keyframes textGlow {
        from { filter: drop-shadow(0 0 15px rgba(124, 58, 237, 0.6)); }
        to { filter: drop-shadow(0 0 25px rgba(34, 211, 238, 0.8)); }
    }
    
    .header-section p {
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        color: var(--medium-text);
        font-size: 1.2rem;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }
    
    .stat-card {
        background: rgba(26, 31, 43, 0.8);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(124, 58, 237, 0.3);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
        background-size: 200% 100%;
        animation: gradientMove 3s ease infinite;
    }
    
    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 60px rgba(124, 58, 237, 0.3);
        border-color: rgba(124, 58, 237, 0.5);
    }
    
    .stat-card .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
        background: linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(59, 130, 246, 0.2));
        color: var(--aqua-accent);
    }
    
    .stat-card h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 10px;
        color: var(--medium-text);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .stat-card .stat-value {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2.5rem;
        color: var(--light-text);
        line-height: 1;
    }
    
    .section-container {
        background: rgba(26, 31, 43, 0.6);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        padding: 30px;
        border: 1px solid rgba(124, 58, 237, 0.2);
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        margin-bottom: 40px;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .section-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.8rem;
        color: var(--light-text);
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .section-title i {
        color: var(--aqua-accent);
        font-size: 1.5rem;
    }
    
    .search-container {
        position: relative;
        width: 350px;
    }
    
    .search-container input {
        width: 100%;
        padding: 12px 45px 12px 20px;
        border-radius: 50px;
        border: 2px solid rgba(124, 58, 237, 0.3);
        background: rgba(11, 15, 25, 0.8);
        color: var(--light-text);
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .search-container input::placeholder {
        color: var(--medium-text);
    }
    
    .search-container input:focus {
        outline: none;
        border-color: var(--neon-purple);
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.4);
        background: rgba(11, 15, 25, 0.9);
    }
    
    .search-container i {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--aqua-accent);
        font-size: 1.1rem;
    }
    
    .dataTables_wrapper {
        padding: 0;
    }
    
    .dataTables_filter {
        display: none;
    }
    
    .dataTables_length {
        margin-bottom: 20px;
    }
    
    .dataTables_length select {
        background: rgba(11, 15, 25, 0.8);
        color: var(--light-text);
        border: 1px solid rgba(124, 58, 237, 0.3);
        border-radius: 8px;
        padding: 8px 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }
    
    .dataTables_length label {
        color: var(--light-text);
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        margin-right: 10px;
    }
    
    .dataTables_info {
        color: var(--medium-text);
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        margin-top: 20px;
    }
    
    .dataTables_paginate {
        margin-top: 20px;
    }
    
    .dataTables_paginate .paginate_button {
        background: rgba(11, 15, 25, 0.8);
        color: var(--light-text);
        border: 1px solid rgba(124, 58, 237, 0.3);
        border-radius: 8px;
        padding: 8px 12px;
        margin: 0 5px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .dataTables_paginate .paginate_button.current {
        background: var(--neon-purple);
        border-color: var(--neon-purple);
        color: #fff;
    }
    
    .dataTables_paginate .paginate_button:hover {
        background: var(--electric-blue);
        border-color: var(--electric-blue);
        color: #fff;
        transform: translateY(-2px);
    }
    
    .payment-table {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0 12px;
    }
    
    .payment-table thead th {
        background: rgba(11, 15, 25, 0.8);
        color: var(--aqua-accent);
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 18px 15px;
        text-align: left;
        border: none;
        position: relative;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .payment-table thead th:first-child {
        border-radius: 12px 0 0 12px;
    }
    
    .payment-table thead th:last-child {
        border-radius: 0 12px 12px 0;
    }
    
    .payment-table tbody tr {
        background: rgba(11, 15, 25, 0.6);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
    
    .payment-table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(124, 58, 237, 0.25);
        background: rgba(11, 15, 25, 0.8);
    }
    
    .payment-table tbody td {
        padding: 18px 15px;
        color: var(--light-text);
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        font-size: 0.95rem;
        border: none;
        vertical-align: middle;
    }
    
    .payment-table tbody td:first-child {
        border-radius: 12px 0 0 12px;
        font-weight: 600;
        color: var(--aqua-accent);
    }
    
    .payment-table tbody td:last-child {
        border-radius: 0 12px 12px 0;
    }
    
    .proof-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid rgba(124, 58, 237, 0.3);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .proof-img:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
        border-color: var(--aqua-accent);
    }
    
    .no-img-text {
        color: var(--medium-text);
        font-style: italic;
        font-size: 0.9rem;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(245, 158, 11, 0.2));
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    
    .status-completed {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(22, 163, 74, 0.2));
        color: #22c55e;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .status-failed {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.2), rgba(220, 38, 38, 0.2));
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .action-btn {
        background: linear-gradient(135deg, var(--electric-blue), var(--aqua-accent));
        color: #fff;
        border: none;
        border-radius: 25px;
        padding: 10px 18px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }
    
    .action-btn:hover {
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
        transform: translateY(-2px);
    }
    
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content {
        background: linear-gradient(135deg, var(--deep-gray) 0%, rgba(26, 31, 43, 0.95) 100%);
        border-radius: 25px;
        padding: 40px;
        width: 90%;
        max-width: 550px;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(124, 58, 237, 0.3);
        transform: scale(0.8);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .modal-overlay.active .modal-content {
        transform: scale(1);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .modal-header h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.5rem;
        color: var(--light-text);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .modal-header h3 i {
        color: var(--aqua-accent);
        font-size: 1.3rem;
    }
    
    .close-btn {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: var(--medium-text);
        font-size: 1.8rem;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .close-btn:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        transform: rotate(90deg);
    }
    
    .form-field {
        margin-bottom: 25px;
    }
    
    .form-field label {
        display: block;
        margin-bottom: 10px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        color: var(--light-text);
        font-size: 0.95rem;
    }
    
    .form-field input {
        width: 100%;
        padding: 14px 18px;
        border-radius: 12px;
        border: 2px solid rgba(124, 58, 237, 0.3);
        background: rgba(11, 15, 25, 0.8);
        color: var(--light-text);
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    
    .form-field input::placeholder {
        color: var(--medium-text);
    }
    
    .form-field input:focus {
        outline: none;
        border-color: var(--neon-purple);
        box-shadow: 0 0 20px rgba(124, 58, 237, 0.4);
        background: rgba(11, 15, 25, 0.9);
    }
    
    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: 25px;
        border: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--electric-blue), var(--aqua-accent));
        color: #fff;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }
    
    .btn-primary:hover {
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: var(--light-text);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .img-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.95);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1001;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .img-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .img-modal-content {
        max-width: 90%;
        max-height: 90%;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        transform: scale(0.8);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .img-modal-overlay.active .img-modal-content {
        transform: scale(1);
    }
    
    .img-modal-close {
        position: absolute;
        top: 30px;
        right: 30px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        font-size: 2.5rem;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .img-modal-close:hover {
        background: rgba(239, 68, 68, 0.3);
        transform: rotate(90deg);
    }
    
    .bg-animation {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: -1;
        overflow: hidden;
    }
    
    .bg-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.08;
        animation: float 25s infinite ease-in-out;
    }
    
    .shape-1 {
        width: 400px;
        height: 400px;
        background: var(--neon-purple);
        top: -150px;
        right: -150px;
    }
    
    .shape-2 {
        width: 300px;
        height: 300px;
        background: var(--electric-blue);
        bottom: -100px;
        left: -100px;
        animation-delay: 8s;
    }
    
    .shape-3 {
        width: 250px;
        height: 250px;
        background: var(--aqua-accent);
        top: 50%;
        left: 50%;
        animation-delay: 15s;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(40px, -40px) rotate(120deg); }
        66% { transform: translate(-30px, 30px) rotate(240deg); }
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .main-container {
            padding: 20px 15px;
        }
        
        .header-section h1 {
            font-size: 2.2rem;
        }
        
        .header-section p {
            font-size: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .search-container {
            width: 100%;
        }
        
        .section-container {
            padding: 20px;
            border-radius: 20px;
        }
        
        .payment-table {
            font-size: 0.85rem;
        }
        
        .payment-table thead th, .payment-table tbody td {
            padding: 12px 8px;
        }
        
        .proof-img {
            width: 50px;
            height: 50px;
        }
        
        .modal-content {
            padding: 25px;
            width: 95%;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .action-btn {
            padding: 8px 14px;
            font-size: 0.8rem;
        }
    }
</style>

<div class="bg-animation">
    <div class="bg-shape shape-1"></div>
    <div class="bg-shape shape-2"></div>
    <div class="bg-shape shape-3"></div>
</div>

<div class="main-container">
    <div class="header-section">
        <h1>Payment Management</h1>
        <p>Monitor and manage all payment transactions efficiently</p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <h3>Total Payments</h3>
            <div class="stat-value"><?php echo mysqli_num_rows($portfolios); ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>Completed</h3>
            <div class="stat-value"><?php echo mysqli_num_rows($completed_portfolios); ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <h3>Pending</h3>
            <div class="stat-value"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios WHERE payment_status='pending'")); ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <h3>Total Revenue</h3>
            <div class="stat-value"> ₹ 
                
                <?php
// 1) Correct table + status (adjust if your status text differs)
$q = "
  SELECT COALESCE(SUM(amount),0) AS total
  FROM payments
  WHERE LOWER(TRIM(payment_status)) IN ('completed','success','paid')
";
$result = mysqli_query($conn, $q);

// 2) Safe fetch + numeric cast
$row   = $result ? mysqli_fetch_assoc($result) : ['total'=>0];
$total = is_numeric($row['total']) ? (float)$row['total'] : 0.0;

// 3) If you stored paise (e.g., 19900) then uncomment next line:
// $total = $total / 100;

echo number_format($total, 2);
?>

            
            </div>
        </div>
    </div>
    
    <!-- All Payments Section -->
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-list-alt"></i>
                All Payment Records
            </h2>
            <div class="search-container">
                <input type="text" id="allPaymentsSearch" placeholder="Search payments...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        
        <table id="allPaymentsTable" class="payment-table display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($portfolios, 0);
                while ($payment = mysqli_fetch_assoc($portfolios)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($payment['id'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($payment['name'] ?? 'N/A') . '</td>';
                    echo '<td> ₹ ' . number_format($payment['amount'] ?? 0, 2) . '</td>';
                    echo '<td>';
                    if (!empty($payment['proof_image'])) {
                        echo '<img src="../assets/' . htmlspecialchars($payment['proof_image']) . '" class="proof-img" onclick="showFullImage(this.src)" onerror="this.style.display=\'none\'">';
                    } else {
                        echo '<span class="no-img-text">No image</span>';
                    }
                    echo '</td>';
                    echo '<td><span class="status-badge status-' . htmlspecialchars($payment['payment_status'] ?? '') . '">' . htmlspecialchars($payment['payment_status'] ?? 'Unknown') . '</span></td>';
                    echo '<td>' . date('M j, Y', strtotime($payment['created_at'] ?? 'now')) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Completed Payments Section -->
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-check-double"></i>
                Completed Payments
            </h2>
            <div class="search-container">
                <input type="text" id="completedPaymentsSearch" placeholder="Search completed payments...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        
        <table id="completedPaymentsTable" class="payment-table display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($completed_portfolios, 0);
                while ($completed_payment = mysqli_fetch_assoc($completed_portfolios)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($completed_payment['id'] ?? '') . '</td>';
                    echo '<td>' . htmlspecialchars($completed_payment['name'] ?? 'N/A') . '</td>';
                    echo '<td>$' . number_format($completed_payment['amount'] ?? 0, 2) . '</td>';
                    echo '<td>';
                    if (!empty($completed_payment['proof_image'])) {
                        echo '<img src="../assets/' . htmlspecialchars($completed_payment['proof_image']) . '" class="proof-img" onclick="showFullImage(this.src)" onerror="this.style.display=\'none\'">';
                    } else {
                        echo '<span class="no-img-text">No image</span>';
                    }
                    echo '</td>';
                    echo '<td><span class="status-badge status-completed">' . htmlspecialchars($completed_payment['payment_status'] ?? 'Unknown') . '</span></td>';
                    echo '<td>' . date('M j, Y', strtotime($completed_payment['created_at'] ?? 'now')) . '</td>';
                    echo '<td>';
                    echo '<button class="action-btn" onclick="openModal(\'' . htmlspecialchars($completed_payment['email']) . '\', \'' . htmlspecialchars($completed_payment['name']) . '\')"><i class="fas fa-envelope"></i> Send Mail</button>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Email Modal -->
<div id="sendMailModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-envelope"></i> Send Portfolio Email</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form id="emailForm" action="mail" method="POST">
            <div class="form-field">
                <label for="portfolio_link">Portfolio Link</label>
                <input type="text" name="portfolio_link" id="portfolio_link" placeholder="Enter portfolio URL" required>
            </div>
            <div class="form-field">
                <label for="email">Email Address</label>
                <input type="email" name="user_email" id="user_email" placeholder="recipient@example.com" required>
            </div>
            <div class="form-field">
                <label for="name">Username</label>
                <input type="text" name="user_name" id="user_name" placeholder="John Doe" required>
            </div>
            <div class="form-actions">
                <button type="submit" name="send_email" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Send Email
                </button>
                <button type="button" onclick="closeModal()" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="img-modal-overlay">
    <button class="img-modal-close" onclick="closeImageModal()">&times;</button>
    <img id="fullImage" class="img-modal-content" src="" alt="Full Size Image">
</div>

<script>
 $(document).ready(function() {
    // Initialize DataTables for all payments
    var allPaymentsTable = $('#allPaymentsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "language": {
            "search": "",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ payments",
            "paginate": {
                "first": "First",
                "last": "Last", 
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
    
    // Initialize DataTables for completed payments
    var completedPaymentsTable = $('#completedPaymentsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "dom": '<"top"lf>rt<"bottom"ip><"clear">',
        "language": {
            "search": "",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ completed payments",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next", 
                "previous": "Previous"
            }
        }
    });
    
    // Custom search functionality
    $('#allPaymentsSearch').on('keyup', function() {
        allPaymentsTable.search(this.value).draw();
    });
    
    $('#completedPaymentsSearch').on('keyup', function() {
        completedPaymentsTable.search(this.value).draw();
    });
});

// Modal functions
function openModal(email, name) {
    document.getElementById('user_email').value = email; 
    document.getElementById('user_name').value = name; 
    document.getElementById('sendMailModal').classList.add('active');
}

function closeModal() {
    document.getElementById('sendMailModal').classList.remove('active');
}

function showFullImage(src) {
    document.getElementById('fullImage').src = src;
    document.getElementById('imageModal').classList.add('active');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.remove('active');
}

// Close modals when clicking outside
document.getElementById('sendMailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>

<?php include('../includes/footer.php'); ?>
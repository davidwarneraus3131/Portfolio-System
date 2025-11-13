<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="description" content="Teck Spiral - Your gateway to innovative tech solutions.">
<meta name="keywords" content="Tech, Solutions, Innovative, Teck Spiral">
<meta name="author" content="Teck Spiral">
<meta name="theme-color" content="#0B0F19">

<!-- Google Fonts - Poppins & Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Custom CSS -->
<link rel="stylesheet" href="../css/styles.css">

<title>SRIDHAR'S-PORTFOLIO</title>

<!-- Favicon -->
<link rel="icon" href="https://saphotel.in/test/demo_files/admin/sri_logo.jpg" type="image/png">

<style>
    /* CSS Variables for Professional Color Palette */
    :root {
        --dark-navy: #0B0F19;
        --deep-gray: #1A1F2B;
        --neon-purple: #7C3AED;
        --electric-blue: #3B82F6;
        --aqua-accent: #22D3EE;
        --success-green: #10B981;
        --warning-amber: #F59E0B;
        --danger-red: #EF4444;
        --gradient-primary: linear-gradient(135deg, var(--dark-navy) 0%, var(--deep-gray) 100%);
        --gradient-accent: linear-gradient(135deg, var(--neon-purple) 0%, var(--electric-blue) 100%);
        --gradient-success: linear-gradient(135deg, #10B981 0%, #059669 100%);
        --gradient-border: linear-gradient(135deg, var(--neon-purple), var(--electric-blue), var(--aqua-accent));
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
        --shadow-2xl: 0 25px 50px rgba(0, 0, 0, 0.25);
    }

    /* Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: var(--gradient-primary);
        color: #E5E7EB;
        line-height: 1.6;
        overflow-x: hidden;
        padding-top: 80px;
        min-height: 100vh;
    }

    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: var(--deep-gray);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--gradient-accent);
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--neon-purple);
    }

    /* Navigation Styles */
    .navbar {
        background: rgba(11, 15, 25, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        padding: 1rem 0;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
        box-shadow: var(--shadow-xl);
        border-bottom: 1px solid rgba(124, 58, 237, 0.1);
    }

    .nav-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        position: relative;
    }

    .logo {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        border: 2px solid var(--aqua-accent);
        box-shadow: 0 0 20px rgba(34, 211, 238, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .logo:hover {
        transform: rotate(8deg) scale(1.1);
        box-shadow: 0 0 30px rgba(34, 211, 238, 0.5);
    }

    .logo-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.6rem;
        background: var(--gradient-accent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        position: relative;
    }

    .logo-text::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient-accent);
        transition: width 0.3s ease;
    }

    .logo-container:hover .logo-text::after {
        width: 100%;
    }

    .nav-menu {
        display: flex;
        list-style: none;
        gap: 2.5rem;
        align-items: center;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        color: #D1D5DB;
        font-weight: 500;
        font-size: 0.95rem;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-accent);
        border-radius: 8px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .nav-link:hover {
        color: #fff;
        transform: translateY(-2px);
    }

    .nav-link:hover::before {
        opacity: 0.1;
    }

    .nav-link-tooltip {
        position: absolute;
        bottom: -45px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(26, 31, 43, 0.98);
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-size: 0.8rem;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(124, 58, 237, 0.2);
        width: 280px;
        text-align: center;
        font-weight: 400;
    }

    .nav-link-tooltip::before {
        content: '';
        position: absolute;
        top: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid rgba(26, 31, 43, 0.98);
    }

    .nav-item:hover .nav-link-tooltip {
        opacity: 1;
        visibility: visible;
        bottom: -50px;
    }

    .hamburger {
        display: none;
        flex-direction: column;
        cursor: pointer;
        background: transparent;
        border: none;
        padding: 0.5rem;
    }

    .hamburger span {
        width: 28px;
        height: 3px;
        background: var(--gradient-accent);
        margin: 4px 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 3px;
    }

    .hamburger.active span:nth-child(1) {
        transform: rotate(-45deg) translate(-8px, 8px);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
        transform: scale(0);
    }

    .hamburger.active span:nth-child(3) {
        transform: rotate(45deg) translate(-8px, -8px);
    }

    .mobile-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: rgba(11, 15, 25, 0.98);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-top: 1px solid rgba(124, 58, 237, 0.2);
        padding: 2rem 0;
        box-shadow: var(--shadow-2xl);
        transform: translateY(-100%);
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .mobile-menu.active {
        display: block;
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
    }

    .mobile-menu-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }

    .mobile-menu-link {
        color: #D1D5DB;
        font-weight: 500;
        font-size: 1rem;
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        display: block;
        width: 200px;
        text-align: center;
    }

    .mobile-menu-link:hover {
        color: #fff;
        background: rgba(124, 58, 237, 0.1);
        transform: translateX(5px);
    }

    /* User Profile */
    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 1rem;
        background: rgba(26, 31, 43, 0.6);
        border-radius: 50px;
        border: 1px solid rgba(124, 58, 237, 0.2);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .user-profile:hover {
        background: rgba(26, 31, 43, 0.8);
        border-color: var(--aqua-accent);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--aqua-accent);
        box-shadow: 0 0 10px rgba(34, 211, 238, 0.3);
    }

    .user-name {
        color: #fff;
        font-weight: 500;
        font-size: 0.9rem;
        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Main Container */
    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 2rem;
    }

    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
    }

    .page-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 3rem;
        background: var(--gradient-accent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .page-subtitle {
        color: #9CA3AF;
        font-size: 1.1rem;
        font-weight: 400;
        max-width: 600px;
        margin: 0 auto;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 4px;
        background: var(--gradient-accent);
        border-radius: 4px;
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: rgba(26, 31, 43, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid rgba(124, 58, 237, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-border);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(124, 58, 237, 0.3);
    }

    .stat-card:hover::before {
        opacity: 0.1;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    .stat-icon.primary {
        background: var(--gradient-accent);
        color: white;
    }

    .stat-icon.success {
        background: var(--gradient-success);
        color: white;
    }

    .stat-icon.warning {
        background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        color: white;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: #9CA3AF;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Template Cards */
    .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .template-card {
        background: rgba(26, 31, 43, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(124, 58, 237, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .template-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-border);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
        border-radius: 20px;
        padding: 2px;
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask-composite: exclude;
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
    }

    .template-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: var(--shadow-2xl);
        border-color: rgba(124, 58, 237, 0.3);
    }

    .template-card:hover::before {
        opacity: 1;
    }

    .template-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .template-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .template-card:hover .template-image {
        transform: scale(1.1);
    }

    .template-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 0%, rgba(11, 15, 25, 0.8) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .template-card:hover .template-overlay {
        opacity: 1;
    }

    .template-details {
        padding: 2rem;
    }

    .template-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1.5rem;
    }

    .template-name {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.3rem;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .template-price {
        font-size: 1.5rem;
        font-weight: 700;
        background: var(--gradient-accent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Progress Section */
    .progress-section {
        margin-bottom: 1.5rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .progress-label {
        color: #9CA3AF;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .progress-value {
        color: #fff;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .progress-bar {
        height: 10px;
        background: rgba(124, 58, 237, 0.1);
        border-radius: 10px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        background: var(--gradient-accent);
        border-radius: 10px;
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .status-badge i {
        font-size: 0.8rem;
    }

    .status-verified {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-pending {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .status-verify {
        background: rgba(245, 158, 11, 0.15);
        color: #F59E0B;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .status-failed {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: var(--gradient-accent);
        color: white;
        box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(124, 58, 237, 0.4);
    }

    .btn-secondary {
        background: rgba(26, 31, 43, 0.8);
        color: #fff;
        border: 1px solid rgba(124, 58, 237, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(124, 58, 237, 0.2);
        border-color: var(--neon-purple);
        transform: translateY(-2px);
    }

    .btn-danger {
        background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* Table Styles */
    .table-container {
        background: rgba(26, 31, 43, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(124, 58, 237, 0.1);
        margin-bottom: 2rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: rgba(26, 31, 43, 0.8);
    }

    .data-table th {
        color: #fff;
        padding: 1.25rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(124, 58, 237, 0.2);
    }

    .data-table td {
        padding: 1.25rem;
        border-bottom: 1px solid rgba(124, 58, 237, 0.1);
        color: #E5E7EB;
        vertical-align: middle;
    }

    .data-table tbody tr {
        transition: all 0.3s ease;
    }

    .data-table tbody tr:hover {
        background: rgba(124, 58, 237, 0.05);
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 15, 25, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        padding: 2rem;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .payment-modal {
        background: rgba(26, 31, 43, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 24px;
        width: 100%;
        max-width: 550px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-2xl);
        border: 1px solid rgba(124, 58, 237, 0.2);
        transform: scale(0.9) translateY(20px);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .modal-overlay.active .payment-modal {
        transform: scale(1) translateY(0);
    }

    .modal-header {
        background: var(--gradient-accent);
        color: white;
        padding: 2rem;
        border-radius: 24px 24px 0 0;
        position: relative;
    }

    .modal-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1.5rem;
    }

    .modal-close {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: #fff;
        font-size: 0.95rem;
    }

    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid rgba(124, 58, 237, 0.2);
        border-radius: 12px;
        background: rgba(26, 31, 43, 0.6);
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--neon-purple);
        box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
        background: rgba(26, 31, 43, 0.8);
    }

    .form-input:disabled {
        background: rgba(26, 31, 43, 0.3);
        color: #6B7280;
        cursor: not-allowed;
    }

    .qr-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 2rem 0;
        padding: 2rem;
        background: rgba(26, 31, 43, 0.4);
        border-radius: 16px;
        border: 1px solid rgba(124, 58, 237, 0.1);
    }

    .qr-code {
        width: 180px;
        height: 180px;
        border-radius: 12px;
        padding: 1rem;
        background: white;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-lg);
    }

    .copy-upi {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--aqua-accent);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        background: rgba(34, 211, 238, 0.1);
    }

    .copy-upi:hover {
        background: rgba(34, 211, 238, 0.2);
        transform: translateY(-2px);
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding: 0 2rem 2rem;
    }

    /* Responsive Design */
    @media (max-width: 1023px) {
        .nav-menu {
            display: none;
        }
        
        .hamburger {
            display: flex;
        }
        
        .table-container {
            display: none;
        }
        
        .stats-container {
            grid-template-columns: 1fr;
        }
    }

    @media (min-width: 1024px) {
        .mobile-cards {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .main-container {
            padding: 2rem 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .template-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
        
        .nav-container {
            padding: 0 1rem;
        }
    }

    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .btn-secondary {
  background: transparent;
  color: grey !important;
  border: 2px solid var(--electric-blue);
}
</style>

<!-- Header Navigation Bar -->


<?php
ob_start();

include("../database/db.php");
include("../includes/header.php");

if ($_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
}

// Handle removing a template
if (isset($_GET['remove_id'])) {
    $remove_id = $_GET['remove_id'];
    mysqli_query($conn, "DELETE FROM portfolios WHERE template_id ='$remove_id' AND user_id='{$_SESSION['user_id']}'");
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
                      title: 'Payment Successful!',
                      text: 'Your payment has been submitted for verification.',
                      icon: 'success',
                      confirmButtonText: 'Great!',
                      confirmButtonColor: '#7C3AED',
                      background: '#0B0F19',
                      color: '#E5E7EB',
                      showClass: {
                          popup: 'animate__animated animate__fadeInDown'
                      },
                      hideClass: {
                          popup: 'animate__animated animate__fadeOutUp'
                      }
                  }).then(function() {
                      window.location.href = 'my_templates.php';
                  });
              };
          </script>";
      } else {
          echo "<script>
              Swal.fire({
                  title: 'Error!',
                  text: 'Error updating record: " . mysqli_error($conn) . "',
                  icon: 'error',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#7C3AED',
                  background: '#0B0F19',
                  color: '#E5E7EB'
              });
          </script>";
      }
  } else {
      echo "<script>
          Swal.fire({
              title: 'Upload Error!',
              text: 'Error uploading file.',
              icon: 'error',
              confirmButtonText: 'OK',
              confirmButtonColor: '#7C3AED',
              background: '#0B0F19',
              color: '#E5E7EB'
          });
      </script>";
  }
}

// Get statistics
 $user_id = $_SESSION['user_id'];
 $total_templates = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios WHERE user_id='$user_id'"));
 $completed_templates = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios WHERE user_id='$user_id' AND status='completed'"));
 $pending_payments = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM portfolios WHERE user_id='$user_id' AND payment_status!='completed'"));
?>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<div class="main-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">My Templates</h1>
        <p class="page-subtitle">Track your portfolio progress and manage your templates efficiently</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-value"><?php echo $total_templates; ?></div>
            <div class="stat-label">Total Templates</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value"><?php echo $completed_templates; ?></div>
            <div class="stat-label">Completed</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value"><?php echo $pending_payments; ?></div>
            <div class="stat-label">Pending Payments</div>
        </div>
    </div>
  
    <!-- Mobile Cards View -->
    <div class="mobile-cards">
        <div class="template-grid">
            <?php
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
                
                echo '<div class="template-card">';
                echo '<div class="template-image-container">';
                echo '<img src="../assets/' . $portfolio['template_image'] . '" alt="Template Image" class="template-image">';
                echo '<div class="template-overlay"></div>';
                echo '</div>';
                echo '<div class="template-details">';
                echo '<div class="template-header">';
                echo '<div>';
                echo '<h3 class="template-name">' . $portfolio['template_name'] . '</h3>';
                echo '</div>';
                echo '<div class="template-price">₹' . $price . '</div>';
                echo '</div>';
                
                echo '<div class="progress-section">';
                echo '<div class="progress-header">';
                echo '<span class="progress-label">Progress</span>';
                echo '<span class="progress-value">' . $progress . '%</span>';
                echo '</div>';
                echo '<div class="progress-bar">';
                echo '<div class="progress-fill" style="width: ' . $progress . '%"></div>';
                echo '</div>';
                echo '</div>';
                
                echo '<div>';
                if ($payment_status == 'completed' ) {
                  echo '<span class="status-badge status-verified"><i class="fas fa-check-circle"></i> Verified</span>';
                } else {
                  echo '<span class="status-badge status-pending"><i class="fas fa-exclamation-circle"></i> Pending</span>';
                }
                echo '</div>';
                
                echo '<div class="action-buttons">';
                if ($payment_status == 'completed') {
                    echo '<button class="btn btn-secondary" disabled><i class="fas fa-check"></i> Paid</button>';
                } elseif ($payment_status == 'verify') {
                    echo '<button class="btn btn-secondary"><i class="fas fa-hourglass-half"></i> Verifying</button>';
                } elseif ($payment_status == 'failed') {
                    echo '<button class="btn btn-danger"><i class="fas fa-times-circle"></i> Failed</button>';
                } else {
                    echo '<button class="btn btn-primary" onclick="openPaymentModal(' . $portfolio['id'] . ', ' . $user_id . ', ' . $price . ')"><i class="fas fa-credit-card"></i> Pay Now</button>';
                }
                
                if ($status == 'pending') {
                    echo '<a href="update_details_form.php?template_id=' . $portfolio['template_id'] . '&user_id=' . $user_id . '" class="btn btn-secondary"><i class="fas fa-edit"></i> Update</a>';
                }
                
                if ($status == 'pending') {
                    echo '<a href="my_templates.php?remove_id=' . $portfolio['template_id'] . '" class="btn btn-danger"><i class="fas fa-trash"></i> Remove</a>';
                } else {
                    echo '<button class="btn btn-secondary" disabled><i class="fas fa-lock"></i> Locked</button>';
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
  
    <!-- Desktop Table View -->
    <div class="table-container">
        <table id="templatesTable" class="data-table">
            <thead>
                <tr>
                    <th>Template</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Progress</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
                    echo '<td><img src="../assets/' . $portfolio['template_image'] . '" alt="Template Image" class="w-20 h-16 rounded-lg object-cover"></td>';
                    echo '<td><strong>' . $portfolio['template_name'] . '</strong></td>';
                    echo '<td><span style="color: #10B981; font-weight: 600;">₹' . $price . '</span></td>';
                    echo '<td>';
                    echo '<div class="progress-section" style="margin-bottom: 0;">';
                    echo '<div class="progress-bar">';
                    echo '<div class="progress-fill" style="width: ' . $progress . '%"></div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="text-xs mt-1" style="color: #9CA3AF;">' . $progress . '%</div>';
                    echo '</td>';

                    echo '<td>';
                    if ($payment_status == 'completed' ) {
                      echo '<span class="status-badge status-verified"><i class="fas fa-check-circle"></i> Verified</span>';
                    } else {
                      echo '<span class="status-badge status-pending"><i class="fas fa-exclamation-circle"></i> Pending</span>';
                    }
                    echo '</td>';
                    
                    echo '<td>';
                    echo '<div class="action-buttons" style="gap: 0.5rem;">';
                    if ($payment_status == 'completed') {
                        echo '<button class="btn btn-secondary" disabled style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-check"></i> Paid</button>';
                    } elseif ($payment_status == 'verify') {
                        echo '<button class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-hourglass-half"></i> Verifying</button>';
                    } elseif ($payment_status == 'failed') {
                        echo '<button class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-times-circle"></i> Failed</button>';
                    } else {
                        echo '<button class="btn btn-primary" onclick="openPaymentModal(' . $portfolio['id'] . ', ' . $user_id . ', ' . $price . ')" style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-credit-card"></i> Pay</button>';
                    }
                    
                    if ($status == 'pending') {
                        echo '<a href="update_details_form.php?template_id=' . $portfolio['template_id'] . '&user_id=' . $user_id . '" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-edit"></i></a>';
                    }

                    if ($status == 'pending') {
                        echo '<a href="my_templates.php?remove_id=' . $portfolio['template_id'] . '" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-trash"></i></a>';
                    } else {
                        echo '<button class="btn btn-secondary" disabled style="padding: 0.5rem 1rem; font-size: 0.85rem;"><i class="fas fa-lock"></i></button>';
                    }
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Payment Modal --> 
<div id="paymentModal" class="modal-overlay">
    <div class="payment-modal">
        <div class="modal-header">
            <h2 class="modal-title">Complete Your Payment</h2>
            <span class="modal-close" onclick="closePaymentModal()">
                <i class="fas fa-times"></i>
            </span>
        </div>
        
        <form method="POST" enctype="multipart/form-data" id="paymentForm">
            <div class="modal-body">
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="template_id" id="template_id">
                <input type="hidden" name="username" value="<?php echo $_SESSION['name']; ?>">

                <div class="form-group">
                    <label class="form-label">Receiver UPI ID</label>
                    <div class="flex items-center justify-between" style="background: rgba(26, 31, 43, 0.6); padding: 1rem; border-radius: 12px; border: 1px solid rgba(124, 58, 237, 0.2);">
                        <p id="upiText" style="font-weight: 600; color: #fff;">sridhar623016@okaxis</p>
                        <button type="button" onclick="copyUPI()" class="copy-upi">
                            <i class="far fa-copy"></i> Copy
                        </button>
                    </div>
                </div>

                <div class="qr-container">
                    <label class="form-label" style="text-align: center; margin-bottom: 1rem;">Scan QR Code</label>
                    <img src="../assets/pay_proof/qr.jpg" alt="Receiver QR Code" class="qr-code">
                </div>

                <div class="form-group">
                    <label for="sender_UPI_id" class="form-label">Your Name</label>
                    <input type="text" name="username" value="<?php echo $_SESSION['name']; ?>" id="sender_UPI_id" class="form-input" disabled>
                </div>

                <div class="form-group">
                    <label for="sender_UPI_id" class="form-label">Your UPI ID</label>
                    <input type="text" name="sender_UPI_id" id="sender_UPI_id" class="form-input" placeholder="yourname@upi" required>
                </div>

                <div class="form-group">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="text" id="amount_display" class="form-input" value="<?php echo '₹ ' . $price; ?>" disabled>
                    <input type="hidden" name="amount" id="amount" value="<?php echo $price; ?>">
                </div>

                <div class="form-group">
                    <label for="proof_image" class="form-label">Payment Proof</label>
                    <input type="file" name="proof_image" id="proof_image" class="form-input" accept="image/*" required>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closePaymentModal()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit Payment</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Copy UPI ID to clipboard
    function copyUPI() {
        const upiText = document.getElementById("upiText").innerText;
        navigator.clipboard.writeText(upiText).then(() => {
            Swal.fire({
                title: 'Copied!',
                text: 'UPI ID copied to clipboard',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                confirmButtonColor: '#7C3AED',
                background: '#0B0F19',
                color: '#E5E7EB',
                toast: true,
                position: 'top-end'
            });
        });
    }

    // Close payment modal function
    function closePaymentModal() {
        document.getElementById('paymentModal').classList.remove('active');
    }

    // Initialize DataTable
    $(document).ready(function() {
        $('#templatesTable').DataTable({
            responsive: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search templates...",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            dom: '<"top"lf>rt<"bottom"ip>'
        });
    });

    function openPaymentModal(templateId, userId, price) {
        document.getElementById('template_id').value = templateId;
        document.getElementById('user_id').value = userId;
        document.getElementById('amount').value = price;
        document.getElementById('amount_display').value = '₹ ' + price;
        document.getElementById('paymentModal').classList.add('active');
    }
</script>

<?php include('../includes/footer.php'); ?>

<?php
// Flush output buffer
ob_end_flush();
?>
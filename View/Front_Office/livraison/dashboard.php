<!DOCTYPE html>
<html lang="fr">

<?php require_once '../includes/header.php'; ?>
<style>
    body {
        background-color: #f4f7f6;
        font-family: 'Arial', sans-serif;
    }


    .main-content {
        margin-left: 270px;
        padding: 20px;
    }

    .card {
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        position: relative;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
        text-align: center;
        position: relative;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 1rem;
        margin-top: 10px;
    }

    /* Style for Voir Détails button */
    .btn-details {
        color: #007bff;
        text-decoration: none;
        font-size: 1rem;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        margin-top: 10px;
        transition: color 0.3s ease;
        border: 1px solid #007bff;
        border-radius: 5px;
        padding: 6px 12px;
        cursor: pointer;
    }

    .btn-details:hover {
        color: white;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-details .fa-arrow-right {
        margin-left: 8px;
        font-size: 1.2rem;
        transition: transform 0.3s ease;
    }

    .btn-details:hover .fa-arrow-right {
        transform: translateX(5px);
    }

    .row {
        margin-bottom: 20px;
    }

    /* Add a soft and professional color scheme for different cards */
    .bg-primary {
        background-color: #007bff !important;
        color: white;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: black;
    }

    .bg-success {
        background-color: #28a745 !important;
        color: white;
    }

    .bg-danger {
        background-color: #dc3545 !important;
        color: white;
    }

    .bg-info {
        background-color: #17a2b8 !important;
        color: white;
    }

    .bg-light {
        background-color: #f8f9fa !important;
        color: #333;
    }

    .bg-secondary {
        background-color: #6c757d !important;
        color: white;
    }

    .card-footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 12.5%;
        /* 1/8th of the card height */
        background: rgba(0, 0, 0, 0.1);
        /* darker shade */
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card .number {
        position: absolute;
        top: 10px;
        left: 10px;
        font-size: 2rem;
        font-weight: bold;
    }

    .card .status {
        position: absolute;
        bottom: 10px;
        left: 10px;
        font-size: 0.9rem;
        font-weight: bold;
    }

    .card .status-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
        }

        .main-content {
            margin-left: 0;
        }

        .row .col-md-3 {
            width: 100%;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-text {
            font-size: 0.9rem;
        }
    }

    .card-header {
        display: flex;
        align-items: center;
        background-color: #2ecc71;
        /* Unigreen color */
        color: white;
        padding: 15px;
        border-radius: 10px;
        /* Rounded edges for the header */
        position: absolute;
        top: -35px;
        left: 2px;
        width: calc(100% - 10px);
        /* To fit with the card width */
    }

    .icon {
        background: #2ecc71;
        /* Unigreen color */
        color: white;
        border-radius: 5px;
        /* Now it's rectangular */
        padding: 20px;
        margin-right: 10px;
        margin-bottom: 15px;
    }

    .card {
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
    }

    .btn-primary {
        background-color: #2ecc71;
        border-color: #2ecc71;
    }

    .btn-primary:hover {
        background-color: #27ae60;
        border-color: #27ae60;
    }

    .card .fa {
        transition: transform 0.3s ease;
    }

    .card:hover .fa {
        transform: scale(1.15);
    }

    .card-hover {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .card-hover {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    /* Custom soft background classes */
    .bg-light-info {
        background-color: #e0f3ff;
    }

    .bg-light-warning {
        background-color: #fff3cd;
    }

    .bg-light-secondary {
        background-color: #f0f0f0;
    }

    .bg-light-primary {
        background-color: #e3f2fd;
    }

    .bg-light-danger {
        background-color: #f8d7da;
    }

    .bg-light-dark {
        background-color: #e2e3e5;
    }

    .bg-light-success {
        background-color: #d1e7dd;
    }

    .card-glow {
        transition: all 0.3s ease;
    }

    .card-glow:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.15);
    }

    .card-body h5,
    .card-body p,
    .card-body .fa {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .btn-light {
        transition: background-color 0.2s ease;
    }

    .btn-light:hover {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }

    .card-glow {
        border-radius: 1.5rem;
        animation: glowPulse 3s ease-in-out infinite;
        transition: transform 0.3s ease;
    }

    .card-glow:hover {
        transform: scale(1.03);
        box-shadow: 0 0 40px rgba(255, 255, 255, 0.1);
    }

    .icon-glow {
        filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.3));
    }

    .card h5,
    .card p {
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
        letter-spacing: 0.3px;
    }

    @keyframes glowPulse {

        0%,
        100% {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
        }

        50% {
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.1);
        }
    }
</style>

<body>
    <div class="wrapper">
        <?php require_once '../includes/configurator.php'; ?>
        <?php require_once '../includes/sidenav.php'; ?>
        <div class="main-panel">
            <?php require_once '../includes/navbar.php'; ?>

            <div class="content">
                <div class="container-fluid py-4">
                    <div class="row">
                        <?php
                        $cards = [
                            ['title' => 'Total Created', 'number' => 0, 'color' => 'primary', 'icon' => 'fa-plus-circle', 'desc' => 'Created orders'],
                            ['title' => 'Packages Pending', 'number' => 0, 'color' => 'warning', 'icon' => 'fa-hourglass-half', 'desc' => 'In queue'],
                            ['title' => 'Packages to Pick Up', 'number' => 0, 'color' => 'secondary', 'icon' => 'fa-truck-loading', 'desc' => 'Waiting for pickup'],
                            ['title' => 'Packages Picked Up', 'number' => 0, 'color' => 'info', 'icon' => 'fa-truck', 'desc' => 'Already picked up'],
                            ['title' => 'Pickup Issues', 'number' => 0, 'color' => 'danger', 'icon' => 'fa-exclamation-triangle', 'desc' => 'To be resolved'],
                            ['title' => 'Packages in Depot', 'number' => 0, 'color' => 'dark', 'icon' => 'fa-warehouse', 'desc' => 'Stored in depot'],
                            ['title' => 'Return to Depot', 'number' => 0, 'color' => 'danger', 'icon' => 'fa-undo', 'desc' => 'To be returned'],
                            ['title' => 'Out for Delivery', 'number' => 0, 'color' => 'success', 'icon' => 'fa-shipping-fast', 'desc' => 'In transit'],
                            ['title' => 'Delivery Issues', 'number' => 0, 'color' => 'danger', 'icon' => 'fa-exclamation-circle', 'desc' => 'To be verified'],
                            ['title' => 'Delivered Packages', 'number' => 0, 'color' => 'success', 'icon' => 'fa-check-circle', 'desc' => 'Successfully delivered'],
                            ['title' => 'Paid Deliveries', 'number' => 0, 'color' => 'secondary', 'icon' => 'fa-money-check-alt', 'desc' => 'Already paid'],
                            ['title' => 'Final Return', 'number' => 0, 'color' => 'danger', 'icon' => 'fa-ban', 'desc' => 'Final return completed'],
                            ['title' => 'Client Return - Agency', 'number' => 0, 'color' => 'warning', 'icon' => 'fa-exchange-alt', 'desc' => 'Returned to client'],
                            ['title' => 'Paid Deliveries Collected', 'number' => 0, 'color' => 'dark', 'icon' => 'fa-hand-holding-usd', 'desc' => 'Payment collected'],
                            ['title' => 'Return to Sender', 'number' => 0, 'color' => 'danger', 'icon' => 'fa-arrow-left', 'desc' => 'To be returned to sender'],
                            ['title' => 'Return Received', 'number' => 0, 'color' => 'success', 'icon' => 'fa-inbox', 'desc' => 'Return received'],
                            ['title' => 'Exchange Created', 'number' => 0, 'color' => 'info', 'icon' => 'fa-retweet', 'desc' => 'New exchange initiated'],
                            ['title' => 'Exchange Received', 'number' => 0, 'color' => 'success', 'icon' => 'fa-sync-alt', 'desc' => 'Exchange completed'],
                            ['title' => 'Claims', 'number' => 0, 'color' => 'danger', 'icon' => 'fa-comment-dots', 'desc' => 'To be processed quickly'],
                        ];


                        foreach ($cards as $card) {
                        ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                <div class="card text-white h-100 shadow-lg border-0 position-relative overflow-hidden bg-<?= $card['color'] ?> rounded-3">
                                    <div class="card-body d-flex flex-column justify-content-between p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="display-6 fw-bold"><?= $card['number'] ?></div>
                                            <i class="fa <?= $card['icon'] ?> fa-2x icon-<?= $card['color'] ?> text-white"></i>
                                        </div>
                                        <h5 class="fw-semibold mb-1"><?= $card['title'] ?></h5>
                                        <p class="mb-3 small"><?= $card['desc'] ?></p>
                                        <a href="#" class="btn btn-outline-light btn-sm mt-auto d-flex justify-content-between align-items-center fw-medium">
                                            See Details <i class="fa fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <style>
                    .card-glow {
                        border-radius: 1.5rem;
                        animation: glowPulse 3s ease-in-out infinite;
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                    }

                    .card-glow:hover {
                        transform: scale(1.05);
                        box-shadow: 0 0 25px rgba(255, 255, 255, 0.2);
                    }

                    .icon-Primary {
                        color: #0d6efd;
                        filter: drop-shadow(0 0 7px rgba(13, 110, 253, 0.7));
                    }

                    .icon-Secondary {
                        color: #6c757d;
                        filter: drop-shadow(0 0 7px rgba(108, 117, 125, 0.7));
                    }

                    .icon-Warning {
                        color: #ffc107;
                        filter: drop-shadow(0 0 7px rgba(255, 193, 7, 0.7));
                    }

                    .icon-Danger {
                        color: #dc3545;
                        filter: drop-shadow(0 0 7px rgba(220, 53, 69, 0.7));
                    }

                    .icon-Success {
                        color: #198754;
                        filter: drop-shadow(0 0 7px rgba(25, 135, 84, 0.7));
                    }

                    .icon-Dark {
                        color: #212529;
                        filter: drop-shadow(0 0 7px rgba(33, 37, 41, 0.7));
                    }

                    .icon-Info {
                        color: #17a2b8;
                        filter: drop-shadow(0 0 7px rgba(23, 162, 184, 0.7));
                    }

                    .card h5,
                    .card p {
                        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
                        letter-spacing: 0.5px;
                    }

                    .card p {
                        font-size: 0.9rem;
                        line-height: 1.4;
                    }

                    .btn-outline-light {
                        border-color: rgba(255, 255, 255, 0.5);
                        color: rgba(255, 255, 255, 0.8);
                        background-color: transparent;
                        transition: background-color 0.3s ease;
                    }

                    .btn-outline-light:hover {
                        background-color: rgba(255, 255, 255, 0.1);
                        border-color: rgba(255, 255, 255, 0.8);
                    }

                    @keyframes glowPulse {

                        0%,
                        100% {
                            box-shadow: 0 0 15px rgba(255, 255, 255, 0.05);
                        }

                        50% {
                            box-shadow: 0 0 40px rgba(255, 255, 255, 0.2);
                        }
                    }
                </style>


                <?php require_once '../includes/footer.php'; ?>
            </div> <!-- content -->
        </div> <!-- main-panel -->
    </div> <!-- wrapper -->
</body>



</html>
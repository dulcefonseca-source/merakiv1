<!DOCTYPE html>
<html lang="es"
      data-theme="<?php echo e(auth()->user()?->theme_preference ?? 'light'); ?>"
      data-bs-theme="<?php echo e(auth()->user()?->theme_preference ?? 'light'); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Inicio'); ?> | Meraki Signature</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            color-scheme: light;
            --meraki-primary: #BD8980;
            --meraki-primary-dark: #A96F68;
            --meraki-rose: #F7E9E8;
            --meraki-champagne: #D5B69C;
            --meraki-ivory: #FBF9F7;
            --meraki-white: #FFFFFF;
            --meraki-text: #55464A;
            --meraki-muted: #9C8D91;
            --meraki-border: #EFE6E5;
            --meraki-surface-soft: #FBF8F6;
            --meraki-input-bg: #FFFFFF;
            --meraki-table-head: #FBF8F6;
            --sidebar-width: 258px;
            --shadow-soft: 0 4px 20px rgba(105, 70, 75, 0.045);
            --shadow-card: 0 8px 28px rgba(105, 70, 75, 0.055);
        }

        html[data-theme="dark"] {
            color-scheme: dark;
            --meraki-primary: #C5968E;
            --meraki-primary-dark: #D3A69D;
            --meraki-rose: #49383F;
            --meraki-champagne: #B99A80;
            --meraki-ivory: #211F23;
            --meraki-white: #2D292F;
            --meraki-text: #EEE6E5;
            --meraki-muted: #B7A8AD;
            --meraki-border: #494047;
            --meraki-surface-soft: #352F35;
            --meraki-input-bg: #302B31;
            --meraki-table-head: #393239;
            --shadow-soft: 0 4px 20px rgba(0, 0, 0, .13);
            --shadow-card: 0 8px 28px rgba(0, 0, 0, .18);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--meraki-ivory);
            color: var(--meraki-text);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            overflow-x: hidden;
            transition: background-color .22s ease, color .22s ease;
        }

        .main-content {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
            padding: 28px 32px 0;
            transition: margin .25s ease, background-color .22s ease;
            display: flex;
            flex-direction: column;
        }

        .main-content > .container-fluid {
            flex: 1 0 auto;
            padding-left: 0;
            padding-right: 0;
        }

        h1, h2, h3, h4, h5, h6 { color: var(--meraki-text); }

        .page-heading {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--meraki-text);
        }

        .content-card {
            background: var(--meraki-white);
            border: 1px solid var(--meraki-border);
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--shadow-soft);
        }

        .btn-meraki {
            background: var(--meraki-primary);
            border: 1px solid var(--meraki-primary);
            color: white;
            border-radius: 9px;
            padding: 10px 17px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .btn-meraki:hover {
            background: var(--meraki-primary-dark);
            border-color: var(--meraki-primary-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-meraki-outline {
            background: transparent;
            color: var(--meraki-primary);
            border: 1px solid var(--meraki-primary);
            border-radius: 9px;
            padding: 10px 17px;
        }

        .btn-meraki-outline:hover {
            background: var(--meraki-rose);
            color: var(--meraki-primary-dark);
        }

        .form-control, .form-select {
            border: 1px solid var(--meraki-border);
            border-radius: 9px;
            padding: 10px 13px;
            color: var(--meraki-text);
            background-color: var(--meraki-input-bg);
            font-size: 13px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--meraki-primary);
            box-shadow: 0 0 0 3px rgba(189, 137, 128, .12);
        }

        .form-label {
            color: var(--meraki-text);
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--meraki-text);
            --bs-table-border-color: var(--meraki-border);
            color: var(--meraki-text);
            font-size: 13px;
            vertical-align: middle;
        }

        .table thead th {
            color: var(--meraki-muted);
            background: var(--meraki-table-head);
            border-bottom: 1px solid var(--meraki-border);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
            padding: 14px;
        }

        .table tbody td {
            padding: 14px;
            border-color: var(--meraki-border);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-pending { background: #FFF4E5; color: #AD8143; }
        .status-confirmed { background: #EAF4ED; color: #568365; }
        .status-completed { background: #EEEAF7; color: #8069A6; }
        .status-cancelled { background: #F9EAEA; color: #B66C6C; }

        a { text-decoration: none; }
        .text-muted { color: var(--meraki-muted) !important; }

        ::selection {
            background: var(--meraki-rose);
            color: var(--meraki-primary-dark);
        }

        .meraki-footer {
            width: 100%;
            margin-top: 35px;
            padding: 22px 15px 20px;
            border-top: 1px solid var(--meraki-border);
            text-align: center;
            background: transparent;
        }

        .meraki-footer-credit {
            color: var(--meraki-text);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .2px;
            margin-bottom: 5px;
        }

        .meraki-footer-credit .heart {
            color: var(--meraki-primary);
            display: inline-block;
            margin: 0 2px;
        }

        .meraki-footer-brand {
            color: var(--meraki-primary-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 7px;
        }

        .meraki-footer-legal,
        .meraki-footer-dedication {
            color: var(--meraki-muted);
            font-size: 10px;
            line-height: 1.7;
            margin-bottom: 2px;
        }

        .meraki-footer-dedication { font-style: italic; }

        /* MODO OSCURO: componentes compartidos */
        html[data-theme="dark"] .sidebar {
            background: #29252A !important;
            border-color: var(--meraki-border) !important;
            --sb-ink: #EEE6E5;
            --sb-muted: #B7A8AD;
            --sb-rose: #D0A19A;
            --sb-rose-soft: #49383F;
            --sb-border: #494047;
        }

        html[data-theme="dark"] .sidebar .sidebar-divider,
        html[data-theme="dark"] .sidebar .sidebar-section-divider,
        html[data-theme="dark"] .sidebar .sidebar-footer {
            border-color: var(--meraki-border) !important;
        }

        html[data-theme="dark"] .sidebar .sidebar-label,
        html[data-theme="dark"] .sidebar .sidebar-user-info small,
        html[data-theme="dark"] .sidebar .sidebar-footer small { color: #B7A8AD !important; }

        html[data-theme="dark"] .sidebar .menu-item { color: #D1C5C7 !important; }
        html[data-theme="dark"] .sidebar .menu-item > i { color: #C69A92 !important; }

        html[data-theme="dark"] .sidebar .menu-item:hover,
        html[data-theme="dark"] .sidebar .menu-item.active {
            background: #49383F !important;
            border-color: #5A454D !important;
            color: #F4E8E6 !important;
        }

        html[data-theme="dark"] .sidebar .sidebar-user {
            background: #342F35 !important;
            border-color: #494047 !important;
        }

        html[data-theme="dark"] .sidebar .sidebar-user-info strong { color: #EEE6E5 !important; }
        html[data-theme="dark"] .sidebar .logout-button { color: #C8B9BD !important; }
        html[data-theme="dark"] .sidebar .logout-button:hover {
            background: #49383F !important;
            color: #F2DDDA !important;
        }

        html[data-theme="dark"] .content-card,
        html[data-theme="dark"] .card,
        html[data-theme="dark"] .profile-card,
        html[data-theme="dark"] .support-topic,
        html[data-theme="dark"] .support-contact,
        html[data-theme="dark"] .support-faq .accordion-item,
        html[data-theme="dark"] .modal-content,
        html[data-theme="dark"] .dropdown-menu,
        html[data-theme="dark"] .list-group-item {
            background-color: var(--meraki-white) !important;
            color: var(--meraki-text) !important;
            border-color: var(--meraki-border) !important;
        }

        html[data-theme="dark"] .card-header,
        html[data-theme="dark"] .card-footer,
        html[data-theme="dark"] .table thead th {
            background-color: var(--meraki-table-head) !important;
            color: var(--meraki-muted) !important;
            border-color: var(--meraki-border) !important;
        }

        html[data-theme="dark"] .form-control,
        html[data-theme="dark"] .form-select,
        html[data-theme="dark"] .input-group-text {
            background-color: var(--meraki-input-bg) !important;
            color: var(--meraki-text) !important;
            border-color: var(--meraki-border) !important;
        }

        html[data-theme="dark"] .form-control::placeholder { color: #9E9097 !important; }
        html[data-theme="dark"] .form-label,
        html[data-theme="dark"] label { color: #D8CCCE; }

        html[data-theme="dark"] .table,
        html[data-theme="dark"] .table tbody td,
        html[data-theme="dark"] .table tbody th {
            color: var(--meraki-text) !important;
            border-color: var(--meraki-border) !important;
        }

        html[data-theme="dark"] .text-dark,
        html[data-theme="dark"] .text-body { color: var(--meraki-text) !important; }

        html[data-theme="dark"] .support-intro {
            background: linear-gradient(115deg, #332D32 0%, #3C3038 58%, #44343B 100%) !important;
            border-color: var(--meraki-border) !important;
        }

        html[data-theme="dark"] .support-topic p,
        html[data-theme="dark"] .support-contact p,
        html[data-theme="dark"] .support-section-subtitle,
        html[data-theme="dark"] .support-description { color: #BBAFB3 !important; }

        html[data-theme="dark"] .support-topic h3,
        html[data-theme="dark"] .support-contact h3,
        html[data-theme="dark"] .support-section-title { color: #F0E7E5 !important; }

        html[data-theme="dark"] .support-topic-icon,
        html[data-theme="dark"] .support-contact-icon,
        html[data-theme="dark"] .profile-avatar,
        html[data-theme="dark"] .preference-icon {
            background: #49383F !important;
            color: #D3A69D !important;
        }

        html[data-theme="dark"] .support-note,
        html[data-theme="dark"] .password-guidance {
            background: #393239 !important;
            border-color: #74565C !important;
            color: #C6B8BC !important;
        }

        html[data-theme="dark"] .support-faq .accordion-button {
            background: #2D292F !important;
            color: #EAE0E0 !important;
        }

        html[data-theme="dark"] .support-faq .accordion-button:not(.collapsed) {
            background: #3C3038 !important;
            color: #D9B2AB !important;
        }

        html[data-theme="dark"] .support-faq .accordion-body { color: #C6B8BC !important; }

        html[data-theme="dark"] .profile-card-title,
        html[data-theme="dark"] .profile-name,
        html[data-theme="dark"] .profile-meta-value,
        html[data-theme="dark"] .preference-copy strong,
        html[data-theme="dark"] .profile-form-label { color: #EEE6E5 !important; }

        html[data-theme="dark"] .profile-card-description,
        html[data-theme="dark"] .profile-email,
        html[data-theme="dark"] .profile-meta-label,
        html[data-theme="dark"] .profile-help { color: #B7A8AD !important; }

        html[data-theme="dark"] .profile-divider,
        html[data-theme="dark"] .preference-item { border-color: var(--meraki-border) !important; }

        html[data-theme="dark"] .theme-choice {
            background: #302B31 !important;
            color: #EDE3E3 !important;
            border-color: var(--meraki-border) !important;
        }

        html[data-theme="dark"] .theme-choice.selected {
            background: #49383F !important;
            border-color: #B9877E !important;
        }

        html[data-theme="dark"] .profile-status { color: #A8CEAF !important; }
        html[data-theme="dark"] .modal-header,
        html[data-theme="dark"] .modal-footer { border-color: var(--meraki-border) !important; }
        html[data-theme="dark"] .btn-close { filter: invert(1) grayscale(1); }

        html[data-theme="dark"] .meraki-footer { border-color: var(--meraki-border); }
        html[data-theme="dark"] hr { border-color: var(--meraki-border); opacity: 1; }

        @media (max-width: 992px) {
            .main-content { padding: 24px 20px 0; }
        }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 18px 15px 0; }
            .content-card { padding: 18px; }
            .meraki-footer { margin-top: 25px; padding: 20px 10px; }
        }

        @media print {
            .meraki-footer { display: none !important; }
            html[data-theme="dark"] body { background: #fff !important; color: #000 !important; }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="main-content">
        <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container-fluid">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <footer class="meraki-footer">
            <div class="meraki-footer-credit">
                Made with <span class="heart">♥</span> by DulceMaria
            </div>
            <div class="meraki-footer-brand">MERAKI · 2026</div>
            <div class="meraki-footer-legal">
                © 2026 Meraki Signature. All rights reserved.
            </div>
            <div class="meraki-footer-dedication">
                Desarrollado para Pao · Con cariño.
            </div>
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp1\htdocs\meraki-signature\resources\views/layouts/app.blade.php ENDPATH**/ ?>
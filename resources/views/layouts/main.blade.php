<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Perpustakaan Digital')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== LIGHT MODE (default) ===== */
        .page-title {
            max-width: 80rem;
            margin: 1.5rem auto 1rem;
            padding: 0 1.5rem;
        }
        .page-title h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }
        .page-title p {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
        .crud-card {
            max-width: 80rem;
            margin: 1.5rem auto;
            background: #ffffff;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            border: 1px solid #f3f4f6;
            color: #1f2937;
        }
        .crud-card ul,
        .crud-card li {
            color: #1f2937;
        }
        .crud-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1.25rem;
        }
        .crud-card-header h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
        }
        .crud-card-header small {
            color: #6b7280;
        }
        .badge-pill {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
        }
        .badge-primary { background: #e0e7ff; color: #4338ca; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.35rem;
        }
        .form-group .required { color: #dc2626; }
        .form-control {
            width: 100%;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.15s ease;
            background: #ffffff;
            color: #1f2937;
        }
        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-primary { background: #4f46e5; color: #ffffff; }
        .btn-primary:hover { background: #4338ca; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-secondary:hover { background: #d1d5db; }
        .btn-outline { background: transparent; border: 1px solid #d1d5db; color: #374151; }
        .btn-outline:hover { background: #f9fafb; }
        .btn-sm { font-size: 0.75rem; padding: 0.35rem 0.65rem; }
        .table-responsive { overflow-x: auto; }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }
        .data-table th {
            background-color: #f9fafb;
            color: #4b5563;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .data-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            color: #1f2937;
        }
        .data-table td strong {
            color: #1f2937;
        }
        .data-table tr:hover { background-color: #f9fafb; }
        .badge-kategori {
            display: inline-block;
            background: #f3f4f6;
            color: #4b5563;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 0.375rem;
        }
        .action-cell { white-space: nowrap; }
        .btn-edit {
            background: #f59e0b;
            color: #ffffff;
            border: none;
            border-radius: 0.375rem;
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            cursor: pointer;
            margin-right: 0.35rem;
        }
        .btn-edit:hover { background: #d97706; }
        .btn-delete {
            background: #ef4444;
            color: #ffffff;
            border: none;
            border-radius: 0.375rem;
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            cursor: pointer;
        }
        .btn-delete:hover { background: #dc2626; }
        .alert {
            max-width: 80rem;
            margin: 1rem auto;
            padding: 0.85rem 1.25rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            justify-content: space-between;
            align-items: center;
        }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* ===== DARK MODE — HARUS DI PALING BAWAH ===== */
        @media (prefers-color-scheme: dark) {
            .page-title h2 { color: #f3f4f6; }
            .page-title p { color: #9ca3af; }
            .crud-card {
                background: #1f2937;
                border-color: #374151;
                color: #f3f4f6;
            }
            .crud-card ul,
            .crud-card li {
                color: #f3f4f6;
            }
            .crud-card-header {
                border-bottom-color: #374151;
            }
            .crud-card-header h3 { color: #f3f4f6; }
            .crud-card-header small { color: #9ca3af; }
            .form-group label { color: #d1d5db; }
            .form-control {
                background: #374151;
                border-color: #4b5563;
                color: #f3f4f6;
            }
            .data-table th {
                background-color: #374151;
                color: #d1d5db;
                border-bottom-color: #4b5563;
            }
            .data-table td {
                color: #f3f4f6;
                border-bottom-color: #374151;
            }
            .data-table td strong {
                color: #f3f4f6;
            }
            .data-table tr:hover { background-color: #374151; }
            .badge-kategori {
                background: #374151;
                color: #d1d5db;
            }
            .btn-secondary { background: #374151; color: #d1d5db; }
            .btn-secondary:hover { background: #4b5563; }
            .btn-outline { border-color: #4b5563; color: #d1d5db; }
            .btn-outline:hover { background: #374151; }
            .alert-success { background: #064e3b; color: #a7f3d0; border-color: #065f46; }
            .alert-danger { background: #7f1d1d; color: #fecaca; border-color: #991b1b; }
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <main>
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>

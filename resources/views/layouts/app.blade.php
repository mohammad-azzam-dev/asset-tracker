<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gold & Silver Tracker')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Modern Theme -->
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #8b5cf6;
            --accent: #06b6d4;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1e293b;
            --darker: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            --border: #e2e8f0;
        }

        body { font-family: 'Inter', 'Source Sans Pro', sans-serif; }

        /* Sidebar - Modern Dark */
        .main-sidebar { background: linear-gradient(180deg, var(--darker) 0%, var(--dark) 100%) !important; border-right: 1px solid rgba(255,255,255,0.05); }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important; color: #fff !important; border-radius: 8px; margin: 0 8px; }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover { background: rgba(255,255,255,0.08) !important; color: #fff !important; border-radius: 8px; margin: 0 8px; }
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link { color: rgba(255,255,255,0.7) !important; border-radius: 8px; margin: 2px 8px; transition: all 0.2s ease; }
        .brand-link { background: transparent !important; border-bottom: 1px solid rgba(255,255,255,0.08) !important; padding: 20px 16px !important; }
        .brand-text { color: #fff !important; font-weight: 600 !important; font-size: 1.1rem !important; }
        .nav-icon { color: rgba(255,255,255,0.5) !important; }
        .nav-link.active .nav-icon { color: #fff !important; }
        .nav-header { color: rgba(255,255,255,0.4) !important; font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase; padding: 16px 24px 8px !important; }

        /* Navbar */
        .main-header.navbar { background: #fff !important; border: none !important; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .main-header .nav-link { color: var(--dark) !important; }
        .main-header .nav-link:hover { color: var(--primary) !important; }
        .main-header .dropdown-menu { border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 8px; }
        .main-header .dropdown-item { border-radius: 8px; padding: 10px 16px; }
        .main-header .dropdown-item:hover { background: var(--light); color: var(--primary) !important; }

        /* Content */
        .content-wrapper { background: var(--light) !important; }
        .content-header h1 { font-weight: 700; color: var(--dark); }

        /* Cards */
        .card { border: none !important; border-radius: 16px !important; box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03) !important; overflow: hidden; }
        .card-header { background: #fff !important; border-bottom: 1px solid var(--border) !important; padding: 20px 24px !important; }
        .card-title { font-weight: 600; color: var(--dark); margin: 0; }
        .card-body { padding: 24px !important; }

        /* Info Boxes */
        .info-box { border-radius: 16px; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .info-box-icon { border-radius: 12px; width: 70px; height: 70px; font-size: 1.8rem; }

        /* Small Boxes */
        .small-box { border-radius: 16px !important; overflow: hidden; }
        .small-box h3 { font-size: 2rem; font-weight: 700; }
        .small-box .icon { font-size: 5rem; opacity: 0.15; }
        .small-box .small-box-footer { background: rgba(0,0,0,0.08) !important; }
        .bg-info { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important; }
        .bg-success { background: linear-gradient(135deg, var(--success) 0%, #059669 100%) !important; }
        .bg-warning { background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%) !important; }
        .bg-danger { background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%) !important; }

        /* Tables */
        .table { border-collapse: separate; border-spacing: 0; }
        .table thead th { background: var(--light); color: var(--gray); font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; border: none !important; padding: 16px; }
        .table tbody td { padding: 16px; border-bottom: 1px solid var(--border) !important; border-top: none !important; vertical-align: middle; }
        .table tbody tr:hover { background: var(--light); }

        /* Buttons */
        .btn { border-radius: 10px; font-weight: 500; padding: 10px 20px; transition: all 0.2s ease; }
        .btn-primary { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary-hover) 0%, #7c3aed 100%); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,0.4); }
        .btn-success { background: linear-gradient(135deg, var(--success) 0%, #059669 100%); border: none; }
        .btn-danger { background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%); border: none; }
        .btn-info { background: linear-gradient(135deg, var(--accent) 0%, #0891b2 100%); border: none; }
        .btn-outline-primary { color: var(--primary); border: 2px solid var(--primary); background: transparent; }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); }
        .btn-sm { padding: 6px 14px; font-size: 0.85rem; }

        /* Forms */
        .form-control { border-radius: 10px; border: 1px solid var(--border); padding: 12px 16px; transition: all 0.2s ease; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(99,102,241,0.1); }
        label { font-weight: 500; color: var(--dark); margin-bottom: 8px; }

        /* Alerts */
        .alert { border-radius: 12px; border: none; }
        .alert-success { background: rgba(16,185,129,0.1); color: #059669; }
        .alert-danger { background: rgba(239,68,68,0.1); color: #dc2626; }

        /* Modals */
        .modal-content { border: none; border-radius: 20px; overflow: hidden; }
        .modal-header { border-bottom: 1px solid var(--border); padding: 24px; }
        .modal-title { font-weight: 600; }
        .modal-body { padding: 24px; }
        .modal-footer { border-top: 1px solid var(--border); padding: 16px 24px; }

        /* Pagination */
        .page-link { border-radius: 10px !important; margin: 0 4px; border: none; color: var(--gray); }
        .page-link:hover { background: var(--light); color: var(--primary); }
        .page-item.active .page-link { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); border: none; }

        /* Badges */
        .badge { padding: 6px 12px; border-radius: 8px; font-weight: 500; }
        .badge-primary, .bg-primary { background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important; }

        /* Footer */
        .main-footer { background: #fff !important; border-top: 1px solid var(--border) !important; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--gray); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--dark); }

        /* Utility */
        .text-primary { color: var(--primary) !important; }
        .text-success { color: var(--success) !important; }
        .text-danger { color: var(--danger) !important; }
        .elevation-4 { box-shadow: none !important; }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="actionsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bolt"></i> Actions
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="actionsDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addPurchaseModal">
                        <i class="fas fa-plus text-success"></i> Add Purchase
                    </a>
                    <a class="dropdown-item" href="#" id="navbar-refresh-prices">
                        <i class="fas fa-sync-alt text-info"></i> Refresh Prices
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <span class="nav-link">{{ Auth::user()->name }}</span>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
            @endauth
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-text font-weight-light">Stock Tracker</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('purchases.index') }}" class="nav-link {{ request()->routeIs('purchases.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>My Purchases</p>
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-in-alt"></i>
                            <p>Login</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>Register</p>
                        </a>
                    </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('header')</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <strong>Gold & Silver Tracker</strong>
    </footer>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
@stack('scripts')
</body>
</html>

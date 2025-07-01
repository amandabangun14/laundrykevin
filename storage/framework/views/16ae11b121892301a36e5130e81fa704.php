<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Dashboard - <?php echo e(config('app.name', 'Laravel')); ?></title>
    
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-speedometer2 me-2"></i>
                <?php echo e(config('app.name', 'Laravel')); ?>

            </a>
            
            <!-- Toggle button for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Right side menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            Admin User
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text"><i class="bi bi-person me-2"></i>Profile</span></li>
                            <li><span class="dropdown-item-text"><i class="bi bi-gear me-2"></i>Settings</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><span class="dropdown-item-text text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</span></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar shadow-sm">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <span class="nav-link active bg-primary text-white rounded">
                                <i class="bi bi-house-door me-2"></i>
                                Dashboard
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark">
                                <i class="bi bi-people me-2"></i>
                                Users
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark">
                                <i class="bi bi-file-earmark-text me-2"></i>
                                Posts
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark">
                                <i class="bi bi-graph-up me-2"></i>
                                Analytics
                            </span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link text-dark">
                                <i class="bi bi-gear me-2"></i>
                                Settings
                            </span>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 fw-bold">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-download me-1"></i>Export
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-printer me-1"></i>Print
                            </button>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add New
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-primary border-4 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Users</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">1,245</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-people display-6 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-success border-4 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Total Posts</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">3,890</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-file-earmark-text display-6 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-info border-4 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Total Views</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">156,234</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-eye display-6 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-warning border-4 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">Pending Tasks</div>
                                        <div class="h5 mb-0 fw-bold text-gray-800">24</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-clock display-6 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row mb-4">
                    <!-- Chart Area -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow-sm">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 fw-bold text-primary">Revenue Overview</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <div class="bg-light rounded p-5 text-center">
                                        <i class="bi bi-graph-up display-1 text-muted"></i>
                                        <p class="text-muted mt-3">Chart will be displayed here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow-sm">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 fw-bold text-primary">Revenue Sources</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie">
                                    <div class="bg-light rounded p-4 text-center">
                                        <i class="bi bi-pie-chart display-3 text-muted"></i>
                                        <p class="text-muted mt-2 small">Pie chart will be displayed here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header py-3">
                                <h6 class="m-0 fw-bold text-primary">Recent Activity</h6>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-start border-0">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">New user registered</div>
                                            <small class="text-muted">John Doe joined the platform</small>
                                        </div>
                                        <small class="text-muted">2h ago</small>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-start border-0">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">New post published</div>
                                            <small class="text-muted">Article about Laravel tips</small>
                                        </div>
                                        <small class="text-muted">4h ago</small>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-start border-0">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">System backup completed</div>
                                            <small class="text-muted">Daily backup successful</small>
                                        </div>
                                        <small class="text-muted">6h ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header py-3">
                                <h6 class="m-0 fw-bold text-primary">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button class="btn btn-outline-primary w-100">
                                            <i class="bi bi-plus-circle me-2"></i>
                                            Add User
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-success w-100">
                                            <i class="bi bi-file-plus me-2"></i>
                                            New Post
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-info w-100">
                                            <i class="bi bi-graph-up me-2"></i>
                                            View Reports
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-warning w-100">
                                            <i class="bi bi-gear me-2"></i>
                                            Settings
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\laragon\www\kevinlaundry\resources\views/dashboard.blade.php ENDPATH**/ ?>
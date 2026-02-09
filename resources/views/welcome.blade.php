<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e1b2e;
            color: #fff;
        }
        .sidebar {
            background-color: #2c2643;
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background-color: #1e1b2e;
        }
        .main-content {
            background-color: #2c2643;
            padding: 2rem;
            min-height: 100vh;
        }
        .submenu {
            list-style: none;
            padding-left: 1.5rem;
        }
        .submenu .nav-link {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar py-4">
            <div class="text-center mb-4">
                <h4>Admin</h4>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#userMgmtSubmenu" role="button" aria-expanded="false" aria-controls="userMgmtSubmenu">
                        User Management
                    </a>
                    <ul class="collapse submenu" id="userMgmtSubmenu">
                        <li class="nav-item"><a class="nav-link" href="/admin/users/admins">Admins</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/users/qas">QAs</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/users/trainers">Teachers</a></li>
                        <li class="nav-item"><a class="nav-link" href="/admin/users/trainees">Students</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto main-content">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<main class="col-md-10 ms-sm-auto main-content">
    <div style="background: #2c2643;padding: 20px;border-radius: 10px">
        <h2>Welcome to the Admin Panel</h2>
        <p>This is your dashboard. Use the sidebar to navigate through your management tools.</p>
    </div>
</main>

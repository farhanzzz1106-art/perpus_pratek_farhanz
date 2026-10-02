<?php

session_start();

require_once __DIR__ . '/config/database.php';

// Cek login
if (!isset($_SESSION['user'])) {
    header("Location: users/index.php");
    exit;
}

$user = $_SESSION['user'];
$username = htmlspecialchars($user['username']);

// ==========================
// DATA DASHBOARD
// ==========================

// Total buku
$total_buku = 0;
$result = $conn->query("SELECT COUNT(*) AS total FROM buku");

if ($result) {
    $data = $result->fetch_assoc();
    $total_buku = $data['total'];
}

// Total anggota
$total_anggota = 0;
$result = $conn->query("SELECT COUNT(*) AS total FROM anggota");

if ($result) {
    $data = $result->fetch_assoc();
    $total_anggota = $data['total'];
}

// Menunggu persetujuan
$menunggu = 0;
$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM peminjaman
    WHERE status = 'menunggu'
");

if ($result) {
    $data = $result->fetch_assoc();
    $menunggu = $data['total'];
}

// Sedang dipinjam
$dipinjam = 0;
$result = $conn->query("
    SELECT COUNT(*) AS total
    FROM peminjaman
    WHERE status = 'dipinjam'
");

if ($result) {
    $data = $result->fetch_assoc();
    $dipinjam = $data['total'];
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Perpustakaan</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #222;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 65px;
            background: #173f6b;
            display: flex;
            align-items: center;
            padding: 0 35px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        .logo {
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin-right: 45px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.2s;
        }

        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .logout {
            margin-left: auto;
        }

        .logout a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 6px;
        }

        .logout a:hover {
            background: #c0392b;
        }


        /* =========================
           CONTENT
        ========================= */

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 28px;
            margin-bottom: 8px;
            color: #1f2937;
        }

        .welcome p {
            color: #6b7280;
            font-size: 15px;
        }


        /* =========================
           CARD STATISTIK
        ========================= */

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e8ebf0;
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.10);
        }

        .card-title {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 12px;
        }

        .card-number {
            font-size: 32px;
            font-weight: bold;
            color: #173f6b;
        }

        .card-description {
            margin-top: 8px;
            font-size: 13px;
            color: #9ca3af;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .navbar {
                padding: 0 20px;
            }

            .logo {
                margin-right: 20px;
            }

        }


        @media (max-width: 600px) {

            .navbar {
                height: auto;
                padding: 15px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .logo {
                width: 100%;
                margin-right: 0;
            }

            .nav-menu {
                width: 100%;
                flex-wrap: wrap;
            }

            .logout {
                margin-left: 0;
            }

            .container {
                padding: 25px 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .welcome h1 {
                font-size: 24px;
            }

        }

    </style>

</head>

<body>


<!-- =========================
     NAVBAR
========================= -->

<nav class="navbar">

    <div class="logo">
        Perpustakaan
    </div>

    <div class="nav-menu">

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="buku/index.php">
            Katalog Buku
        </a>

        <a href="peminjaman/index.php">
            Peminjaman
        </a>

        <a href="users/index.php">
            Kelola User
        </a>

    </div>

    <div class="logout">

        <a href="logout.php">
            Logout (<?= $username ?>)
        </a>

    </div>

</nav>


<!-- =========================
     CONTENT
========================= -->

<main class="container">

    <div class="welcome">

        <h1>
            Selamat datang, <?= $username ?> 👋
        </h1>

        <p>
            Selamat datang di sistem informasi perpustakaan.
        </p>

    </div>


    <!-- =========================
         STATISTIK
    ========================= -->

    <div class="cards">

        <!-- Total Buku -->
        <div class="card">

            <div class="card-title">
                Total Buku
            </div>

            <div class="card-number">
                <?= $total_buku ?>
            </div>

            <div class="card-description">
                Buku tersedia di perpustakaan
            </div>

        </div>


        <!-- Total Anggota -->
        <div class="card">

            <div class="card-title">
                Total Anggota
            </div>

            <div class="card-number">
                <?= $total_anggota ?>
            </div>

            <div class="card-description">
                Anggota terdaftar
            </div>

        </div>


        <!-- Menunggu -->
        <div class="card">

            <div class="card-title">
                Menunggu Persetujuan
            </div>

            <div class="card-number">
                <?= $menunggu ?>
            </div>

            <div class="card-description">
                Peminjaman menunggu persetujuan
            </div>

        </div>


        <!-- Sedang Dipinjam -->
        <div class="card">

            <div class="card-title">
                Sedang Dipinjam
            </div>

            <div class="card-number">
                <?= $dipinjam ?>
            </div>

            <div class="card-description">
                Buku sedang dipinjam
            </div>

        </div>

    </div>

</main>


</body>

</html>
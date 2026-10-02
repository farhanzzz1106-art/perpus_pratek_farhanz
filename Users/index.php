<?php

session_start();

require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Includes/auth.php';

$result = $conn->query(
    "SELECT id, username, role, anggota_id
     FROM users
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola User</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
        }

        .navbar {
            background: #173f6b;
            padding: 18px 30px;
            display: flex;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 25px;
            font-size: 14px;
        }

        .logout {
            margin-left: auto;
            margin-right: 0 !important;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        }

        h2 {
            margin-top: 0;
            color: #173f6b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border-bottom: 1px solid #ddd;
            padding: 13px;
            text-align: left;
        }

        th {
            background: #173f6b;
            color: white;
        }

        tr:hover {
            background: #f5f7fb;
        }

    </style>

</head>

<body>

<nav class="navbar">

    <a href="../Dashboard.php">
        Dashboard
    </a>

    <a href="../Buku/index.php">
        Katalog Buku
    </a>

    <a href="../Peminjaman/index.php">
        Peminjaman
    </a>

    <a href="index.php">
        Kelola User
    </a>

    <a class="logout" href="../Auth/logout.php">
        Logout
    </a>

</nav>

<div class="container">

    <div class="box">

        <h2>
            Kelola User
        </h2>

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Anggota ID</th>
                </tr>

            </thead>

            <tbody>

            <?php if ($result && $result->num_rows > 0): ?>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($row['id']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['username']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['role']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['anggota_id'] ?? '-') ?>
                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="4">
                        Belum ada user.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>
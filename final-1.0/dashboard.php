<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

include 'connect.php';

$search = $_GET['search'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index_number = $_POST['index_number'];
    $course_code = $_POST['course_code'];
    $course_name = $_POST['course_name'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO results (index_number, course_code, course_name, grade)
            VALUES ('$index_number', '$course_code', '$course_name', '$grade')";
    mysqli_query($conn, $sql);
}

if ($search !== '') {
    $search_esc = mysqli_real_escape_string($conn, $search);
    $query = "SELECT * FROM results WHERE index_number LIKE '%$search_esc%'";
} else {
    $query = "SELECT * FROM results";
}

$results = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lecturer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #264653;
            --primary-light: #2a9d8f;
            --accent-color: #e76f51;
            --text-primary: #1e293b;
            --text-secondary: #4b5563;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --light-bg: #f8fafc;
            --danger-color: #c62828;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc, #eef2f5);
            margin: 0;
            padding: 0;
            color: var(--text-primary);
        }

        header {
            background: var(--card-bg);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .logo h1 {
            margin: 0;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .logout-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 600;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: var(--danger-color);
            color: #fff;
            border-color: var(--danger-color);
        }

        main {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 1rem;
        }

        .card {
            background: var(--card-bg);
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        h2, h3 {
            margin-top: 0;
            font-weight: 700;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        input[type="text"], input[type="number"] {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            background-color: var(--light-bg);
            flex: 1;
            min-width: 180px;
        }

        button {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--accent-color));
        }

        a.reset-btn {
            display: inline-block;
            padding: 0.75rem 1.2rem;
            background: var(--light-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: 0.2s;
        }

        a.reset-btn:hover {
            background: #e0f2f1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 1rem;
            border-top: 1px solid var(--border-color);
            text-align: left;
        }

        th {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-transform: uppercase;
        }

        td a {
            text-decoration: none;
            color: var(--primary-light);
            font-weight: 500;
        }

        td a:hover {
            color: var(--accent-color);
        }

        .no-results {
            text-align: center;
            color: var(--text-secondary);
            padding: 2rem 0;
        }
    </style>
</head>
<body>

<header>
    <div class="logo"><h1><i class="fa-solid fa-chalkboard-user"></i> Lecturer Dashboard</h1></div>
    <div><a href="logout.php" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></div>
</header>

<main>
    <div class="card">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by Index Number" value="<?= htmlspecialchars($search) ?>">
            <button type="submit"><i class="fa-solid fa-search"></i> Search</button>
            <a href="dashboard.php" class="reset-btn">Reset</a>
        </form>
    </div>

    <div class="card">
        <h3>Student Results</h3>
        <table>
            <thead>
                <tr>
                    <th>Index Number</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($results) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($results)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['index_number']) ?></td>
                            <td><?= htmlspecialchars($row['course_code']) ?></td>
                            <td><?= htmlspecialchars($row['course_name']) ?></td>
                            <td><strong><?= htmlspecialchars($row['grade']) ?></strong></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a> |
                                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this record?');">
                                    <i class="fa-solid fa-trash-can"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="no-results">No results found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Add New Result</h3>
        <form method="POST" action="">
            <input type="text" name="index_number" placeholder="Index Number" required>
            <input type="text" name="course_code" placeholder="Course Code" required>
            <input type="text" name="course_name" placeholder="Course Name" required>
            <input type="text" name="grade" placeholder="Grade" required>
            <button type="submit"><i class="fa-solid fa-plus"></i> Add</button>
        </form>
    </div>
</main>

</body>
</html>

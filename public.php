<?php
include 'db.php';
$students = $conn->query("SELECT * FROM students");

if (!$students) {
    die("Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Public Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Student List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $students->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$conn->close();
?>
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

include 'db.php';

// Function to sanitize input
function sanitizeInput($input) {
    global $conn;
    return htmlspecialchars(stripslashes(trim($conn->real_escape_string($input)))); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $first_name = sanitizeInput($_POST['first_name']);
        $last_name = sanitizeInput($_POST['last_name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);

        $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $first_name, $last_name, $email, $phone);

        if ($stmt->execute()) {
            // Success message (you can use a session variable to display it)
            $_SESSION['message'] = "Student added successfully!";
            header("Location: admin.php"); // Redirect to avoid form resubmission
            exit;
        } else {
            // Error handling
            echo "Error: " . $stmt->error; 
        }
        $stmt->close();
    } elseif (isset($_POST['edit'])) {
        // ... (similarly implement prepared statements for edit and delete)
    } elseif (isset($_POST['delete'])) {
        // ...
    }
}

$students = $conn->query("SELECT * FROM students"); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Admin Dashboard</h1>
    <a href="logout.php">Logout</a>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?> 
    <?php endif; ?>

    <h2>Add Student</h2>
    <form method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <button type="submit" name="add">Add</button>
    </form>

    <h2>Students</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $students->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td> 
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="edit">Edit</button>
                    </form>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
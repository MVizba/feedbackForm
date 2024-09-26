<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

global $pdo;
require 'database.php';
require 'classes/DeleteFeedback.php';
require 'classes/ReadUnread.php';

$deleteFeedback = new DeleteFeedback($pdo);
$readUnread = new ReadUnread($pdo);

try {
    $sql = "SELECT id, name, email, message, created_at, is_read FROM feedback ORDER BY created_at DESC";
    $stmt = $pdo->query($sql);
    $feedbacks = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Failed to retrieve feedback: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $feedbackId = (int)$_POST['feedback_id'];
        $deleteFeedback->delete($feedbackId);
        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['toggle_read'])) {
        $feedbackId = (int)$_POST['feedback_id'];
        $readUnread->toggleRead($feedbackId);
        header("Location: admin.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Messages</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="logout-container">
    <form method="post" action="admin.php">
        <input type="hidden" name="action" value="logout">
        <button type="submit">Logout</button>
    </form>
</div>
<h2>Client's Feedback</h2>



<?php if (count($feedbacks) > 0): ?>
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($feedbacks as $feedback): ?>
            <tr>
                <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                <td><?php echo htmlspecialchars($feedback['message']); ?></td>
                <td><?php echo htmlspecialchars($feedback['created_at']); ?></td>
                <td>
                    <form method="post" action="admin.php" style="display:inline;">
                        <input type="hidden" name="feedback_id" value="<?php echo $feedback['id']; ?>">
                        <button type="submit" name="toggle_read"
                                class="toggle-button <?php echo $feedback['is_read'] ? 'done' : 'mark-as-unread'; ?>">
                            <?php echo $feedback['is_read'] ? 'Readed' : 'Unread'; ?>
                        </button>
                    </form>
                </td>
                <td>
                    <form method="post" action="admin.php" style="display:inline;">
                        <input type="hidden" name="feedback_id" value="<?php echo $feedback['id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No feedback yet!</p>
<?php endif; ?>
</body>
</html>

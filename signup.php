<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Sign up successful. Please log in.'); window.location.href='sample.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='signup.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
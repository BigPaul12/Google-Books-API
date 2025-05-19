<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "google_api";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$reviewText = $_POST['reviewText'];
$bookIsbn = $_POST['bookIsbn'];

$stmt = $conn->prepare("INSERT INTO BookReviews (review, isbn) VALUES (?, ?)");
$stmt->bind_param("ss", $reviewText, $bookIsbn);


if ($stmt->execute()) {
  echo "Review submitted successfully!";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
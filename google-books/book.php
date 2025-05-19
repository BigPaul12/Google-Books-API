x

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8" />
  <title>Google Books Embedded Viewer</title>
  <link rel="stylesheet" type="text/css" href="mystyles.css" />
  <script type="text/javascript" src="https://www.google.com/books/jsapi.js"></script>
  <script type="text/javascript">
    google.books.load();

    function initialize() {
      const viewerDiv = document.getElementById('viewerCanvas');
      if (!viewerDiv) {
        console.error("viewerCanvas div not found.");
        return;
      }

      const params = new URLSearchParams(window.location.search);
      const bookIsbn = params.get('isbn');

      if (bookIsbn) {
        const viewer = new google.books.DefaultViewer(viewerDiv);
        viewer.load('ISBN:' + bookIsbn);
      } else {
        console.error('ISBN parameter missing in URL');
        viewerDiv.innerHTML = "<p style='color: red;'>ISBN not found in URL.</p>";
      }
    }

    google.books.setOnLoadCallback(initialize);
  </script>
  <style>
    /* Just in case: enforce viewerCanvas size */
    #viewerCanvas {
      width: 100%;
      height: 100%;
      min-height: 600px;
      border-radius: 8px;
      background-color: white;
    }
  </style>
</head>
<body class="book-page">
  <?php $bookIsbn = isset($_GET['isbn']) ? $_GET['isbn'] : ''; ?>

  <div class="book-container">
    <div class="top-section">
      <div class="viewer-container">
        <div id="viewerCanvas"></div>
      </div>

      <div class="book-review">
        <form id="reviewForm" action="submit_review.php" method="post">
          <input type="hidden" id="bookIsbn" name="bookIsbn" value="<?php echo htmlspecialchars($bookIsbn); ?>" />
          <label for="reviewText">Review:</label><br />
          <textarea id="reviewText" name="reviewText" rows="6" placeholder="Write your review here"></textarea><br /><br />
          <button type="submit">Submit Review</button>
        </form>
      </div>
    </div>

    <div id="reviewsSection">
      <h3>Reviews for this book:</h3>
      <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "google_api";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        if (!empty($bookIsbn)) {
          $stmt = $conn->prepare("SELECT review FROM BookReviews WHERE isbn = ?");
          $stmt->bind_param("s", $bookIsbn);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<div class='review'>";
              echo "<p><strong>Review:</strong> " . nl2br(htmlspecialchars($row['review'])) . "</p>";
              echo "</div><hr />";
            }
          } else {
            echo "<p>No reviews yet for this book.</p>";
          }
          $stmt->close();
        }

        $conn->close();
      ?>
    </div>
  </div>
</body>
</html>

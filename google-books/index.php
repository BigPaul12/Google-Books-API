<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book Repository</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="mystyles.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/app.js"></script>
</head>
<body>
    <div class="container">
        <h1 id="title" class="text-center mt-5">Book Finder</h1> 
        <div class="row">
            <div id="input" class="input-group mx-auto col-lg-6 col-md-8 col-sm-12">
                <input id="search-box" type="text" class="form-control" placeholder="Search Books...">
                <button id="search" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
    <div class="book-list">
        <div id="list-output">
            <div class="row"></div>
        </div>
    </div>
</body>
</html>

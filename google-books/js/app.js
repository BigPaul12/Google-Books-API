$(document).ready(function() {
    var item, title, author, publisher, bookLink, bookImg;
    var outputlist = document.getElementById("list-output");
    var bookUrl = "https://www.googleapis.com/books/v1/volumes?q=";
    var placeHldr = "https://ralfvanveen.com/wp-content/uploads/2021/06/Placeholder-_-Glossary.svg";
    var searchData;

    $("#search").click(function() {
        outputlist.innerHTML = "";
        searchData = $("#search-box").val();
        if(searchData == "" || searchData == null) {
            displayError();
        }
        else{
            $.ajax({
                url: bookUrl + searchData,
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    if(res.totalItems === 0) {
                        alert("no results!... try again");
                    }
                    else{
                        // Removed invalid jQuery animation call
                        $(".book-list").css("visibility", "visible");
                        displayResults(res);
                    }
                },
                error: function() {
                    alert("Something went wrong!");
                }
            });
        }
        $("#search-box").val("");
    });

    function displayResults(res) {
        for(var i = 0; i < res.items.length; i += 2){
            item = res.items[i];
            var title1 = item.volumeInfo.title || "No title available";
            var author1 = (item.volumeInfo.authors) ? item.volumeInfo.authors.join(", ") : "No author available";
            var publisher1 = item.volumeInfo.publisher || "No publisher available";
            var bookLink1 = item.volumeInfo.previewLink || "#";
            var bookIsbn1 = (item.volumeInfo.industryIdentifiers && item.volumeInfo.industryIdentifiers.length > 1) ? item.volumeInfo.industryIdentifiers[1].identifier : "N/A";
            var bookImg1 = (item.volumeInfo.imageLinks) ? item.volumeInfo.imageLinks.thumbnail : placeHldr;

            var htmlOutput = formatOutput(bookImg1, title1, author1, publisher1, bookLink1, bookIsbn1);

            if(i + 1 < res.items.length){
                var item2 = res.items[i + 1];
                var title2 = item2.volumeInfo.title || "No title available";
                var author2 = (item2.volumeInfo.authors) ? item2.volumeInfo.authors.join(", ") : "No author available";
                var publisher2 = item2.volumeInfo.publisher || "No publisher available";
                var bookLink2 = item2.volumeInfo.previewLink || "#";
                var bookIsbn2 = (item2.volumeInfo.industryIdentifiers && item2.volumeInfo.industryIdentifiers.length > 1) ? item2.volumeInfo.industryIdentifiers[1].identifier : "N/A";
                var bookImg2 = (item2.volumeInfo.imageLinks) ? item2.volumeInfo.imageLinks.thumbnail : placeHldr;

                htmlOutput += formatOutput(bookImg2, title2, author2, publisher2, bookLink2, bookIsbn2);
            }

            outputlist.innerHTML += '<div class="row mt-4">' + htmlOutput + '</div>';
        }
    }

    function formatOutput(bookImg, title, author, publisher, bookLink, bookIsbn) {
        var viewerUrl = 'book.php?isbn='+bookIsbn;
        var htmlCard = `<div class="col-lg-6">
                            <div class="row-no-gutters">
                                <div class="col-md-4">
                                    <img src="${bookImg}" class="card-img" alt="Book cover"></img>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">${title}</h5>
                                        <p class="card-text">Author: ${author}</p>
                                        <p class="card-text">Publisher: ${publisher}</p>
                                        <a target="_blank" href="${viewerUrl}" class="btn btn-secondary">Read Here</a>
                                    </div>
                                </div>
                            </div>
                        </div>`;

        return htmlCard;
    }

    function displayError() {
        alert("search term cannot be empty");
    }
});

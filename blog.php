<html>
    <head>

    <link rel="stylesheet"type="text/css"href="style.css">
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">
        <div class="container-fluid">


            <div id="cards">
    
                </div>
                <form method="post" action="add_comment.php">
                    <div class="mb-3">
                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter Ticker">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"placeholder="Enter Content"></textarea>
                    </div>
                    <button type="submit">Submit</button>
                </form>

        <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
        </div>
        </div>
        </div><!--ending div for container-->

    </body>
</html>
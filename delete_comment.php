<html>
    <head>
            <?php include 'include.htm';?>
    </head>
    <body class="bg-dark"> 
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php
                    //Get Heroku ClearDB connection information
                    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
                    $cleardb_server = $cleardb_url["host"];
                    $cleardb_username = $cleardb_url["user"];
                    $cleardb_password = $cleardb_url["pass"];
                    $cleardb_db = substr($cleardb_url["path"],1);
                    $active_group = 'default';
                    $query_builder = TRUE;
                    // Connect to DB
                    $DBConnect = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

                    //tell me if it doesn't connect
                    if($DBConnect == false){
                    print 'Unable to connect to the database'.mysqli_errno();
                    }
                    else{
                    //table variable
                    $TableName = 'blog';

                    //select everything from the table
                    $SQLString = "select * from $TableName";
                    $result = mysqli_query($DBConnect,$SQLString);

                    if(mysqli_num_rows($result)>0){
                    while($Row = mysqli_fetch_assoc($result)){
                    print " <div class='card'>
                    <div class='card-header'>{$Row['ticker']} ID: {$Row['blog_id']}</div>
                    <div class='card-body'>
                    <blockquote class='blockquote mb-0'>
                    <p>{$Row['content']}</p>
                    <footer class='blockquote-footer'>Price: {$Row['current_price']} YTD: {$Row['ytdchange']}</footer>
                    </blockquote>
                    </div>
                    </div><br>";
                    }
                    }
                    else
                    print"Nothing to display. Sorry.";
                    mysqli_free_result($result);
                    }
                    mysqli_close($DBConnect);

                    ?>
                </div>
            </div><!--ending div for row 1-->
            <div class="row">
                <div class="col-12">
                    <form method="POST" action = "delete_c.php">
                    <div class="mb-3">
                        <input class="form-control" placeholder="Select an Id from above to delete"type = "text" name = "blog_id" />
                    </div>
                        <button class="btn btn-primary mb-3"type="submit" value="Submit">Submit</button>
                    </form>
                </div>
            </div><!--ending div for row 2-->
    </div>
    </body>
</html>
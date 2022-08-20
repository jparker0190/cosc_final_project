<html>
    <head>
        <?php include 'include.htm';?>
    </head>
    <body class="bg-dark">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                <span class="badge text-bg-secondary">Please enter some thoughts your might have on investments.</span>
                <form method="post" action="add_comment.php">
                    <div class="mb-3">
                        <input type ="text" class="form-control" name="ticker" placeholder="Enter Ticker">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" type="text" name="blogs" placeholder="Enter any research or thoughts you have about a stock..."></textarea>
                    </div>
                    <button class="btn btn-primary mb-3"type="submit">Submit</button>
                </form>
                </div>
            </div><!--ending div for row 1-->
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

                   
                    if($DBConnect == false){
                        print "Sorry no DB conneciton Joe.";
                    }
                    else{
                        $Table = 'blog';

                        $SQLSelect = "select * from $Table";

                        $Query = mysqli_query($DBConnect,$SQLSelect);

                        if(mysqli_num_rows($Query)>0){
                            
                            while ($Row = mysqli_fetch_assoc($Query)){
                                print " <div class='card'>
                                <div class='card-header'>{$Row['ticker']}</div>
                                <div class='card-body'>
                                <blockquote class='blockquote mb-0'>
                                <p>{$Row['content']}</p>
                                <footer class='blockquote-footer'>Price: {$Row['current_price']} YTD: {$Row['ytdchange']}</footer>
                                </blockquote>
                                </div>
                                </div><br>";
                                }
                        }
                        else{
                            print"There is nothing to display.";
                        }
                        mysqli_free_result($Query);
                    }
                    mysqli_close($DBConnect);
                    ?>
                </div>
            </div><!--ending div for row2 -->
        </div><!--ending div for container-->

    </body>
</html>
<html>
    <head>
    <link rel="stylesheet"type="text/css"href="style.css">
        <?php include 'include.htm';?>
    </head>
    <body>
        <div class="container">
            <div id="cards-title">
                Please enter your comments on your stock below.
            </div>
            <div id="cards">
                <form method="post" action="add_comment.php">
                    <input type ="text" name="ticker" placeholder="Enter Ticker">
                    <input type="text" name="blogs" placeholder="Enter Content">
                    <button type="submit">Submit</button>
                </form>
            </div>
                
           
                <div id="cards">
                <table>
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
                                print"<p> Ticker: {$Row['ticker']} - Price: {$Row['current_price']} - YTDChange: {$Row['ytdchange']}</p><p>{$Row['content']}</p>";
                                }
                        }
                        else{
                            print"There is nothing to display.";
                        }
                        mysqli_free_result($Query);
                    }
                    mysqli_close($DBConnect);
                    ?>
                </table>
            </div>
        </div><!--ending div for container-->

    </body>
</html>
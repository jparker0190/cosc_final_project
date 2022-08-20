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
                    <input type ="text" name="ticker" placeholder="Enter Ticker">
                    <input type="text" name="blogs" placeholder="Enter Content">
                    
                    <button type="submit">Submit</button>
                </form>

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

                    $iex_key = 'pk_c29c4bbe9d3043a2bb912e07eb4cbf94';

                    $iex_api = "https://sandbox.iexapis.com/stable/stock/FB/quote?token=$iex_key";
                    $json = file_get_contents($iex_api);
                    $iex_result = json_decode($json.ytdchange);
                    print $iex_result;

                    if($DBConnect == false){
                        print "Sorry no DB conneciton Joe.";
                    }
                    else{
                        $Table = 'blog';

                        $SQLSelect = "select * from $Table";

                        $Query = mysqli_query($DBConnect,$SQLSelect);

                        if(mysqli_num_rows($Query)>0){
                            print"<tr><th>Trade_Date</th><th>Ticker</th><th>Qty</th><th>Price_Bought</th><th>Trade_Cost</th></tr>";

                            while ($Row = mysqli_fetch_assoc($Query)){
                                print"<tr class='text-white'style='height:10px;'><td>{$Row['ticker']}</td><td>{$Row['content']}</td><td>{$Row['current_price']}</td><td>{$Row['ytdchange']}</td></tr>";
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
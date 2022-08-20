<html>
    <head>
        <link rel="stylesheet"type="text/css"href="style.css">
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    </head>
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

        //let me know if there isn't a db connection
        if($DBConnect == false){
            print "No Connection Made.";
        }
        else{
            //variable for tablename
            $Table = 'blog';

            //variables to hold data from the form
            $ticker = stripslashes($_POST['ticker']);
            $content = stripslashes($_POST['content']);
            $current_price = stripslashes($_POST['current_price']);
            $ytdchange = stripslashes($_POST['ytdchange']);

            $SQLInsert = "insert into $Table(ticker, content, current_price, ytdchange) values ('$ticker',$content,$current_price,$ytdchange)";

            //tell me if the above query string doesn't work
            if(mysqli_query($DBConnect,$SQLInsert)){
                print"Added to DB";
            }
            else{
                print "Something is wrong.";
            }
            mysqli_close($DBConnect);

        }
    ?>
</html>
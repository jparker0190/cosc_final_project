<html>
    <head>
        <link rel="stylesheet"type="text/css"href="style.css">
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    </head>
    <body> 
    
        <h1>Which blog post do you want to delete?</h1>
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
                        print"<h4> Ticker: {$Row['ticker']} - Price: {$Row['current_price']} - YTDChange: {$Row['ytdchange']} ID: {$Row['blog_id']}</h4><p>{$Row['content']}</p>";
                    }
            }
            else
                print"Nothing to display. Sorry.";
            mysqli_free_result($result);
        }
        mysqli_close($DBConnect);
        
        ?>
    <form method="POST" action = "delete.php">
     <input placeholder="Select an Id from below to delete"type = "text" name = "ID" />
    <p><input type="submit" value="Submit" /></p>
    </form>
    </body>
</html>
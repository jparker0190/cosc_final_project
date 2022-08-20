<html>
    <head>
            <?php include 'include.htm';?>
    </head>
    <body>
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

        //tell me if something is wrong
        if($DBConnect == false){
            print 'Unable to connect to the database'.mysqli_errno();
        }
        else{
            //table variable
            $TableName = 'blog';

            $DeleteThis = stripslashes($_POST['blog_id']);
            $SQLString = "delete from $TableName where blog_id = '$DeleteThis'";
            $result = mysqli_query ($DBConnect, $SQLString);
            if(mysqli_affected_rows($DBConnect) == 0){
                print"The data {$DeleteThis} doesn't exist. So nothing was deleted.<br>";
            }
           
            $SQLString = "select * from $TableName";
            $result = mysqli_query($DBConnect,$SQLString);
            
            if(mysqli_num_rows($result)>0){
                print"Here is everything in stocks with ID $DeleteThis deleted.";
                while($Row = mysqli_fetch_assoc($result)){
                    print"<h4> Ticker: {$Row['ticker']} - Price: {$Row['current_price']} - YTDChange: {$Row['ytdchange']} ID: {$Row['blog_id']}</h4><p>{$Row['content']}</p>";
                }
            }
            else
                print"there are no results to display";
            mysqli_free_result($result);
        }//close the else for connection
        mysqli_close($DBConnect);

        
    ?>
    </body>
</html>
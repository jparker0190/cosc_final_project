<html>
    <head>
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    </head>
    <body class="bg-dark text-white">
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
            $TableName = 'stocks';

            $DeleteThis = stripslashes($_POST['ID']);
            $SQLString = "delete from $TableName where id = '$DeleteThis'";
            $result = mysqli_query ($DBConnect, $SQLString);
            if(mysqli_affected_rows($DBConnect) == 0){
                print"The data {$DeleteThis} doesn't exist. So nothing was deleted.<br>";
            }
           
            $SQLString = "select * from $TableName";
            $result = mysqli_query($DBConnect,$SQLString);
            
            if(mysqli_num_rows($result)>0){
                print"Here is everything in stocks with ID $DeleteThis deleted.";
                print"<table class='table table-hover table-dark table-bordered'>";
                print"<tr><th>Id</th><th>Trade_Date</th><th>Ticker</th><th>Qty</th>
                <th>Price_Bought</th><th>Trade_Cost</th></tr>";
                while($Row = mysqli_fetch_assoc($result)){
                    print"<tr><td>{$Row['ID']}</td><td>{$Row['trade_date']}</td><td>{$Row['ticker']}</td>
                    <td>{$Row['quantity']}</td><td>{$Row['current_price']}</td><td>{$Row['cost']}</td></tr>";
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
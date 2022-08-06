<html>
    <head>
        <link rel="stylesheet"type="text/css"href="style.css">
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
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

        //tell me if it doesn't connect
        if($DBConnect == false){
            print 'Unable to connect to the database'.mysqli_errno();
        }
        else{
            //table variable
            $TableName = 'stocks';

            //select queries
            $SQLString = "select * from $TableName order by ticker";
            $most_expensive = "select max(cost) as max_cost from $TableName";
            $result = mysqli_query($DBConnect,$SQLString);
            $result_of_max = mysqli_query($DBConnect,$most_expensive);
            $final_result = mysqli_fetch_array($result_of_max);
            print "The most money spent on a trade was: "; echo $final_result['max_cost'];
        
            if(mysqli_num_rows($result)>0){
                    print "<h4>Here are the trades ordered by Ticker</h4>";
                    print"<table>";
                    print"<tr><th>Id</th><th>Trade_Date</th><th>Ticker</th><th>Qty</th>
                    <th>Price_Bought</th><th>Trade_Cost</th></tr>";
                    while($Row = mysqli_fetch_assoc($result)){
                        print"<tr><td>{$Row['id']}</td><td>{$Row['trade_date']}</td><td>{$Row['ticker']}</td>
                        <td>{$Row['quantity']}</td><td>{$Row['current_price']}</td><td>{$Row['cost']}</td></tr>";
                    }
            }
            else
                print"Nothing to display. Sorry.";
            
            mysqli_free_result($result);
        }
        mysqli_close($DBConnect);
        
        ?>
   </body>
</html>
<html>
    <head>
        <link rel="stylesheet"type="text/css"href="style.css">
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    </head>
    <body> 
    
        <h1>Pick a Trade below by it's ID to delete it from the table</h1>
        <?php
        //connect to db
        $DBConnect = mysqli_connect('127.0.0.1','root','mysql','oppy');

        //tell me if it doesn't connect
        if($DBConnect == false){
            print 'Unable to connect to the database'.mysqli_errno();
        }
        else{
            //table variable
            $TableName = 'stocks';

            //select everything from the table
            $SQLString = "select * from $TableName";
            $result = mysqli_query($DBConnect,$SQLString);
            
            if(mysqli_num_rows($result)>0){
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
    <form method="POST" action = "delete.php">
     <input placeholder="Select an Id from below to delete"type = "text" name = "id" />
    <p><input type="submit" value="Submit" /></p>
    </form>
    </body>
</html>
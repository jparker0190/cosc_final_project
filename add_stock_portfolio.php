<html>
    <head>
        <link rel="stylesheet"type="text/css"href="style.css">
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    </head>
    <?php
        $DBConnect = mysqli_connect('127.0.0.1','root','mysql','oppy');

        //let me know if there isn't a db connection
        if($DBConnect == false){
            print "No Connection Made.";
        }
        else{
            //variable for tablename
            $Table = 'stocks';

            //variables to hold data from the form
            $ticker = stripslashes($_POST['ticker']);
            $quantity = stripslashes($_POST['quantity']);
            $current_price = stripslashes($_POST['current_price']);
            $cost = stripslashes($_POST['quantity']*$_POST['current_price']);

            $SQLInsert = "insert into $Table(ticker, quantity, current_price, cost) values ('$ticker',$quantity,$current_price,$cost)";

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
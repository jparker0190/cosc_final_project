<html>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react-dom.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.21.1/babel.min.js" charset="utf-8"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
            <?php include 'include.htm';?>
    </head>
    <body class="bg-dark">
        <div class="container-fluid">
             <div class="row">
                <div class="col-6">
                    <form method="post" action="add_stock_portfolio.php">
                    <div class="mb-3">
                    <input type ="text" class="form-control" name="ticker" placeholder="Enter Ticker">
                    </div>
                    <div class="mb-3">
                    <input type ="number" class="form-control" name="quantity" placeholder="Enter Quantity">
                    </div>
                    <div class="mb-3">
                    <input type ="number" class="form-control" name="current_price" placeholder="Enter Price"step=".01">
                    </div>
                    <button class="btn btn-primary mb-3"type="submit">Submit</button>
                    </form>
                </div><!--ending div for col-6-->
                <div class="col-6">
                    <table class="table table-hover table-sm table-dark table-bordered">
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
                        $Table = 'stocks';

                        $SQLSelect = "select * from $Table order by cost desc";

                        $Query = mysqli_query($DBConnect,$SQLSelect);

                        if(mysqli_num_rows($Query)>0){
                        print"<thead><tr><th>Trade_Date</th><th>Ticker</th><th>Qty</th><th>Price_Bought</th><th>Trade_Cost</th></tr></thead>";

                        while ($Row = mysqli_fetch_assoc($Query)){
                        print"<tr><td>{$Row['trade_date']}</td><td class='ticker'>{$Row['ticker']}</td><td>{$Row['quantity']}</td><td>{$Row['current_price']}</td><td>{$Row['cost']}</td></tr>";
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
                </div><!--ending div for col-6-->
             </div><!--ending div for row 1-->
             <div class="row">
             <div class="col-6">
                <table class="table table-hover table-sm table-dark table-bordered">
                <thead>
                <tr>
                <th>Expiration</th>
                <th>Underlying</th>
                <th>Strike Price</th>
                <th>Breakeven Price</th>
                </tr>
                </thead>
                <tbody class="opt_table">
                </tbody>
                </table>
             </div><!--ending div for col-6-->
             <div class="col-6">
                <table class="table table-hover table-sm table-dark table-bordered">
                <thead>
                <tr><th>Headline</th><th>URL</th><th>Ticker</th><th>Consensus</th></tr>
                </thead>
                <tbody class="news_table">

                </tbody>
                </table>
             </div><!--ending div for col-6-->
             </div><!--ending div for row 1-->
        </div>
        
    </body>
</html>
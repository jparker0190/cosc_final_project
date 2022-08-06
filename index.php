
<html>
    <head>
        <link rel="stylesheet"type="text/css"href="style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react-dom.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.21.1/babel.min.js" charset="utf-8"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="scripts.js"></script>
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    </head>
    <body>
        <div class="container">
            <div id="cards-title">
                Please enter your stock positions
            </div>
            <div id="cards">
                <form method="post" action="add_stock_portfolio.php">
                <input type ="text" name="ticker" placeholder="Enter Ticker">
                <input type ="number" name="quantity" placeholder="Enter Quantity">
                <input type ="number" name="current_price" placeholder="Enter Price"step=".01">
                <button type="submit">Submit</button>
                </form>
            </div>
            <br>
            <div id="cards-title">
                Stock Portfolio
            </div>
            <div id="cards">
                <table>
                    <?php
                    $DBConnect = mysqli_connect('127.0.0.1','root','mysql','oppy');

                    if($DBConnect == false){
                        print "Sorry no DB conneciton Joe.";
                    }
                    else{
                        $Table = 'stocks';

                        $SQLSelect = "select * from $Table order by cost desc";

                        $Query = mysqli_query($DBConnect,$SQLSelect);

                        if(mysqli_num_rows($Query)>0){
                            print"<tr><th>Trade_Date</th><th>Ticker</th><th>Qty</th><th>Price_Bought</th><th>Trade_Cost</th></tr>";

                            while ($Row = mysqli_fetch_assoc($Query)){
                                print"<tr style='height:10px;'><td>{$Row['trade_date']}</td><td class='ticker'>{$Row['ticker']}</td><td>{$Row['quantity']}</td><td>{$Row['current_price']}</td><td>{$Row['cost']}</td></tr>";
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
            <br>
            <div id="cards-title">
                Option Table
            </div>
            <div id="cards">
                <table >
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
            </div>
            <br>
            <div id="cards-title">
                Relevant News
            </div>
            <div id="cards">
                <table>
                    <thead>
                        <tr><th>Headline</th><th>URL</th><th>Ticker</th><th>Consensus</th></tr>
                    </thead>
                    <tbody class="news_table">

                    </tbody>
                </table>
            </div>
        </div>
        
    </body>
</html>
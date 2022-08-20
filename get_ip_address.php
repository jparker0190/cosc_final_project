<html>
    <head>
        <link rel="stylesheet"type="text/css"href="style.css">
        <div id="nav">
            <?php include 'include.htm';?>
        </div>
    </head>
    <body>
        <h1>Displaying User INFO</h1>
    <?php

        //first get the ip address 

        function getAddress(){
            if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                 $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                 $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
            }
            else{
                 $ip = $_SERVER['REMOTE_ADDR'];  
            }
            return $ip;
         }
 
         $ip = getAddress();
         //use an if statement because to hardcode my ip because i am running locally and port forwarding wont work
         if($ip == '::1'){
             $ip = "207.237.121.152";
         }
         else{
             $ip = getAddress();
         }
         
         //api endpoint with my ip address added as variable
         $api = "http://ip-api.com/json/{$ip}";

         //make get request
         $json = file_get_contents($api);

         //decode the api response from ip-api
         $result = json_decode($json);
         
         //connect to db
        $DBConnect = mysqli_connect('127.0.0.1','root','mysql','api');

        //let me know if there isn't a db connection
        if($DBConnect == false){
            print "No Connection Made.";
        }
        else{
            //variable for tablename
            $Table = 'api_data';

            //store the results of the json_decode into php variables
            $query = $result->{'query'};
            $status = $result->{'status'};
            $country = $result->{'country'};
            $countryCode = $result->{'countryCode'};
            $region = $result->{'region'};
            $regionName = $result->{'regionName'};
            $city = $result->{'city'};
            $zip = $result->{'zip'};
            $lat = $result->{'lat'};
            $lon = $result->{'lon'};
            $timezone = $result->{'timezone'};
            $isp = $result->{'isp'};
            $org = $result->{'org'};
            $as = $result->{'as'};

            //php variable for inserting the responses into mysql table
            $SQLInsert = "insert into $Table(queries, statuses, country, countryCode, region, regionName, city,
            zip, lat, lon, timezone, isp, org, ases) values ('$query', '$status', '$country', '$countryCode', '$region', '$regionName', '$city',
            '$zip', '$lat', '$lon', '$timezone', '$isp', '$org', '$as')";

            //tell me if the above query string doesn't work, if it does display information
            if(mysqli_query($DBConnect,$SQLInsert)){
                echo "Your Information has been saved to the DB.<br><br>";
                echo "Your IP Address is: ",$result->{'query'},"<br>";
                echo "Your are located at  ",$result->{'city'}," ",$result->{'region'}," ",
                $result->{'zip'}," ",$result->{'country'}, " <br>at coordinates: ",$result->{'lon'}," ",$result->{'lat'},"<br>";
                echo "You get internet from: ",$result->{'org'};
            }
            else{
                print "Something is wrong.".mysqli_error($DBConnect);
            }
            mysqli_close($DBConnect);
            
        }
    ?>
    </body>
</html>
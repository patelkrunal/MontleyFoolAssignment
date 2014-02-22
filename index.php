<?php
$city= "London";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $city=$_POST["city"];
}
// to avoid bad request
$city=str_replace(' ', '', $city);
$jsonurl = "http://api.worldweatheronline.com/free/v1/weather.ashx?q=". $city ."&format=json&num_of_days=5&key=hspebfu7cgmtvppuss6jjsqu";
//echo $jsonurl;
$json = file_get_contents($jsonurl);
$json_op = json_decode($json,true);
//var_dump($json_op);
//validation of city check json

 
?>
<!DOCTYPE html>

<html>
<head>
    <title>MontleyFoolAssignment</title>
    <link rel="stylesheet" type="text/css" href="grid.css">
    <style type="text/css">
        #temperature
        {
            font-size: 100px;
            text-align: center;
            margin: 150px 0px 0px 0px;
        }
    </style>
</head>
<body id="body_id">
    <form name="input" action="index.php" method="post">
    City: <input type="text" name="city">
    <input type="submit" value="Submit">
   </form>
    <?php 
    if (isset($json_op["data"]["error"]))
    {
        echo "Invalid City";
        exit;
    }
    else
    {
        $temperature=$json_op["data"]["current_condition"][0]["temp_C"];
        if($temperature>=7)//randomly taken.
            $image_name="sunny";
        if($temperature<7)
            $image_name="cold";
    ?>
    <script type="text/javascript">
document.getElementById("body_id").style.backgroundImage="url('<?php echo $image_name.".jpg"; ?>')";
</script>
    <?php
    }
    ?>
    <div class="container_12">
        <div class="grid_12">
            <div class="grid_4 push_4">
                <p id="temperature"><?php echo $json_op["data"]["current_condition"][0]["temp_C"]."�C"; ?></p>
            </div>
            
        </div>
        <div class="grid_12">
            <div class="grid_4 push_4">
                <label><?php echo "Location = ". $json_op["data"]["request"][0]["query"]; ?></label><br>
                <label><?php echo "Weather = ". $json_op["data"]["current_condition"][0]["weatherDesc"][0]["value"]; ?></label><br>
                <label><?php echo "WindSpeed = ". $json_op["data"]["current_condition"][0]["windspeedMiles"]." MPH"; ?></label>
            </div>
        </div>
    </div>
</body>
</html>

<?php
require_once "vendor/autoload.php";
ini_set('memory_limit', '-1');
$weather = new Weather(__API_KEY);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cityId'])) {
    $cityId = $_POST['cityId'];
    $weatherReport = $weather->get_weather($cityId);
    if ($weatherReport) {
        echo "<h1>" . $weatherReport['name'] . "</h1><br>";
        echo $weather->get_current_time() . "<br>";
        echo $weatherReport['weather'][0]['description'] . "<br>";
        echo "Minimum Temperature: " . $weatherReport['main']['temp_min'] . "°C<br>";
        echo "Maximum Temperature: " . $weatherReport['main']['temp_max'] . "°C<br>";
        echo "Humidity: " . $weatherReport['main']['humidity'] . "%<br>";
        echo "Wind: " . $weatherReport['wind']['speed'] . "km/h<br>";
        echo "<h4><b>Weather Forecast</h4></b>";
    } else {
        echo "Weather report not available for the selected city.";
    }
}
// to display form and dropdown list
echo "<form method='post' action='index.php'>";
echo "<select name='cityId'>";
$cities = $weather->get_cities();

//to loop on all cities with a condition if they were in Egypt
foreach ($cities as $city) {
    if ($city["country"] == "EG") {
?>
        <option value="<?php echo $city["id"] ?>"><?php echo $city["name"] ?></option>
<?php }
}
echo "</select>";
echo "<input type='submit' value='Get Weather'>";
echo "</form>";

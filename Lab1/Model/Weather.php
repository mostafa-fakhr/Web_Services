<?php

class Weather implements Weather_Interface
{

    private $apiKey;
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function get_cities()
    {
        //this line is to get cities file content
        $citiesData = file_get_contents(__CITIES_FILE);

        //to convert json file to array
        $cities = json_decode($citiesData, true);

        return $cities;
    }

    //curl function
    public function get_weather($cityId)
    {
        $url = sprintf(__WEATHER_URL, $cityId, $this->apiKey);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    public function get_current_time()
    {
        // Get the current time
        $current_time = time();

        $formatted_date = date("l h:i A", $current_time);
        $formatted_time = date("jS M, Y", $current_time);

        $formatted_datetime = $formatted_date . "<br>" . $formatted_time;

        // return the date and time in different lines 
        return $formatted_datetime;
    }
}

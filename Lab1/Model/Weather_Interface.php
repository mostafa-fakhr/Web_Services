<?php
interface Weather_Interface
{
    public function get_cities();
    public function get_weather($cityId);
    public function get_current_time();
}

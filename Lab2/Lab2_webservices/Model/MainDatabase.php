<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once "./DbHandler.php";

class MainDatabase implements DbHandler
{
    private $_capsule;

    public function __construct()
    {
        $this->_capsule = new Capsule();
    }

    //to connect to database
    public function connect()
    {
        try {
            $this->_capsule->addConnection([
                'driver'    => __DRIVER_DB__,
                'host'      => __HOST_DB__,
                'database'  => __NAME_DB__,
                'username'  => __USERNAME_DB__,
                'password'  => __PASS_DB__,
            ]);
            // Make this Capsule instance available globally via static methods... (optional)
            $this->_capsule->setAsGlobal();

            // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
            $this->_capsule->bootEloquent();

            return true;
        } catch (\Exception $ex) {
            die("Error Message:" . $ex->getMessage());
        }
    }


    //to get the data from the database
    public function get_data($fields = array(),  $start = 0)
    {
        $items = Items::skip($start)->take(5)->get($fields);
        if (empty($fields)) {
            foreach ($items as $item) {
                echo $item->id . "<br>";
            }
        } else {
            return $items;
        }
    }

    //when disconnecting from database
    public function disconnect()
    {
        try {
            Capsule::disconnect();
            return true;
        } catch (\Exception $ex) {
            die("Error Message:" . $ex->getMessage());
        }
    }

    //to get a specific record with a value of id and primary key name is id
    public function get_record_by_id($id, $primary_key)
    {
        $item = Items::where($primary_key, "=", $id)->get();

        //condition to check if the array is not empty
        if (!empty($item)) {
            return $item[0];
        }
    }
    public function search_by_column($column_name, $value)
    {
        // the percentage sign is used in order to check for the pattern like in DB
        $item = Items::where($column_name, "like", "%$value%")->get();

        //condition to check if the array is not empty
        if (count($item) > 0) {
            return $item;
        }
    }
}













// use Illuminate\Database\Capsule\Manager as Capsule;

// $capsule = new Capsule;
// try {
//     $capsule->addConnection([
//         'driver' => 'mysql',
//         '__HOST__' => 'localhost',
//         '__DB__' => 'database',
//         '__USER__' => 'root',
//         '__PASS__' => 'password',
//     ]);


//     // Make this Capsule instance available globally via static methods... (optional)
//     $capsule->setAsGlobal();

//     // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
//     $capsule->bootEloquent();
// } catch (\Exception $ex) {
//     die("Error :" . $ex->getMessage());
// }

// $items = $capsule->table("items")->select()->take(__RECORDS_PER_PAGE__)->get();
// require_once "glasses_table.php";
// var_dump($items);

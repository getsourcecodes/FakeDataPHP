<?php
require_once('src/autoload.php');
try{
    $count = 100000;
    $faker = Faker\Factory::create('en_IN');;
    //Connecting MySQL Database
    $pdo  = new PDO('mysql:host=localhost;dbname=fake_data', 'root', '', array(
        PDO::ATTR_PERSISTENT => true
    ));
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    //Drop the table 
    $stmt = $pdo->prepare("truncate table users");
    $stmt->execute();
    //Insert the data
    $sql = 'INSERT INTO users (first_name, last_name, email, created) 
    VALUES (:first_name, :last_name, :email, :created)';
    $stmt = $pdo->prepare($sql);
    for ($i=0; $i < $count; $i++) {
        $date = $faker->dateTime($max = 'now', 'UTC')->format('Y-m-d H:i:s');
        $stmt->execute(
            [
                ':first_name' => $faker->firstName, 
                ':last_name' => $faker->lastName,    
                ':email' => $faker->email, 
                ':created' => $date
            ]
        );
    }
} catch(Exception $e){
    echo '<pre>';print_r($e);echo '</pre>';exit;
}
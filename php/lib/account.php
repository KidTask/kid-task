<?php

require_once dirname(__DIR__, 1) . "/vendor/autoload.php";
require_once(dirname(__DIR__) . "/Classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require("uuid.php");
$secrets = new \Secrets("/etc/apache2/capstone-mysql/kidtask.ini");
$pdo = $secrets->getPdoObject();

use Club\KidTask\{Adult, Kid, Task, Step};

$password = "password";
$hashAdult = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 30]);

$password2 = "1234";
$hashKid = password_hash($password2, PASSWORD_ARGON2I, ["time_cost" => 30]);

//create parents
$adult1 = new Adult(generateUuidV4(), null, null, null, "towngabe@gmail.com", $hashAdult, "Gabriel", "dad2");
$adult1->insert($pdo);

$adult2 = new Adult(generateUuidV4(), null, null, null, "fullstack@calyx.studio", $hashAdult, "Demetria", "mom");
$adult2->insert($pdo);

$adult3 = new Adult(generateUuidV4(), null, null, null, "jlott1999@gmail.com", $hashAdult, "Jacob", "future_uncle");
$adult3->insert($pdo);

//create kids
$kid1 = new Kid(generateUuidV4(), $adult1->getAdultId(), null, null, $hashKid, "Khalai", "khalai");
$kid1->insert($pdo);

$kid2 = new Kid(generateUuidV4(), $adult1->getAdultId(), null, null, $hashKid, null, "boy");
$kid2->insert($pdo);

$kid3 = new Kid(generateUuidV4(), $adult2->getAdultId(), null, null, $hashKid, null, "dahlia");
$kid3->insert($pdo);

$kid4 = new Kid(generateUuidV4(), $adult3->getAdultId(), null, null, $hashKid, null, "nephew");
$kid4->insert($pdo);

//create tasks
$task1 = new Task(generateUuidV4(), $adult1->getAdultId(), $kid1->getKidId(), null, null, "Don't touch your poop", null, 0, "Episode of Elmo");
$task1->insert($pdo);

$task2 = new Task(generateUuidV4(), $adult1->getAdultId(), $kid1->getKidId(), null, null, "Don't pee on Mommy", null, 0, "Basketball hoop");
$task2->insert($pdo);

$task3 = new Task(generateUuidV4(), $adult2->getAdultId(), $kid3->getKidId(), null, null, "Do homework", null, 0, "30 minutes of screen time");
$task3->insert($pdo);

$task4 = new Task(generateUuidV4(), $adult2->getAdultId(), $kid3->getKidId(), null, null, "Clean room", null, 0, "Ice Cream");
$task4->insert($pdo);

//create steps
$step1 = new Step(generateUuidV4(), $task1->getTaskId(), "Don't try and poop when we take off your diaper.", 1);
$step1->insert($pdo);

$step2 = new Step(generateUuidV4(), $task1->getTaskId(), "Don't blow out of your diaper", 2);
$step2->insert($pdo);

$step3 = new Step(generateUuidV4(), $task1->getTaskId(), "Don't freak out and start kicking if we take longer than 15 seconds changing your diaper.", 3);
$step3->insert($pdo);

$step4 = new Step(generateUuidV4(), $task1->getTaskId(), "Don't grab at your butt/penis while we change your diaper", 4);
$step4->insert($pdo);

$step5 = new Step(generateUuidV4(), $task4->getTaskId(), "Make Bed", 1);
$step5->insert($pdo);

$step6 = new Step(generateUuidV4(), $task4->getTaskId(), "Pick up toys", 2);
$step6->insert($pdo);

$step7 = new Step(generateUuidV4(), $task4->getTaskId(), "Pick up clothes", 3);
$step7->insert($pdo);



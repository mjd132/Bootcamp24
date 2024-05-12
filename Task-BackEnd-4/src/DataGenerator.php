<?php
require_once '../vendor/autoload.php';
use Faker\Provider\fa_IR\Person;

$faker = Faker\Factory::create();

function GeneratePerson()
{
    global $faker;
    $person[':gender'] = '"' . $faker->randomElement(['male', 'female']) . '"';
    $person[':name'] = '"' . $faker->firstName($person[':gender']) . '"';
    $person[':family'] = '"' . $faker->lastName($person[':gender']) . '"';
    $person[':age'] = $faker->numberBetween(10, 80);
    $person[':mobile'] = '"' . $faker->phoneNumber() . '"';
    $person[':nationalCode'] = '"' . Person::nationalCode() . '"';
    $person[':about'] = '"' . $faker->sentence() . '"';
    $person[':isMarried'] = booleanToString($faker->boolean());
    return $person;

}
function booleanToString($bool)
{
    return $bool ? "1" : "0";
}

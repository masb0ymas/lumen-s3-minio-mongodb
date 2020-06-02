<?php

/** @var Factory $factory */

use App\Models\Action;
use App\Models\Faq;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Faq::class, function (Faker $faker) {
    return [
        'pertanyaan' => $faker->paragraph,
        'jawaban' => $faker->paragraph(5),
    ];
});

$factory->define(Action::class, function (Faker $faker) {
    return [
        'uraian' => $faker->text,
    ];
});

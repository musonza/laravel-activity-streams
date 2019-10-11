<?php

use Faker\Generator as Faker;
use Musonza\ActivityStreams\Models\Activity;
use Musonza\ActivityStreams\Tests\Helpers\Models\User;
use Musonza\ActivityStreams\Tests\Helpers\SampleObject;
use Musonza\ActivityStreams\Tests\Helpers\Targets\SampleTarget;
use Musonza\ActivityStreams\ValueObjects\Verbs;

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

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => 'vdvNDHDHHDXY798e9',
    ];
});

$factory->define(Activity::class, function (Faker $faker) {
    $actor = factory(User::class)->create();
    $activityObject = new SampleObject();
    $target = new SampleTarget();

    return [
        'verb' => Verbs::VERB_PURCHASE,
        'actor_type' => get_class($actor),
        'actor_id' => $actor->getKey(),
        'actor_data' => $actor->toArray(),
        'object_type' => $activityObject->getType(),
        'object_id' => $activityObject->getIdentifier(),
        'object_data' => $activityObject->getExtraData(),
        'target_type' => $target->getType(),
        'target_id' => $target->getIdentifier(),
        'target_data' => $target->getExtraData(),
    ];
});
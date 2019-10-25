# Laravel Activity Streams


## Table of Contents

<details><summary>Click to expand</summary><p>
  
- [Introduction](#introduction)
- [Installation](#installation)
- [Usage](#usage)
  - [Facade](#facade)
  - [Giving a model an ability to have a Feed](#Giving-a-model-an-ability-to-have-a-Feed)
  - [Create a model Feed](#create-a-model-feed)
  - [Create an Activity](#create-an-activity)
  - [Actors](#actors)
    - [Valid Actors](#valid-actors)
  - [Targets](#targets)
    - [Valid Targets](#valid-targets)
  - [Objects](#objects)
    - [Valid Objects](#valid-objects)
  - [Get supported verbs](#Get-supported-verbs)
  - [Add an activity to a Feed](#Add-an-activity-to-a-Feed)
  - [Add multiple activities to a Feed](#Add-multiple-activities-to-a-Feed)
- [Events](#events)
- [Configuration](#configuration)
- [FAQ](#faq)

</details>

## Introduction

This package enables you to have activity streams in your laravel applications.

## Installation

Install with composer

```sh
composer require musonza/laravel-activity-streams
```

Once the composer installation is finished, you can add alias for the facade. Open `config/app.php`, and make the following update:

1) Add a new item to the `aliases` array:

    ```php
    'ActivityStreams' => Musonza\ActivityStreams\ActivityStreamsFacade::class,
    ```

1) Publish the configuration file into your app's `config` directory, by running the following command:

    ```
    php artisan vendor:publish --tag="activity.streams.config"
    ```
    
1) Publish the migrations into your app's `migrations` directory, by running the following command:

    ```
    php artisan vendor:publish --tag="activity.streams.migrations"
    ```
    
1) Run the migrations:

    ```
    php artisan migrate
    ```
    
## Usage

#### Facade

Whenever you use the `ActivityStreams` facade in your code, remember to add the following line to your namespace imports:

```php
use ActivityStreams;
```

#### Giving a model an ability to have a Feed

Use the `HasFeed` trait to allow a model to have a feed.
```php
<?php

use Illuminate\Database\Eloquent\Model;
use Musonza\ActivityStreams\Traits\HasFeed;

class User extends Model
{
    use HasFeed;
}
``` 

#### Create a model Feed

After adding the `HasFeed` trait you can create a feed for the Model as follows
```php
$feed = $user->createFeed();
```

#### Create an Activity

An example of an activity will be something like **John liked a photo in 2018Album**

|         |            | 
| ------------- |:-------------:|
| Actor          |John |
| Verb          | like |
| Object        | photo      |
| Target        | 2018Album      |


```php
use ActivityStreams;
use Musonza\ActivityStreams\ValueObjects\Verbs;

$activity = ActivityStreams::setActor($actor)
    ->setVerb(Verbs::VERB_LIKE)
    ->setObject($object)
    ->setTarget($target)
    ->createActivity();
```

#### Actors

##### Valid Actors

You can pass in an Eloquent Model as an actor or any Object that implements `Musonza\ActivityStreams\Contracts\ActivityActor` interface

#### Targets

##### Valid Targets

You can pass in an Eloquent Model as a target or any Object that implements `Musonza\ActivityStreams\Contracts\ActivityTarget` interface

#### Objects

##### Valid Objects

You can pass in an Eloquent Model as an object or any Object that implements `Musonza\ActivityStreams\Contracts\ActivityObject` interface


#### Get supported verbs
```php
$verbs = ActivityStreams::verbs();
```

#### Add an activity to a Feed
```php
ActivityStreams::addActivityToFeed($feed, $activity);
```

#### Add multiple activities to a Feed
Adds a `Collection` of activities to a `Feed`

```php
ActivityStreams::addActivityToFeed($feed, $activities);
```

#### Add an activity to multiple Feeds
Adds an `Activity` to a `Collection` feeds

```php
ActivityStreams::addActivityToMultipleFeeds($feeds, $activity);
```

## Events

You can leverage and listen for the following events to perform actions in 
your application. For instance you can listen for an `ActivityCreated` event and depending on 
your business logic add the created event to a `Feed` or multiple feeds.

#### ActivityCreated
`Musonza\ActivityStreams\Models\Activity\ActivityCreated`

#### ActivityDeleted
`Musonza\ActivityStreams\Models\Activity\ActivityDeleted`

#### FeedCreated
`Musonza\ActivityStreams\Models\Activity\FeedCreated`

#### FeedDeleted
`Musonza\ActivityStreams\Models\Activity\FeedDeleted`

## Configuration


## FAQ
See more on Activity Streams specifications [here](http://activitystrea.ms/)

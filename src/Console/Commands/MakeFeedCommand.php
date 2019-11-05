<?php

namespace Musonza\ActivityStreams\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Musonza\ActivityStreams\Models\Feed;

final class MakeFeedCommand extends Command
{
    protected $signature = 'streams:make:feed {class : Full namespaced class} {id : Unique identifier for the Resource type}';

    protected $description = 'Create a new Feed for a specific class';

    protected $id;

    public function handle()
    {
        $class = $this->argument('class');
        $this->id = $this->argument('id');

        try {
            app($class);

            $feed = new Feed([
                'feedable_type' => $class,
                'feedable_id'  => $this->id,
            ]);

            $feed->save();

            dd($feed->toArray());
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }

    }
}
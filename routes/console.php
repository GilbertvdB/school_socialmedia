<?php

use App\Console\Commands\ClearInvalidFeedCacheCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ClearInvalidFeedCacheCommand::class)->dailyAt('00:00');

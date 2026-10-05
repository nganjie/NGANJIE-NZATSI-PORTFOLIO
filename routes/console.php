<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('messages:purge')->dailyAt('03:00');
Schedule::command('queue:prune-failed --hours=168')->weekly();

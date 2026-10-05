<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('messages:purge {--days=30 : Délai de conservation après suppression}')]
#[Description('Efface définitivement les messages supprimés depuis plus de N jours')]
class PurgeDeletedMessages extends Command
{
    public function handle(): int
    {
        $count = Message::onlyTrashed()
            ->where('deleted_at', '<', now()->subDays((int) $this->option('days')))
            ->forceDelete();

        $this->info("{$count} message(s) effacé(s) définitivement.");

        return self::SUCCESS;
    }
}

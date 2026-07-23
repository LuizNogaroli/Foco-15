<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('drafts:clean', function () {
    $deleted = \App\Models\FocoDraft::where('updated_at', '<', now()->subDays(7))->delete();
    $this->info("{$deleted} rascunho(s) antigo(s) removido(s).");
})->purpose('Remove draft records older than 7 days');

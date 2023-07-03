<?php

namespace App\Repositories\contracts;

use Illuminate\Database\Eloquent\Collection;

interface HistoryRepoInterface {
    public function storeHistory(array $payload);
}
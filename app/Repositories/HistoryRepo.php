<?php

namespace App\Repositories;

use App\Models\History;
use App\Repositories\contracts\HistoryRepoInterface;

class HistoryRepo implements HistoryRepoInterface{
    public function storeHistory(array $payload)
    {
        History::create($payload);
    }
}
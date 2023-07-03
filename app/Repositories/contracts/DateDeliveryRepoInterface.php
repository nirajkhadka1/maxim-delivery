<?php

namespace App\Repositories\contracts;

interface DateDeliveryRepoInterface{
    public function updateDate(array $payload);
    public function getAvailableDate(array $condition);
    public function getAllAvailableDates();
    public function addDate(array $payload);
    public function deleteDate(array $condition);
    public function findDate(array $condition);
    public function update(array $condition,array $payload);
}
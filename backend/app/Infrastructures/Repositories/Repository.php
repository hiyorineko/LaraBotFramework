<?php
namespace App\Infrastructures\Repositories;

interface Repository {
    public function getRequestEntity(mixed $requestBody);
}

<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\OrderLogRepository;

class LogService
{

    private $orderLogRepository;

    public function __construct(
        OrderLogRepository $orderLogRepository
    )
    {
        $this->orderLogRepository = $orderLogRepository;
    }

    public function findAll()
    {
        return $this->orderLogRepository->all();
    }

}

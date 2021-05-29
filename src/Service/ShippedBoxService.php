<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ShippedBoxRepository;

class ShippedBoxService
{

    private $shippedBoxRepository;

    public function __construct(
        ShippedBoxRepository $shippedBoxRepository
    )
    {
        $this->shippedBoxRepository = $shippedBoxRepository;
    }

    public function findAll()
    {
        return $this->shippedBoxRepository->all();
    }

}

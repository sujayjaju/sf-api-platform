<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UpdatePartner extends AbstractController
{
    public function __invoke($data, $ts = 0)
    {
        return $data;
    }
}
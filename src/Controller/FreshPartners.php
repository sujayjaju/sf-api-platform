<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class FreshPartners extends AbstractController
{
    public function __invoke($data, $ts = 0): array
    {
        $partners = [];
        foreach ($data as $partner){
            if($partner->getDoj()->getTimestamp() > $ts){
                $partners[] = $partner;
            }
        }
        return $partners;
    }
}
<?php

namespace App\Controller;

use App\Entity\Partner;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AddPartners extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    public function __invoke(Request $request, $active = 1): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        try {
            if (is_array($content)) {
                $em = $this->doctrine->getManager();
                foreach ($content as $data) {
                    if($em->getRepository(Partner::class)->findOneBy(['name' => $data['name']])){
                        return new JsonResponse(['success' => false, 'message' => "Duplicate Partner '{$data['name']}'"], 400);
                    }
                    $partner = new Partner();
                    $partner->setName($data['name']);
                    $partner->setEmail($data['email'] ?? null);
                    $partner->setPhone($data['phone'] ?? null);
                    $partner->setDoj((isset($data['doj']) and $data['doj']) ? date_create($data['doj']) : null);
                    $partner->setActive($data['active'] ?? $active);
                    $em->persist($partner);
                }
                $em->flush();
                return new JsonResponse(['success' => true]);
            }
        }catch(\Exception $e){
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()], 400);
        }
        return new JsonResponse(['success' => false, 'message' => 'Error while creating Partner'], 400);
    }
}
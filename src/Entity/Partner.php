<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\OpenApi\Model;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\AddPartners;
use App\Controller\FreshPartners;
use App\Controller\UpdatePartner;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
        operations: [
            new Get(
                normalizationContext: ['groups' => 'partner:item']
            ),
            new GetCollection(
                controller: FreshPartners::class,
                normalizationContext: ['groups' => 'partner:list']
            ),
            new GetCollection(
                uriTemplate: '/partners/join_after/{ts}',
                uriVariables: [],
                controller: FreshPartners::class,
                openapiContext: [
                    'summary' => 'Retrieves the collection of Partner resources.',
                    'parameters' => [
                        [
                            'name' => 'ts',
                            'description' => 'The timestamp when the partner joined.',
                            'type' => 'integer',
                            'in' => 'path',
                            'required' => true,
                        ]
                    ]
                ],
                normalizationContext: ['groups' => 'partner:list']
            ),
            new Post(),
            new Post(
                uriTemplate: '/partners/bulk',
                controller: AddPartners::class,
                openapi: new Model\Operation(
                    summary: 'Creates Partners.',
                    description: '',
                    requestBody: new Model\RequestBody(
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'array',
                                    'items' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'name' => ['type' => 'string'],
                                            'email' => ['type' => 'string'],
                                            'phone' => ['type' => 'string'],
                                            'doj' => ['type' => 'date', 'format' => 'date'],
                                            'active' => ['type' => 'boolean'],
                                        ]
                                    ]
                                ],
                            ]
                        ])
                    )
                ),
            ),
            new Post(
                uriTemplate: '/partners/bulk/{active}',
                uriVariables: [],
                controller: AddPartners::class,
                openapiContext: [
                    'consumes' => ['application/json'],
                    'summary' => 'Creates Partners.',
                    'parameters' => [
                        [
                            'name' => 'active',
                            'description' => 'The Partner status.',
                            'type' => 'integer',
                            'in' => 'path',
                            'required' => true
                        ]
                    ]
                ],
                openapi: new Model\Operation(
                    summary: 'Creates Partners',
                    description: '',
                    requestBody: new Model\RequestBody(
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'array',
                                    'items' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'name' => ['type' => 'string'],
                                            'email' => ['type' => 'string'],
                                            'phone' => ['type' => 'string'],
                                            'doj' => ['type' => 'date', 'format' => 'date'],
                                        ]
                                    ]
                                ],
                            ]
                        ])
                    )
                ),
            ),
            new Put(),
            new Patch(
                uriTemplate: '/partners/{id}/active',
                //uriVariables: ['id' => new Link(fromClass: self::class)],
                controller: UpdatePartner::class,
            ),
            new Patch(),
            new Delete(),
        ],
    order: ['name' => 'ASC', 'doj' => 'DESC'],
    paginationEnabled: false,
)]
#[UniqueEntity('name', message: 'Duplicate Partner Name.')]
#[ORM\Entity]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['partner:list', 'partner:item'])]
    private ?int $id = null;

    #[ORM\Column(name: 'name', length: 63, unique: true)]
    #[Groups(['partner:list', 'partner:item'])]
    private ?string $name;

    #[ORM\Column(length: 63, nullable: true)]
    #[Groups(['partner:list', 'partner:item'])]
    private ?string $email;

    #[ORM\Column(length: 63, nullable: true)]
    #[Groups(['partner:list', 'partner:item'])]
    private ?string $phone;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['partner:list', 'partner:item'])]
    private ?\DateTimeInterface $doj;

    #[ORM\Column(type: 'boolean', nullable: false, options: ['default' => true])]
    #[Groups(['partner:list', 'partner:item'])]
    private bool $active = true;

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDoj(): ?\DateTimeInterface
    {
        return $this->doj;
    }

    public function setDoj(?\DateTimeInterface $doj): static
    {
        $this->doj = $doj;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

}

<?php

declare(strict_types=1);

namespace App\OpenApi\Enum;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use MyCLabs\Enum\Enum;

#[ORM\Entity]
#[ApiResource]
class OrderStatus extends Enum
{
    /** @var string */
    public const PLACED = 'placed';

    /** @var string */
    public const APPROVED = 'approved';

    /** @var string */
    public const DELIVERED = 'delivered';

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}

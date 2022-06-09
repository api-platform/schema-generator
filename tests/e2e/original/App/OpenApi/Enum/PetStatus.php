<?php

declare(strict_types=1);

namespace App\OpenApi\Enum;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use MyCLabs\Enum\Enum;

#[ORM\Entity]
#[ApiResource]
class PetStatus extends Enum
{
    /** @var string */
    public const AVAILABLE = 'available';

    /** @var string */
    public const PENDING = 'pending';

    /** @var string */
    public const SOLD = 'sold';

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}

<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Basic\Repository\ItemRepository;
use App\Model\Database\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'items')]
#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Item extends Entity
{

	#[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    private int $id;

	#[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: false)]
    private float $price;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'currencyCode', referencedColumnName: 'code', nullable: false)]
    private Currency $currency;

    public function __construct(string $name, float $price, Currency $currency, ?string $description = null)
    {
        $this->name = $name;
        $this->price = $price;
        $this->currency = $currency;
        $this->description = $description;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

	#[ORM\PrePersist]
	public function onPrePersist(): void
	{
		$this->createdAt = new \DateTimeImmutable();
	}

}

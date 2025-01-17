<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Entity;

use App\Model\Database\Basic\Repository\CurrencyRepository;
use App\Model\Database\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'currencies')]
#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency extends Entity
{

    #[ORM\Column(name: 'code', type: 'string', length: 3)]
    #[ORM\Id]
    private string $code;

    #[ORM\Column(name: 'name', type: 'string', length: 64, nullable: false)]
    private string $name;

    #[ORM\Column(name: 'rate', type: 'decimal', precision: 15, scale: 6, nullable: false)]
    private float $rate;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: Item::class, cascade: ['persist', 'remove'])]
    private Collection $items;

    public function __construct(string $code, string $name, float $rate)
    {
        $this->code = $code;
        $this->name = $name;
        $this->rate = $rate;
        $this->items = new ArrayCollection();
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): void
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setCurrency($this);
        }
    }

    public function removeItem(Item $item): void
    {
        if ($this->items->removeElement($item)) {
            $item->setCurrency(null);
        }
    }

}

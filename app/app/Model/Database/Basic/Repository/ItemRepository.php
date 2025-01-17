<?php declare(strict_types = 1);

namespace App\Model\Database\Basic\Repository;

use App\Model\Database\Basic\Entity\Item;
use App\Model\Database\Repository\TRepositoryExtra;
use Doctrine\ORM\EntityRepository;

final class ItemRepository extends EntityRepository
{

	use TRepositoryExtra;

	public function findPaginatedItems(int $page, string $orderBy = 'price', string $orderDir = 'asc', int $itemsPerPage = 10): array
    {
        $offset = ($page - 1) * $itemsPerPage;

        $qb = $this->createQueryBuilder('i')
            ->select('i', 'c')
            ->join('i.currency', 'c')
            ->orderBy("i.$orderBy", $orderDir)
            ->setFirstResult($offset)
            ->setMaxResults($itemsPerPage);

        $items = $qb->getQuery()->getResult();

        return $this->serializeItems($items);
    }

	private function serializeItems(array $items): array
    {
        return array_map(function (Item $item) {
            return [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'price' => $this->convertToCZK($item),
                'currency' => 'CZK',
            ];
        }, $items);
    }

	private function convertToCZK(Item $item): float
    {
        $priceInCZK = $item->getPrice() * $item->getCurrency()->getRate();
        return round($priceInCZK, 2);
    }

}

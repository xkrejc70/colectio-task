<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Model\Database\Basic\Entity\Item;
use App\Model\Database\EntityManagerDecorator;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

class BasicPresenter extends Presenter
{

	/** @inject */
	public EntityManagerDecorator $em;

	public function renderDefault(): void
	{

		$itemRepository = $this->em->getRepositoryByClass(Item::class);
		/** @var Item[] $items */
		$items = $itemRepository->findAll();

		if (empty($items)) {
			$this->sendJson(['error' => 'No items found']);
			return;
		}

		$result = array_map(function (Item $item) {
			return [
				'id' => $item->getId(),
				'name' => $item->getName(),
				'price' => $item->getPrice(),
				'description' => $item->getDescription(),
				'currency' => [
					'code' => $item->getCurrency()->getCode(),
					'name' => $item->getCurrency()->getName(),
					'rate' => $item->getCurrency()->getRate(),
				],
			];
		}, $items);

		$this->sendJson($result);
	}

}

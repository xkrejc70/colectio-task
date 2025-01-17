<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Model\Database\Basic\Entity\Item;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Service\JsonResponseFormatter;
use Nette\Application\UI\Presenter;
use Nette\Application\Responses\JsonResponse;

class ApiPresenter extends Presenter
{

	#[Inject]
	public EntityManagerDecorator $em;

	public function actionItems(): void
	{
		$page = $this->getParameter('page') ? max(1, (int)$this->getParameter('page')) : 1;
		$orderBy = $this->getParameter('orderBy') ?: 'price';
		$orderDir = $this->getParameter('orderDir') ?: 'asc';

		$validOrderBy = ['price', 'name', 'createdAt'];
		$validOrderDir = ['asc', 'desc'];

		if (!in_array($orderBy, $validOrderBy, true)) {
			$this->sendError('Invalid orderBy parameter.', 400);
			return;
		}

		if (!in_array($orderDir, $validOrderDir, true)) {
			$this->sendError(['Invalid orderDir parameter.'], 400);
			return;
		}

		$itemsPerPage = 10;
		$offset = ($page - 1) * $itemsPerPage;

		$qb = $this->em->createQueryBuilder();
		$qb->select('i', 'c')
			->from(Item::class, 'i')
			->join('i.currency', 'c')
			->orderBy("i.$orderBy", $orderDir)
			->setFirstResult($offset)
			->setMaxResults($itemsPerPage);

		$items = $qb->getQuery()->getResult();

		if (empty($items)) {
			$this->sendError('No items found', 400);
			return;
		}

		$result = array_map(function (Item $item) {
			return [
				'id' => $item->getId(),
				'name' => $item->getName(),
				'price' => $this->convertToCZK($item),
				'description' => $item->getDescription(),
				'currency' => [
					'code' => $item->getCurrency()->getCode(),
					'name' => $item->getCurrency()->getName(),
					'rate' => $item->getCurrency()->getRate(),
				],
			];
		}, $items);

		$this->sendSuccess([
			'page' => $page,
			'items' => $result,
		]);
	}

	private function sendSuccess($data): void
    {
        $this->getHttpResponse()->setCode(200);
        $this->sendResponse(new JsonResponse(JsonResponseFormatter::success($data)));
    }

    private function sendError(string $message, int $statusCode): void
    {
        $this->getHttpResponse()->setCode($statusCode);
        $this->sendResponse(new JsonResponse(JsonResponseFormatter::error($message, $statusCode)));
    }

    private function convertToCZK(Item $item): float
    {
        $priceInCZK = $item->getPrice() * $item->getCurrency()->getRate();
        return round($priceInCZK, 2);
    }

}

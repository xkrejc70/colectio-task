<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Model\Database\Basic\Entity\Item;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Service\JsonResponseFormatter;
use Nette\Application\UI\Presenter;
use Nette\Application\Responses\JsonResponse;

class ApiPresenter extends Presenter
{

	/** @inject */
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
		
		$items = $this->em->getRepositoryByClass(Item::class)->findPaginatedItems($page, $orderBy, $orderDir);

        if (empty($items)) {
            $this->sendError('No items found', 400);
            return;
        }

        $this->sendSuccess([
            'page' => $page,
            'items' => $items,
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

}

<?php declare(strict_types = 1);

namespace App\Model\Database;

use App\Model\Database\Basic\Entity\Book;
use App\Model\Database\Basic\Entity\Category;
use App\Model\Database\Basic\Repository\BookRepository;
use App\Model\Database\Basic\Repository\CategoryRepository;

/**
 * Shortcuts for type hinting
 */
trait TRepositories
{

	public function getBookRepository(): BookRepository
	{
		return $this->getRepository(Book::class);
	}

	public function getCategoryRepository(): CategoryRepository
	{
		return $this->getRepository(Category::class);
	}

}

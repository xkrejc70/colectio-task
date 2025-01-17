<?php declare(strict_types = 1);

namespace App\Model\Database;

/**
 * Shortcuts for type hinting
 */
trait TRepositories
{

	/**
	 * @template T of object
	 * @param class-string<T> $className
	 * @return T
	 */
	public function getRepositoryByClass(string $entityClass)
    {
        return $this->getRepository($entityClass);
    }

}

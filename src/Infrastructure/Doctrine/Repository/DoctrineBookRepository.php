<?php

namespace Library\Infrastructure\Doctrine\Repository;

use Doctrine\Common\Persistence\ObjectManager;
use Library\Domain\Book;
use Library\Domain\Repository\BookRepository;

class DoctrineBookRepository implements BookRepository
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function find(string $isbnNumber): ?Book
    {
        return $this->objectManager->getRepository(Book::class)->find($isbnNumber);
    }
}

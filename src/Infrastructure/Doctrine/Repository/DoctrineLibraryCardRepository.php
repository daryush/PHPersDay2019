<?php

namespace Library\Infrastructure\Doctrine\Repository;

use Doctrine\Common\Persistence\ObjectManager;
use Library\Domain\LibraryCard;
use Library\Domain\Repository\LibraryCardRepository;

class DoctrineLibraryCardRepository implements LibraryCardRepository
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function find(string $isbnNumber): ?LibraryCard
    {
        return $this->objectManager->getRepository(LibraryCard::class)->find($isbnNumber);
    }
}

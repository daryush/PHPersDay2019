<?php

namespace Library\Infrastructure\InMemory\Repository;

use Library\Domain\LibraryCard;
use Library\Domain\Repository\LibraryCardRepository;

class InMemoryLibraryCardRepository implements LibraryCardRepository
{
    /**
     * @var array|LibraryCard[]
     */
    private $libraryCards;

    /**
     * @param array|LibraryCard[] $libraryCards
     */
    public function __construct(array $libraryCards)
    {
        foreach ($libraryCards as $libraryCard) {
            $this->libraryCards[$libraryCard->getReaderEmail()] = $libraryCard;
        }
    }

    public function find(string $isbnNumber): ?LibraryCard
    {
        return array_key_exists($isbnNumber, $this->libraryCards)? $this->libraryCards[$isbnNumber] : null;
    }
}

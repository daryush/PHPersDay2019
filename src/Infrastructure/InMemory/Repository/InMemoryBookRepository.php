<?php

namespace Library\Infrastructure\InMemory\Repository;

use Library\Domain\Book;
use Library\Domain\Repository\BookRepository;


class InMemoryBookRepository implements BookRepository
{
    /**
     * @var array|Book[]
     */
    private $books;

    /**
     * @param array|Book[] $books
     */
    public function __construct(array $books)
    {
        foreach ($books as $book) {
            $this->books[$book->getIsbnNumber()] = $book;
        }
    }

    public function find(string $isbnNumber): ?Book
    {
        return array_key_exists($isbnNumber, $this->books) ? $this->books[$isbnNumber] : null;
    }
}

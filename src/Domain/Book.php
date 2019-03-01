<?php

namespace Library\Domain;

class Book
{
    private $bookTitle;

    private $isbnNumber;

    private $borrowingDays;

    public function __construct(string $bookTitle, string $isbnNumber, int $borrowingDays)
    {
        $this->bookTitle = $bookTitle;
        $this->isbnNumber = $isbnNumber;
        $this->borrowingDays = $borrowingDays;
    }

    public function getIsbnNumber(): string
    {
        return $this->isbnNumber;
    }

    public function getBorrowingDays(): int
    {
        return $this->borrowingDays;
    }
}

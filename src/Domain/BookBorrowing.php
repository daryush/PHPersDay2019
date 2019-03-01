<?php

namespace Library\Domain;

class BookBorrowing
{
    /**
     * @var string
     */
    private $isbnNumber;

    /**
     * @var \DateTimeImmutable
     */
    private $returnDate;

    public function __construct(string $isbnNumber, \DateTimeImmutable $returnDate)
    {
        $this->isbnNumber = $isbnNumber;
        $this->returnDate = $returnDate;
    }

    public function getIsbnNumber(): string
    {
        return $this->isbnNumber;
    }

    public function getReturnDate(): \DateTimeImmutable
    {
        return $this->returnDate;
    }
}

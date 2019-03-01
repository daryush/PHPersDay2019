<?php

namespace Library\Application\Command;

class BorrowBook
{
    /**
     * @var string
     */
    private $readerEmail;
    /**
     * @var string
     */
    private $isbnNumber;

    /**
     * @var \DateTimeImmutable
     */
    private $borrowingDate;

    public function __construct(string $readerEmail, string $isbnNumber, \DateTimeImmutable $borrowingDate)
    {
        $this->readerEmail = $readerEmail;
        $this->isbnNumber = $isbnNumber;
        $this->borrowingDate = $borrowingDate;
    }

    public function getReaderEmail(): string
    {
        return $this->readerEmail;
    }

    public function getIsbnNumber(): string
    {
        return $this->isbnNumber;
    }

    public function getBorrowingDate(): \DateTimeImmutable
    {
        return $this->borrowingDate;
    }
}

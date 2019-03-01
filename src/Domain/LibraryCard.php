<?php

namespace Library\Domain;

use Library\Domain\Repository\BookRepository;

class LibraryCard
{
    /**
     * @var string
     */
    private $readerEmail;

    /**
     * @var array|BookBorrowing[]
     */
    private $borrowings;

    public function __construct(string $readerEmail)
    {
        $this->readerEmail = $readerEmail;
    }

    public function getReaderEmail(): string
    {
        return $this->readerEmail;
    }

    public function recordBorrowing(
        string $isbnNumber,
        \DateTimeImmutable $borrowingDate,
        BookRepository $bookRepository
    ) {
        $book = $bookRepository->find($isbnNumber);

        $this->borrowings[] = new BookBorrowing(
            $isbnNumber,
            $borrowingDate->add(
                new \DateInterval(sprintf('P%sD', $book->getBorrowingDays()))
            )
        );
    }

    /**
     * @return array|BookBorrowing[]
     */
    public function getBorrowings(): array
    {
        return $this->borrowings;
    }
}

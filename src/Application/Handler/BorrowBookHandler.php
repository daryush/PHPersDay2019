<?php

namespace Library\Application\Handler;

use Library\Application\Command\BorrowBook;
use Library\Domain\Repository\BookRepository;
use Library\Domain\Repository\LibraryCardRepository;

class BorrowBookHandler
{
    /**
     * @var LibraryCardRepository
     */
    private $libraryCardRepository;

    /**
     * @var BookRepository
     */
    private $bookRepository;

    public function __construct(LibraryCardRepository $libraryCardRepository, BookRepository $bookRepository)
    {
        $this->libraryCardRepository = $libraryCardRepository;
        $this->bookRepository = $bookRepository;
    }

    public function handle(BorrowBook $command)
    {
        $libraryCard = $this->libraryCardRepository->find($command->getReaderEmail());

        $libraryCard->recordBorrowing(
            $command->getIsbnNumber(),
            $command->getBorrowingDate(),
            $this->bookRepository
        );
    }
}

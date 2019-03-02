<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

use Library\Domain\LibraryCard;
use Library\Domain\Repository\LibraryCardRepository;
use Library\Infrastructure\InMemory\Repository\InMemoryLibraryCardRepository;

use Library\Domain\Book;
use Library\Domain\Repository\BookRepository;
use Library\Infrastructure\InMemory\Repository\InMemoryBookRepository;

use Library\Application\Command\BorrowBook;
use Library\Application\Handler\BorrowBookHandler;

class LibraryContext implements Context
{
    /**
     * @var LibraryCardRepository
     */
    private $libraryCardRepository;

    /**
     * @var BookRepository
     */
    private $bookRepository;

    /**
     * @var \DateTimeImmutable
     */
    private $today;

    /**
     * @Given there is reader :readerEmail
     */
    public function thereIsReader($readerEmail)
    {
        $this->libraryCardRepository = new InMemoryLibraryCardRepository([
            new LibraryCard($readerEmail)
        ]);
    }

    /**
     * @Given there is book :bookTitle with isbn number :isbnNumber that can be borrowed for :borrowingDays days
     */
    public function thereIsBookWithIsbnNumberThatCanBeBorrowedForDays($bookTitle, $isbnNumber, $borrowingDays)
    {
        $this->bookRepository = new InMemoryBookRepository([
            new Book($bookTitle, $isbnNumber, $borrowingDays)
        ]);
    }

    /**
     * @Given today is :todayDate
     */
    public function todayIs($todayDate)
    {
        $this->today = new \DateTimeImmutable($todayDate);
    }

    /**
     * @When :readerEmail borrow book :bookTitle marked with isbn :isbnNumber
     */
    public function borrowBookMarkedWithIsbn($readerEmail, $bookTitle, $isbnNumber)
    {
        $command = new BorrowBook($readerEmail, $isbnNumber, $this->today);

        $handler = new BorrowBookHandler($this->libraryCardRepository, $this->bookRepository);

        $handler->handle($command);
    }

    /**
     * @Then :readerEmail library card should contain borrowing of book with isbn :bookIsbn
     */
    public function libraryCardShouldContainBorrowingOfBookWithIsbn($readerEmail, $bookIsbn)
    {
        $libraryCard = $this->libraryCardRepository->find($readerEmail);

        foreach ($libraryCard->getBorrowings() as $borrowing) {
            if ($borrowing->getIsbnNumber() === $bookIsbn) {
                return;
            }
        }

        throw new \LogicException(sprintf('There is no boorrowing for isbn %s', $bookIsbn));
    }

    /**
     * @Then :readerEmail should return book with isbn :bookIsbn at least on :returnDay
     */
    public function shouldReturnBookWithIsbnAtLeastOn($readerEmail, $bookIsbn, $returnDay)
    {
        $libraryCard = $this->libraryCardRepository->find($readerEmail);

        foreach ($libraryCard->getBorrowings() as $borrowing) {
            if ($borrowing->getIsbnNumber() === $bookIsbn) {
                if ($borrowing->getReturnDate() != new \DateTimeImmutable($returnDay)) {
                    throw new \LogicException(
                        sprintf(
                            'Book should be returned at least on %s, but %s found',
                            $returnDay,
                            $borrowing->getReturnDate()->format('d-m-Y')
                        )
                    );
                }
            }
        }
    }
}

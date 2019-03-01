<?php

namespace spec\Library\Domain;

use Library\Domain\Book;
use Library\Domain\LibraryCard;
use Library\Domain\Repository\BookRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Library\Domain\BookBorrowing;

class LibraryCardSpec extends ObjectBehavior
{
    function it_records_book_borrowing(
        BookRepository $bookRepository,
        Book $book
    ) {
        $bookIsbn = '9781234567897';
        $borrowingDate = new \DateTimeImmutable('02-03-2019');
        $borrowingDays = 7;
        $readerEmail = 'john@test.com';

        $bookRepository->find($bookIsbn)->willReturn($book);
        $book->getBorrowingDays()->willReturn($borrowingDays);

        $this->beConstructedWith($readerEmail);

        $this->recordBorrowing($bookIsbn, $borrowingDate, $bookRepository);

        $expectedReturnDate = $borrowingDate->add(
            new \DateInterval(sprintf('P%sD', $borrowingDays))
        );

        $this->getBorrowings()->shouldBeLike([
           new BookBorrowing($bookIsbn, $expectedReturnDate)
        ]);
    }
}

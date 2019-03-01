<?php

namespace spec\Library\Application\Handler;

use Library\Application\Command\BorrowBook;
use Library\Application\Handler\BorrowBookHandler;
use Library\Domain\LibraryCard;
use Library\Domain\Repository\BookRepository;
use Library\Domain\Repository\LibraryCardRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BorrowBookHandlerSpec extends ObjectBehavior
{
    function it_borrows_book(
        LibraryCardRepository $libraryCardRepository,
        LibraryCard $libraryCard,
        BookRepository $bookRepository
    ) {
        $this->beConstructedWith($libraryCardRepository, $bookRepository);

        $readerEmail = 'john@mail.com';
        $bookIsbn = '9781234567897';
        $date = new \DateTimeImmutable('02-03-2019');
        $command = new BorrowBook($readerEmail, $bookIsbn, $date);

        $libraryCardRepository->find($readerEmail)->willReturn($libraryCard);
        $libraryCard->recordBorrowing($bookIsbn, $date, $bookRepository)->shouldBeCalled();

        $this->handle($command);
    }
}

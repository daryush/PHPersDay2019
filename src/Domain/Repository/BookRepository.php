<?php

namespace Library\Domain\Repository;

use Library\Domain\Book;

interface BookRepository
{
    public function find(string $isbnNumber): ?Book;
}

<?php

namespace Library\Domain\Repository;

use Library\Domain\LibraryCard;

interface LibraryCardRepository
{
    public function find(string $isbnNumber): ?LibraryCard;
}

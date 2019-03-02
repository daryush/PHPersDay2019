<?php

namespace Library\Infrastructure\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Library\Application\Command\BorrowBook;
use Library\Application\Handler\BorrowBookHandler;
use Library\Domain\Book;
use Library\Domain\LibraryCard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LibraryController extends AbstractController
{
    /**
     * @Route("/library/borrow", name="library_borrow", methods={"POST"})
     */
    public function borrow(
        Request $request,
        BorrowBookHandler $handler,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {

        $command = new BorrowBook(
            $request->get('userEmail'),
            $request->get('isbn'),
            new \DateTimeImmutable('now')
        );

        $errors = $validator->validate($command);

        if (count($errors) === 0) {
            $handler->handle($command);

            $entityManager->flush();

            return $this->json(['status' => 'ok'], Response::HTTP_CREATED);
        }

        return $this->json($errors, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/library/init", name="library_demo_init", methods={"POST"})
     */
    public function init(
        EntityManagerInterface $entityManager
    ) {
        $card = new LibraryCard('mail@mail.com');

        $book = new Book('Professional PHP6', '9781234567897', 7);

        $entityManager->persist($card);
        $entityManager->persist($book);
        $entityManager->flush();

        return $this->json(['status' => 'ok'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/library/list", name="library_demo_list", methods={"GET"})
     */
    public function list(
        EntityManagerInterface $entityManager
    ) {
        /** @var LibraryCard[] $libraryCards */
        $libraryCards = $entityManager->getRepository(LibraryCard::class)->findAll();

        return $this->json(['status' => 'ok', 'libraryCards' => $libraryCards], Response::HTTP_OK);
    }

}

<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Book;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

class ReviewDataPersister implements ContextAwareDataPersisterInterface {
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function supports($data, array $context = []): bool{
        return $data instanceof Review;
    }

    public function persist($data, array $context = []): void{
        $book = $data->getBook();

        $book->setAverageRating(
            $this->calculateAvgRating($book)
        );

        $this->entityManager->persist($book);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data, array $context = []): void{
        $book = $data->getBook();

        $book->setAverageRating(
            $this->calculateAvgRating($book)
        );

        $this->entityManager->persist($book);
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

    private function calculateAvgRating(Book $book): float{
        $reviews = $book->getReviews();
        $totalRatings = 0;
        $reviewCount = 0;

        foreach($reviews as $review) {
            $totalRatings += $review->getRating();
            $reviewCount += 1;
        }

        return ($totalRatings / $reviewCount);
    }
}
<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ReviewStateProcessor implements ProcessorInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->logger->info($data);
        $book = $data->getBook();

        $reviews = $book->getReviews();
        $totalRatings = 0;
        $reviewCount = 0;
        foreach($reviews as $review) {
            $totalRatings += $review->getRating();
            $reviewCount += 1;
        }

        $book->setAverageRating($totalRatings / $reviewCount);
        $this->entityManager->persist($book);
        $this->entityManager->flush();
    }
}

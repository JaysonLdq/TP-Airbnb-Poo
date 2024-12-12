<?php

namespace App\Model\Entity;

class Location
{
    private ?int $id = null;          
    private int $logementId;          
    private int $userId;              
    private string $rentalDate;      
    private string $endDate;          

    /**
     * Constructeur pour l'entité Location
     *
     * @param int $logementId
     * @param int $userId
     * @param string $rentalDate
     * @param string $endDate
     */
    public function __construct(int $logementId, int $userId, string $rentalDate, string $endDate)
    {
        $this->logementId = $logementId;
        $this->userId = $userId;
        $this->rentalDate = $rentalDate;
        $this->endDate = $endDate;
    }

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLogementId(): int
    {
        return $this->logementId;
    }

    public function setLogementId(int $logementId): void
    {
        $this->logementId = $logementId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getRentalDate(): string
    {
        return $this->rentalDate;
    }

    public function setRentalDate(string $rentalDate): void
    {
        $this->rentalDate = $rentalDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }
}

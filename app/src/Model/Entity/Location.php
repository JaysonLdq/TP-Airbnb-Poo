<?php

namespace App\Model\Entity;

class Location
{         
    public int $logement_id;          
    public int $user_id;              
    public string $rental_date;      
    public string $end_date;          

    /**
     * Constructeur pour l'entité Location
     *
     * @param int $logementId
     * @param int $userId
     * @param string $rentalDate
     * @param string $endDate
     */


    // Getters et Setters

   

    public function getLogementId(): int
    {
        return $this->logement_id;
    }

    public function setLogementId(int $logementId): void
    {
        $this->logement_id = $logementId;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $userId): void
    {
        $this->user_id = $userId;
    }

    public function getRentalDate(): string
    {
        return $this->rental_date;
    }

    public function setRentalDate(string $rentalDate): void
    {
        $this->rental_date = $rentalDate;
    }

    public function getEndDate(): string
    {
        return $this->end_date;
    }

    public function setEndDate(string $endDate): void
    {
        $this->end_date = $endDate;
    }
}

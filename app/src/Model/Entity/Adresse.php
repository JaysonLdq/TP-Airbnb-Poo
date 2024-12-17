<?php

namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Adresse extends Entity
{
    protected string $adresse;
    protected string $ville;
    protected string $code_postal;
    protected string $pays;

    // Getter et Setter pour $street
    public function getStreet(): string
    {
        return $this->adresse;
    }

    public function setStreet(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    // Getter et Setter pour $city
    public function getCity(): string
    {
        return $this->ville;
    }

    public function setCity(string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    // Getter et Setter pour $zipCode
    public function getZipCode(): string
    {
        return $this->code_postal;
    }

    public function setZipCode(string $code_postal): self
    {
        $this->code_postal = $code_postal;
        return $this;
    }

    // Getter et Setter pour $country
    public function getPays(): string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;
        return $this;
    }
}
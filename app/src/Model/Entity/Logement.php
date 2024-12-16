<?php
namespace App\Model\Entity;

use Symplefony\Model\Entity;

class Logement extends Entity
{
   
    protected int $type_id;
    protected float $price;
    protected string $date_added;
    protected ?string $image;
    protected int $proprietaire_id;
    protected int $adresse_id;
    protected string $description;
    protected int $nb_rooms;
    protected int $surface;
  


    // Getter et Setter pour $typeId
    public function getTypeId(): int
    {
        return $this->type_id;
    }

    public function setTypeId(int $typeId): self
    {
        $this->type_id = $typeId;
        return $this;
    }

    // Getter et Setter pour $prix
    public function getPrix(): float
    {
        return $this->price;
    }

    public function setPrix(float $prix): self
    {
        $this->price = $prix;
        return $this;
    }

    // Getter et Setter pour $dateAdded
    public function getDateAdded(): string
    {
        return $this->date_added;
    }

    public function setDateAdded(string $dateAdded): self
    {
        $this->date_added = $dateAdded;
        return $this;
    }

    // Getter et Setter pour $image
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    // Getter et Setter pour $proprietaireId
    public function getProprietaireId(): int
    {
        return $this->proprietaire_id;
    }

    public function setProprietaireId(int $proprietaireId): self
    {
        $this->proprietaire_id = $proprietaireId;
        return $this;
    }

    // Getter et Setter pour $adresseId
    public function getAdresseId(): int
    {
        return $this->adresse_id;
    }

    public function setAdresseId(int $adresseId): self
    {
        $this->adresse_id = $adresseId;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setNbRooms(int $nb_rooms): self
    {
        $this->nb_rooms = $nb_rooms;
        return $this;
    }

    public function getNbRooms(): int
    {
        return $this->nb_rooms;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;
        return $this;
    }

    public function getSurface(): int
    {
        return $this->surface;
    }
}
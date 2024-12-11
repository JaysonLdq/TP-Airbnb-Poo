<?php
namespace App\Model\Entity;

class Logement
{
    private int $id;
    private int $typeId;
    private float $prix;
    private string $dateAdded;
    private ?string $image;
    private int $proprietaireId;
    private int $adresseId;

    public function __construct()
    {
        // Initialisation par défaut de dateAdded à la date actuelle
        $this->dateAdded = date('Y-m-d H:i:s'); // Utilisation de la date et de l'heure actuelles
    }

    // Getter et Setter pour $id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    // Getter et Setter pour $typeId
    public function getTypeId(): int
    {
        return $this->typeId;
    }

    public function setTypeId(int $typeId): self
    {
        $this->typeId = $typeId;
        return $this;
    }

    // Getter et Setter pour $prix
    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    // Getter et Setter pour $dateAdded
    public function getDateAdded(): string
    {
        return $this->dateAdded;
    }

    public function setDateAdded(string $dateAdded): self
    {
        $this->dateAdded = $dateAdded;
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
        return $this->proprietaireId;
    }

    public function setProprietaireId(int $proprietaireId): self
    {
        $this->proprietaireId = $proprietaireId;
        return $this;
    }

    // Getter et Setter pour $adresseId
    public function getAdresseId(): int
    {
        return $this->adresseId;
    }

    public function setAdresseId(int $adresseId): self
    {
        $this->adresseId = $adresseId;
        return $this;
    }
}

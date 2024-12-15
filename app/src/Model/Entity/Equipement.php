<?php

namespace App\Model\Entity;

class Equipement
{
    private ?int $id = null; // ID de l'équipement
    private string $nom;     // Nom de l'équipement

    /**
     * Récupère l'ID de l'équipement.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Définit l'ID de l'équipement.
     *
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Récupère le nom de l'équipement.
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Définit le nom de l'équipement.
     *
     * @param string $nom
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
}

<?php

/**
 * Classe Bibliotheque : gere une collection de livres.
 *
 * Tableau prive de Livre. Methodes : ajouter, trouver, tous, compter, rechercher, statistiques.
 */
class Bibliotheque
{
    /** @var Livre[] */
    private array $livres = [];

    /**
     * Ajoute un livre a la bibliotheque.
     * @throws Exception si un livre avec le meme ISBN existe deja
     */
    public function ajouter(Livre $l): void
    {
        if ($this->trouver($l->getIsbn()) !== null) {
            throw new Exception("Un livre avec l'ISBN {$l->getIsbn()} existe deja.");
        }
        $this->livres[] = $l;
    }

    /**
     * Trouve un livre par son ISBN.
     * @return Livre|null Le livre trouve ou null
     */
    public function trouver(string $isbn): ?Livre
    {
        foreach ($this->livres as $livre) {
            if ($livre->getIsbn() === $isbn) {
                return $livre;
            }
        }
        return null;
    }

    /**
     * Retourne tous les livres.
     * @return Livre[]
     */
    public function tous(): array
    {
        return $this->livres;
    }

    /**
     * Compte le nombre de livres.
     */
    public function compter(): int
    {
        return count($this->livres);
    }

    /**
     * Recherche des livres par mot-cle dans le titre ou l'auteur (insensible a la casse).
     * @return Livre[]
     */
    public function rechercher(string $mot): array
    {
        $resultats = [];
        foreach ($this->livres as $livre) {
            if (stripos($livre->getTitre(), $mot) !== false
                || stripos($livre->getAuteur(), $mot) !== false) {
                $resultats[] = $livre;
            }
        }
        return $resultats;
    }

    /**
     * Retourne les statistiques du catalogue.
     * @return array{total:int, disponibles:int, empruntes:int, auteurs_differents:int, taux_disponibilite:float}
     */
    public function statistiques(): array
    {
        $total = count($this->livres);
        $disponibles = 0;
        $auteurs = [];

        foreach ($this->livres as $livre) {
            if ($livre->estDisponible()) {
                $disponibles++;
            }
            $auteurs[mb_strtolower(trim($livre->getAuteur()))] = true;
        }

        return [
            'total'              => $total,
            'disponibles'        => $disponibles,
            'empruntes'          => $total - $disponibles,
            'auteurs_differents' => count($auteurs),
            'taux_disponibilite' => $total === 0 ? 0.0 : round($disponibles / $total * 100, 2),
        ];
    }
}
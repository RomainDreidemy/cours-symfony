# Travaux pratique: Beer

## Membres du groupe
- ROUX Fiona
- BALDUCCI Victor
- TAN Amanda
- VINCELET Mathias
- DREIDEMY Romain


## Partie 4
```php
public function findCatSpecial(int $id)
{
    return $this->createQueryBuilder('c')
        ->join('c.beers', 'b') // raisonner en terme de relation
        ->where('b.id = :id')
        ->setParameter('id', $id)
        ->andWhere('c.term = :term')
        ->setParameter('term', 'special')
        ->getQuery()
        ->getResult();
}
```

Définition: Retourne la liste des catégories spécials pour une bière dont l'id est donné.


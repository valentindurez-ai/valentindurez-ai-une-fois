<?php

namespace App\Belgique;

/**
 * Catalogue (non exhaustif, une fois) de la culture belge.
 */
final class Culture
{
    public const SAUCES = [
        ['nom' => 'Andalouse', 'piquant' => 2, 'note' => 'La reine incontestée du frietkot.'],
        ['nom' => 'Samouraï', 'piquant' => 4, 'note' => 'Pour ceux qui aiment souffrir avec élégance.'],
        ['nom' => 'Américaine', 'piquant' => 1, 'note' => 'Rien à voir avec les États-Unis, tout à voir avec le bonheur.'],
        ['nom' => 'Brazil', 'piquant' => 1, 'note' => 'Mayo, ananas, curry. Ne posez pas de questions.'],
        ['nom' => 'Pickles', 'piquant' => 2, 'note' => 'Jaune fluo, croquant, indispensable.'],
        ['nom' => 'Tartare', 'piquant' => 1, 'note' => 'Le choix sûr avec une fricadelle.'],
        ['nom' => 'Hannibal', 'piquant' => 3, 'note' => 'Une invention liégeoise qui ne fait pas de prisonniers.'],
        ['nom' => 'Mayonnaise', 'piquant' => 0, 'note' => 'Le classique. Point.'],
        ['nom' => 'Cocktail', 'piquant' => 0, 'note' => 'Rose, douce, un peu kitsch. On assume.'],
        ['nom' => 'Biggy Burger', 'piquant' => 1, 'note' => 'Le goût du snack de minuit après la guindaille.'],
    ];

    public const BIERES = [
        ['style' => 'Trappiste', 'exemple' => 'Orval, Rochefort, Westmalle', 'degre' => '6–11 %', 'verre' => 'Calice'],
        ['style' => 'Gueuze', 'exemple' => 'Cantillon, 3 Fonteinen', 'degre' => '5–7 %', 'verre' => 'Flûte'],
        ['style' => 'Kriek', 'exemple' => 'Lindemans, Boon', 'degre' => '4–6 %', 'verre' => 'Ballon'],
        ['style' => 'Tripel', 'exemple' => 'Karmeliet, Westmalle Tripel', 'degre' => '8–9,5 %', 'verre' => 'Tulipe'],
        ['style' => 'Saison', 'exemple' => 'Dupont, Saison de Silly', 'degre' => '5–7 %', 'verre' => 'Tulipe'],
        ['style' => 'Blanche', 'exemple' => 'Hoegaarden, Blanche de Namur', 'degre' => '4,5–5 %', 'verre' => 'Gobelet'],
    ];

    public const BD = [
        ['titre' => 'Tintin', 'auteur' => 'Hergé', 'annee' => 1929, 'emoji' => '🚀'],
        ['titre' => 'Spirou', 'auteur' => 'Rob-Vel / Franquin', 'annee' => 1938, 'emoji' => '🐿️'],
        ['titre' => 'Lucky Luke', 'auteur' => 'Morris', 'annee' => 1946, 'emoji' => '🤠'],
        ['titre' => 'Blake et Mortimer', 'auteur' => 'Edgar P. Jacobs', 'annee' => 1946, 'emoji' => '🕵️'],
        ['titre' => 'Les Schtroumpfs', 'auteur' => 'Peyo', 'annee' => 1958, 'emoji' => '🍄'],
        ['titre' => 'Gaston Lagaffe', 'auteur' => 'Franquin', 'annee' => 1957, 'emoji' => '🐱'],
    ];

    public const DICO = [
        ['mot' => 'Septante / Nonante', 'sens' => '70 / 90. Logique, non ?'],
        ['mot' => 'Une fois', 'sens' => 'Ponctuation universelle. « Viens ici une fois. »'],
        ['mot' => 'Drache', 'sens' => 'Grosse averse. La météo nationale.'],
        ['mot' => 'Kot', 'sens' => 'Chambre d\'étudiant (et mode de vie).'],
        ['mot' => 'Guindaille', 'sens' => 'Fête étudiante où la bière coule à flots.'],
        ['mot' => 'Savoir', 'sens' => 'Pouvoir. « Tu sais me passer le sel ? »'],
        ['mot' => 'Dikkenek', 'sens' => 'Grande gueule, vantard.'],
        ['mot' => 'Carabistouille', 'sens' => 'Bêtise, sornette.'],
        ['mot' => 'Il fait cru', 'sens' => 'Il fait froid et humide (donc souvent).'],
        ['mot' => 'S\'il vous plaît', 'sens' => 'Aussi « tenez » quand on donne quelque chose.'],
    ];

    public const CLICHES_CLOUD = [
        'Ton code est déployé plus vite qu\'une frite ne refroidit.',
        'Scaling automatique : comme un frietkot un samedi à 3h du matin.',
        'Zéro downtime. Même pendant la drache.',
        'Worker mode : le PHP reste chaud, comme une gaufre de Liège.',
        'Données hébergées en Europe. Le Manneken Pis approuve.',
        'Moins cher qu\'une tournée générale au Délirium.',
    ];

    public static function sauceAleatoire(): array
    {
        return self::SAUCES[random_int(0, \count(self::SAUCES) - 1)];
    }

    public static function slogan(): string
    {
        return self::CLICHES_CLOUD[random_int(0, \count(self::CLICHES_CLOUD) - 1)];
    }
}

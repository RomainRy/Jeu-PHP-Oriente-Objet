<?php

//classe pour représenter un personnage
class Personnage {
    public $name;  //attribut de la classe Personnage
    public $marbles;
    public $loss;
    public $gain;
    public $screem_war;

    // Constructeur de la classe Personnage
    public function __construct($name, $marbles, $loss, $gain, $screem_war) {
        $this->name = $name;
        $this->marbles = $marbles;
        $this->loss = $loss;
        $this->gain = $gain;
        $this->screem_war = $screem_war;
    }
}


//classe pour représenter un ennemi
class Ennemy {
    public $name;
    public $marbles;
    public $age;

    //// Constructeur de la classe Ennemy
    public function __construct($name, $marbles, $age) {
        $this->name = $name;
        $this->marbles = $marbles;
        $this->age = $age;
    }
}


//fonction pour choisir un personnage aléatoire
function choisirPersonnageAleatoire() {
    $personnages = [
        new Personnage("Seong Gi-hun", 15, 2, 1, "Lets-go !"), //création d'un nouveaux personnage avec des caractéristique spécifique
        new Personnage("Kang Sae-byeok", 25, 1, 2, "Bingo !"),
        new Personnage("Cho Sang-woo", 35, 0, 3, "Incroyable !")
    ];

    return $personnages[array_rand($personnages)]; //renvoie un personnage aléatoire
}

//fonction pour choisir un ennemi aléatoire
function choisirEnnemyAleatoire() {
    $ennemy = [];
    for ($i = 1; $i <= 20; $i++) {
        $ennemy[] = new Ennemy("adversaire n°" . $i, rand(1, 20), rand(18, 50));
    }

    return $ennemy[array_rand($ennemy)];
}

//fonction pour jouer une partie
function jouerPartie($personnage, $ennemy) {
    echo "<br>";
    echo "<br>";
    echo "Vous jouez contre " . $ennemy->name;
    echo "<br>";
    echo "Vos billes restantes : " . $personnage->marbles;
    echo "<br>";

    // Génère un nombre aléatoire entre 0 et 1
    $deviner = rand(0, 1); // 0 pour pair, 1 pour impair

    echo "Vous pensez que " . $ennemy->name . " a un nombre de billes " . ($deviner == 0 ? "pair" : "impair");
    echo "<br>";

    if (($ennemy->marbles % 2 == 0 && $deviner == 0) || ($ennemy->marbles % 2 != 0 && $deviner == 1)) {
        // Le joueur a trouvé la bonne réponse, il gagne des billes
        $personnage->marbles += ($ennemy->marbles + $personnage->gain);
        echo $ennemy->name . " à " . $ennemy->marbles . " billes";
        echo "<br>";
        echo "Bravo ! Vous avez trouvé la bonne réponse " . $personnage->screem_war;
        echo "<br>";
        echo "Vous avez gagné " . ($ennemy->marbles + $personnage->gain) . " billes";
        echo "<br>";
        return true;
    } else {
        // Le joueur n'a pas trouvé la bonne réponse, il perd des billes
        echo $ennemy->name . " à " . $ennemy->marbles . " billes";
        echo "<br>";
        echo "Malheureusement, vous vous êtes trompé ";
        echo "<br>";
        echo "Vous avez perdu " . ($ennemy->marbles + $personnage->loss) . " billes";
        echo "<br>";
        $personnage->marbles -= ($ennemy->marbles + $personnage->loss);

        // Vérifie si le personnage a perdu l'intégralité de ses billes
        if ($personnage->marbles <= 0) { 
            echo "Game Over ! Vous n'avez pu conserver aucune bille. Meilleure chance la prochaine fois !";
            return false;
        }

        return true;
    }
}

// Fonction pour démarrer le jeu
function demarrerJeu() {
    $niveauxDifficulte = ["Facile", "Difficile", "Impossible"];
    $difficulte = $niveauxDifficulte[array_rand($niveauxDifficulte)];

    // Choix du personnage aléatoire
    $personnage = choisirPersonnageAleatoire();
    echo " Vous avez choisi " . $personnage->name . " comme personnage ";
    echo "<br>";
    echo "Vous commencez avec " . $personnage->marbles . " billes";
    echo "<br>";
    echo "Difficulté : " . $difficulte;
    echo "<br>";

    // Permet de définir le nombre de partie suivant la difficulté
    $partiesAJouer = ($difficulte == "Facile") ? 5 : (($difficulte == "Difficile") ? 10 : 20);

    // Boucle pour jouer le nombre de parties qui correspond à la difficulté
    for ($i = 1; $i <= $partiesAJouer; $i++) {
        $ennemy = choisirEnnemyAleatoire();
        $resultat = jouerPartie($personnage, $ennemy);

        if (!$resultat) {
            break;
        }

        echo "Vous avez maintenant " . $personnage->marbles . " billes";
        echo "<br>";

        // Si toutes les parties ont été jouées 
        if ($i == $partiesAJouer) {
            echo "Félicitations ! Vous avez complété tous les niveaux et conservé au moins une bille";
            echo "<br>";
            echo "Vous gagnez 45,6 milliards de Won sud-coréen";
        }
    }
}

// Démarrer le jeu
demarrerJeu();

?>
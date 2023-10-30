<?php
namespace Controllers;

class UserController extends Controller
{

    public function one($url)
    {
        $connectUser="Autre";
        //var_dump($url);
        echo $this->twig->render('data.html',['connectUser'=> $connectUser]);
    }
    public function list($url)
    {
        $db = new \PDO(
            'mysql:host=localhost;dbname=BTS_Mathea;charset=utf8',
            'mathea',
            'plop'
        );

        $dataStatut = $db->prepare  ('
                                        SELECT user.id, user.nom, user.prenom, villes_france_free.ville_nom AS ville_id
                                        FROM user
                                        INNER JOIN villes_france_free ON user.ville_id = villes_france_free.id;
                                    ');
        $dataStatut->execute();
        $datas=$dataStatut->fetchAll();
        
        echo $this->twig->render('users.html', ['users' => $datas]);

    }

    public function create(){
        $db = new \PDO(
            'mysql:host=localhost;dbname=BTS_Mathea;charset=utf8',
            'mathea',
            'plop'
        );
        $requeteVille = $db->prepare("SELECT id, ville_nom FROM villes_france_free LIMIT 20");
        $requeteVille->execute();
        $villes = $requeteVille->fetchAll();
        
        echo $this->twig->render('create.html', ['villes' => $villes]);
    }

    public function insert(){

	    if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
            $nom = $_POST["user_nom"]; 
            $prenom = $_POST["user_prenom"];
            $villeID = $_POST["ville_id"];

            if (!isset($nom, $prenom, $villeID)){
                die("S'il vous plaît rentrez toutes les informations.");
            }
            //Ouvrir une nouvelle connexion au serveur MySQL
            try {
                $db = new \PDO(
                    'mysql:host=localhost;dbname=BTS_Mathea;charset=utf8',
                    'mathea',
                    'plop'
                );
            }
            catch (Exception $e){
                die("Erreur : ".$e->getMessage());
            }

            $statement = $db->prepare("INSERT INTO user (nom, prenom, ville_id) VALUES (:nom, :prenom, :ville_id)");
            $statement->bindParam(':nom', $nom);
            $statement->bindParam(':prenom', $prenom);
            $statement->bindParam(':ville_id', $villeID);

            $result = $statement->execute() ? "Le formulaire a bien été envoyé" : "Échec de l'envoi du formulaire";
            echo $result;
        }
    }
}

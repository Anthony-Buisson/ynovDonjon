<?php

function getPseudo()
{
    if (isset($_GET["pseudo"])) {
        return $_GET["pseudo"];
    }
}

function getMethod()
{
    if (isset($_GET["method"])) {
        return $_GET["method"];
    } else return "GET";
}

function getPassword()
{
    if (isset($_GET["password"])) {
        return $_GET["password"];
    }
}

function getUrl()
{
    if (isset($_GET["url"])) {
        return $_GET["url"];
    }
}

function getFloor()
{
    if (isset($_GET["port"])) {
        switch ($_GET["port"]) {
            case 8000:
                return ":8000";
            case 7259:
                return ":7259";
            default:
                return "";
        }
    }
}

function getRequest()
{
    return  getMethod() . " 141.95.153.155" . getFloor() . "/" . getUrl();
}


function getToken()
{
    $id = getPseudo();
    $pwd = getPassword();

    $url = "141.95.153.155" . getFloor() . "/inscription";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERPWD, "$id:$pwd");
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $response = curl_exec($ch);
    $token = substr($response, 60, 40);
    curl_close($ch);
    return $token;
}

function parseHTML($text, $node)
{
    $node .= "<p>" . $text . "</p>";
    return $node;
}

function regularGet()
{

    $dest = "/" . getUrl();

    $url = "141.95.153.155" . getFloor() . $dest;
    $headers = array("X-Auth-Token: " . getToken());
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, getMethod());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "idempotent");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);
    if (is_null(json_decode($response))) {
        $values = [$response];
    } else {
        if (gettype(json_decode($response, true)) == "array") {
            $values = array_values(json_decode($response, true));
        } else {
            $values = $response;
        }
    }
    $html = "";
    foreach ($values as $value) {
        if (is_string($value)) {
            $html .= "<p>" . $value . "</p><br/>";
        }
        if (is_array(($value))) {
            $html .= '<ul>';
            foreach ($value as $value) {
                $html .= "<li>" . $value . "</li>";
            }
            $html .= "</ul>";
        }
    }
    return ($html);
}

function getScore()
{
    $id = getPseudo();
    $pwd = getPassword();

    $url = "141.95.153.155" . getFloor() . "/reset";
    $headers = array("X-Auth-Token: " . getToken($id, $pwd));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);
    $html = "";
    $html .= '<ul class="coffre-content-list">';
    foreach (array_values(json_decode($response, true))[2] as $value) {

        $html .= "<div class='coffre-content-list-item'><div class='tresor'><img  src='./images/tresor.png'></img></div> <li>" . $value . "</li></div>";
    }
    $html .= "</ul>";
    return $html;
}

function getThisThing()
{
    $url = "141.95.153.155";
}

function getComment()
{
    $fusion = getFloor();
    $fusion .= getUrl();
    switch ($fusion) {
        case "inscription":
            return "Entrez un identifiant et un mot de passe dans les headers. <br/><br/> Le header de réponse contient un token qui permet de s'identifier. <br/><br/> Sur cette interface tout est fait automatiquement en fond mais un token différent est distribué à chaque étage !";
            break;
        case "reset":
            return "Les coffres à trouver, indiqués via un appel à une route, ainsi que la date de début sont marqués dans les instructions ci-dessous.";
            break;
        case "escalier":
            return "Chaque étage répond à un port différent et on découvre le suivant ici. <br/><br/> Pour simplifier le système, l'interface permet de changer le port en fonction de l'étage auquel on souhaite accéder.";
            break;
        case "coffre":
            return "Ce message est codé en AES pour Advanced Encryption Standard, un mode d'encryption très utilisé et reconnu.<br/><br/> Il serait utilisé par de nombreuses institutions et entreprises dont Apple et le FBI. <br/><br/> L'encodage se fait via une clé qui agit comme un mot de passe et il est nécessaire pour décoder le message. <br/><br/> L'inventeur de REST est Roy Fielding et son nom est le mot de passe qui permet de découvrir la route /36 qui donne accès à un nouveau coffre !";
            break;
        case "36":
            return "Bien joué !";
            break;
        case "premier":
            return "Premier coffre trouvé ! Continue comme ça !";
            break;
        case "tresor":
            return "Et pas ceux de Kellogg's !";
            break;
        case ":8000":
            return "Sur cet étage, on utilise deux nouvelles méthodes POST et PUT qui permettent toutes deux d'entrer des données en base.";
            break;
        case ":8000inscription":
            return "La même chose qu'au premier étage sauf que le token est différent.";
            break;
        case ":8000reset":
            return "Les coffres à trouver, indiqués via un appel à une route, ainsi que la date de début sont marqués dans les instructions ci-dessous.";
            break;
        case ":8000escalier":
            return "Chaque étage répond à un port différent et on découvre le suivant ici. <br/><br/> Pour simplifier le système, l'interface permet de changer le port en fonction de l'étage auquel on souhaite accéder.";
            break;
        case ":8000vieux":
            return 'Il existe une différence fondamentale entre POST et PUT est celle-ci est que POST est une méthode idempotente !<br/><br/> Ce mot signifie que quoiqu\'il arrive, une requête POST entrainera toujours la même action. <br/> En entrant le mot "idempotent" avec une requête POST, on obtient un coffre !<br/><br/>Mais que se passe-t-il si l\'on essaie une nouvelle fois ? Eh bien un coffre apparait encore ! <br/>Au passage la requête PUT remplace une donnée si elle est déjà existante et entraine donc une étape de vérification !';
            break;
        case ":8000note":
            return "C'était simple et juste sous notre nez mais au premier étage (au port par défaut) se trouve un coffre au... /tresor !";
            break;
        case ":8000couloir":
            return "Nous ne sommes pas obligés de nous limiter à /couloir. En allant plus loin vers /couloir/1...";
            break;
        case ":8000couloir/1":
            return "...nous nous retrouvons en effet sur un coffre !";
            break;

        case ":7259":
            return "Le dernier étage avec un... dragon ?!<br/><br/> Une dernière méthode est disponible sur l'interface, vous souvenez-vous de laquelle ?";
            break;
        case ":7259dragon":
            return "Encore un conseil avisé. Mais que se passerait-il si nous utilisions la méthode DELETE ?<br/><br/> Cette méthode comme son nom l'indique sert à supprimer des ressources ou... des dragons. Cependant le plus souvent la supression n'en est pas une au sens propre !<br/><br/> La plupart du temps une supression vaut simplement la supression de l'accès à la ressource mais elle reste en mémoire pour des besoins de comptabilité ou légaux. Ce dragon attendra le prochain utilisateur !";
            break;


        default:
            return "Nous avons une carte, des routes à mettre dans l'url et des instructions ! En haut à droite, nous avons les requêtes à tester et dans le cadre ci-dessus la requête envoyée ainsi que sa réponse.<br/><br/> Seule la méthode GET est utilisée l'étage 0.";
            break;
    }
}

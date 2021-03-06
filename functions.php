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
            return "Entrez un identifiant et un mot de passe dans les headers. <br/><br/> Le header de r??ponse contient un token qui permet de s'identifier. <br/><br/> Sur cette interface tout est fait automatiquement en fond mais un token diff??rent est distribu?? ?? chaque ??tage !";
            break;
        case "reset":
            return "Les coffres ?? trouver, indiqu??s via un appel ?? une route, ainsi que la date de d??but sont marqu??s dans les instructions ci-dessous.";
            break;
        case "escalier":
            return "Chaque ??tage r??pond ?? un port diff??rent et on d??couvre le suivant ici. <br/><br/> Pour simplifier le syst??me, l'interface permet de changer le port en fonction de l'??tage auquel on souhaite acc??der.";
            break;
        case "coffre":
            return "Ce message est cod?? en AES pour Advanced Encryption Standard, un mode d'encryption tr??s utilis?? et reconnu.<br/><br/> Il serait utilis?? par de nombreuses institutions et entreprises dont Apple et le FBI. <br/><br/> L'encodage se fait via une cl?? qui agit comme un mot de passe et il est n??cessaire pour d??coder le message. <br/><br/> L'inventeur de REST est Roy Fielding et son nom est le mot de passe qui permet de d??couvrir la route /36 qui donne acc??s ?? un nouveau coffre !";
            break;
        case "36":
            return "Bien jou?? !";
            break;
        case "premier":
            return "Premier coffre trouv?? ! Continue comme ??a !";
            break;
        case "tresor":
            return "Et pas ceux de Kellogg's !";
            break;
        case ":8000":
            return "Sur cet ??tage, on utilise deux nouvelles m??thodes POST et PUT qui permettent toutes deux d'entrer des donn??es en base.";
            break;
        case ":8000inscription":
            return "La m??me chose qu'au premier ??tage sauf que le token est diff??rent.";
            break;
        case ":8000reset":
            return "Les coffres ?? trouver, indiqu??s via un appel ?? une route, ainsi que la date de d??but sont marqu??s dans les instructions ci-dessous.";
            break;
        case ":8000escalier":
            return "Chaque ??tage r??pond ?? un port diff??rent et on d??couvre le suivant ici. <br/><br/> Pour simplifier le syst??me, l'interface permet de changer le port en fonction de l'??tage auquel on souhaite acc??der.";
            break;
        case ":8000vieux":
            return 'Il existe une diff??rence fondamentale entre POST et PUT est celle-ci est que POST est une m??thode idempotente !<br/><br/> Ce mot signifie que quoiqu\'il arrive, une requ??te POST entrainera toujours la m??me action. <br/> En entrant le mot "idempotent" avec une requ??te POST, on obtient un coffre !<br/><br/>Mais que se passe-t-il si l\'on essaie une nouvelle fois ? Eh bien un coffre apparait encore ! <br/>Au passage la requ??te PUT remplace une donn??e si elle est d??j?? existante et entraine donc une ??tape de v??rification !';
            break;
        case ":8000note":
            return "C'??tait simple et juste sous notre nez mais au premier ??tage (au port par d??faut) se trouve un coffre au... /tresor !";
            break;
        case ":8000couloir":
            return "Nous ne sommes pas oblig??s de nous limiter ?? /couloir. En allant plus loin vers /couloir/1...";
            break;
        case ":8000couloir/1":
            return "...nous nous retrouvons en effet sur un coffre !";
            break;

        case ":7259":
            return "Le dernier ??tage avec un... dragon ?!<br/><br/> Une derni??re m??thode est disponible sur l'interface, vous souvenez-vous de laquelle ?";
            break;
        case ":7259dragon":
            return "Encore un conseil avis??. Mais que se passerait-il si nous utilisions la m??thode DELETE ?<br/><br/> Cette m??thode comme son nom l'indique sert ?? supprimer des ressources ou... des dragons. Cependant le plus souvent la supression n'en est pas une au sens propre !<br/><br/> La plupart du temps une supression vaut simplement la supression de l'acc??s ?? la ressource mais elle reste en m??moire pour des besoins de comptabilit?? ou l??gaux. Ce dragon attendra le prochain utilisateur !";
            break;


        default:
            return "Nous avons une carte, des routes ?? mettre dans l'url et des instructions ! En haut ?? droite, nous avons les requ??tes ?? tester et dans le cadre ci-dessus la requ??te envoy??e ainsi que sa r??ponse.<br/><br/> Seule la m??thode GET est utilis??e l'??tage 0.";
            break;
    }
}

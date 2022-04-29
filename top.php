<div class="top">
    <div class="left">
        <h2>Paramètres</h2>
        <div>Identifiant : <input name="pseudo" value="<?php echo getPseudo() ?>"></div>
        <div>Mot de passe : <input name="password" value="<?php echo getPassword() ?>"></div>
        <div>Etage :
            <select name="port" id="portForm" onchange="checkPort()" >
                <option <?php if(getFloor() == "") {echo "selected";} ?> value="">0</option>
                <option <?php if(getFloor() == ":8000") {echo "selected";} ?> value="8000">1</option>
                <option <?php if(getFloor() == ":7259") {echo "selected";} ?> value="7259">2</option>
            </select>
        </div>
    </div><div class="right">
        <h2>Requête :</h2>
        <div id="gauche-contenu">
            <select name="method" id="method">
                <option <?php if(getMethod() == "GET") {echo "selected";}?> value="GET">GET</option>
                <option <?php if(getMethod() == "POST") {echo "selected";}?> value="POST">POST</option>
                <option <?php if(getMethod() == "PUT") {echo "selected";}?> value="PUT">PUT</option>
                <option <?php if(getMethod() == "DELETE") {echo "selected";}?> value="DELETE">DELETE</option>
            </select>
            <div id="port"></div>
            <input name="url" id="urlInput" value="<?php echo getUrl() ?>" onkeydown="enter(this.value)">
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" id="boutonEntree" value="↩">
        </div>
    </div>
</div>

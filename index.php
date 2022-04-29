<html>
<link rel="stylesheet" href="reset.css">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="top.css">
<link rel="stylesheet" href="help.css">
<link rel="stylesheet" href="coffre.css">
<?php
include "functions.php";


?><form action="index.php" method="GET">
    <?php include "top.php" ?>
    <?php include "help.php" ?>
    <div class="coffre-note">
        <?php include "coffre.php" ?>
        <?php include "note.php" ?>
    </div>

</form>

</html>

<script>
    function checkPort() {
        switch (document.getElementById("portForm").value) {
            case "8000":
                document.getElementById("port").innerHTML = "141.95.153.155:8000/"
                break;
            case "7259":
                document.getElementById("port").innerHTML = "141.95.153.155:7259/"
                break;
            default:
                document.getElementById("port").innerHTML = "141.95.153.155/"
                break;
        }
    }
    checkPort()

    let check = "s"

    function enter(value) {
        if (check == value) {
            document.getElementById("boutonEntree").click
            console.log("dd")
        }
        check = value
    }

    function setFocus() {
        document.getElementById("urlInput").focus()
    }
    setFocus()
</script>
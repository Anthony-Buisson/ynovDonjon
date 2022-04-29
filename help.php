<div id="content-button">
    <div id="help-button">Aide</div>
</div>

<div id="help-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="header-comment" class="header">Mode de fonctionnement</div>
      <div class="content-comment">
          <div>
          <div class="margin"></div>
            <h2>Mode de fonctionnement</h2>
            <div class="margin"></div>
            <p>Saisir identifiant et mot de passe pour s'inscrire, ces identifiants seront automatiquement utilisés dans les headers des requêtes.</p>
            <div class="margin"></div>
            <p>Changer d'étage correspond à changer le port utilisé pour les requêtes.</p>
          </div>
      </div>
      <div class="margin"></div>
      <div class="content-comment">      
          <div>
            <h2>Commentaire</h2>
            <div class="margin"></div>
            <?php echo getComment() ?>
          </div>
      </div>
  </div>
</div>

<script>
// Get the modal
var modal = document.getElementById("help-modal");

// Get the button that opens the modal
var btn = document.getElementById("help-button");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

<div id="content-button">
    <button id="help-button">Aide</button>
</div>

<div id="help-modal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="header-comment" class="header">Mode d'emploi</div> 
    <div id="content-comment"><?php echo getComment() ?></div>
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
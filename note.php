<link rel="stylesheet" href="note.css">

<div class="note">

    <div class="response">
        <div class="header">Instruction :</div>
        <div>
            <div id="oldRequest"><?php echo (getRequest()) ?></div>
            <?php echo (regularGet()); ?>
        </div>
    </div>


    <div class="aide">
        <div class="header">Aide :</div>
        <div class="hidden"><?php echo getComment() ?></div>
        <span class="aide-info">Survol moi pour avoir de l'aide</span>
    </div>

</div>
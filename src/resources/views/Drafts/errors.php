<?php if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
<?php endif ?>



<!-- JS -->
<script type="text/javascript">
        <?php if ( empty($login_check) ) { ?>
            var login_val = 0;
        <?php } else { ?>
            var login_val = JSON.stringify( {!! $login_check !!} );
            login_val = JSON.parse(login_val);
        <?php } ?>
        
        if (login_val === 1) { // successful login message
            //<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            
            $(".alert").append("<strong>You are now logged in.</strong>");
            $(".alert").show();
        }
    </script>
var close = $("<a></a>").attr({
                href: "#",
                class: "close",
                data-dismiss: "alert",
                aria-label: "close"
                }).text("&times");
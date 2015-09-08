


<span class="popup-close" onclick="auth_close();
                        return false;">Закрити</span>



<div class="nd-popup-head">
    На вашу електронну пошту <?php echo $post['email']; ?> <br/>надіслано підтвердження
</div>



<?php print_r('errors');?><?php if(isset($model)){ echo ($model->errors);}?>






<span class="popup-close" onclick="auth_close();
                        return false;">Закрити</span>

<?php if (empty($model->errors)):?>
    <script>
        function popapClose_(){
            $('.popup').fadeOut(250);
            $('.popup_holder').fadeOut(250);
            $('body').removeClass('hold');
            $(location).attr('href','/');
        }

        var msg1 = "email=<?php echo $post['email']; ?>";
//var msg1 = 'email=test&token=token';
        $.ajax({
            type: 'POST',
            url: 'send.html',
            data: msg1,
            success: function (data) {
                popapClose_();
            },
            error: function (xhr, str) {
                alert('Возникла ошибка: ' + xhr.responseCode);
                popapClose_();
            }
        });
    </script>
<div class="nd-popup-head">
    На вашу електронну пошту <?php echo $post['email']; ?> <br/>надіслано підтвердження
</div>
<?php else :?>


<?php print_r('errors');?><?php if(isset($model)){ echo ($model->errors);}?>

<?php endif; ?>

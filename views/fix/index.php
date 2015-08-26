
<div class="popup_holder_ animate">
    <div class="popup_wrap">

        <div class="popup__in">
            <div class="popup popup_auth">

                <h3>Обери профіль <br/>для авторизації:</h3>

                <?php echo \nodge\eauth\Widget::widget(array('action' => 'fix/social-login')); ?>

                <span class="popup-close" onclick="auth_close();
                        return false;">Закрити</span>
            </div><!--.popup_auth-->
        </div>

        <div class="popup_layer"></div>

    </div><!--.popup_wrap-->
</div><!--.popup_holder-->
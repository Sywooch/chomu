<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii2-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\models\eauth\fix;

class FacebookOAuth2Service extends \nodge\eauth\services\FacebookOAuth2Service
{

    /**
     * http://developers.facebook.com/docs/reference/api/user/
     *
     * @see FacebookOAuth2Service::fetchAttributes()
     */
    protected function fetchAttributes()
    {
        //$this->attributes = $this->makeSignedRequest('me');
        $this->attributes = $this->makeSignedRequest('me', array(
            'query' => array(
                //'uids' => $tokenData['params']['user_id'],
                //'fields' => '', // uid, first_name and last_name is always available
                'fields' => implode(',', [
                    'id',
                    'name',
                    //self::SCOPE_EMAIL,
                    self::SCOPE_USER_PHOTOS,
                    //'photos'
                    ]
                ),
            ),
        ));

        return true;
    }
}
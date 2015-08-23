<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii2-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace app\models\eauth;

class FacebookOAuth2Service extends \nodge\eauth\services\FacebookOAuth2Service
{

	protected $scopes = array(
		'email', 'first_name', 'last_name'
	);

	/**
	 * http://developers.facebook.com/docs/reference/api/user/
	 *
	 * @see FacebookOAuth2Service::fetchAttributes()
	 */
	protected function fetchAttributes()
	{
		$this->attributes = $this->makeSignedRequest('me');
		return true;
	}
}

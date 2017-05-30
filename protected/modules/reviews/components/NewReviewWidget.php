<?php
	class NewReviewWidget extends CWidget {
		
		public $visible = true;
		
		public function run() {
			
			if(!$this->visible)
			return;
			
			$model = new Reviews;
			
			if(isset($_POST['Reviews'])) {
				function recaptcha($recaptcha)
				{
					if(!empty($recaptcha))
					{
						function getCurlData($url)
						{
							$curl = curl_init();
							curl_setopt($curl, CURLOPT_URL, $url);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl, CURLOPT_TIMEOUT, 10);
							curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
							$curlData = curl_exec($curl);
							curl_close($curl);
							return $curlData;
						}
						$google_url = "https://www.google.com/recaptcha/api/siteverify";
						$ip = $_SERVER['REMOTE_ADDR'];
						$url = $google_url."?secret=6LfA_yIUAAAAAD0gBVtliTkfJNxeLvEBkZhIiBvZ&response=".$recaptcha."&remoteip=".$ip;
						$res = getCurlData($url);
						$res = json_decode($res, true);
						//reCaptcha введена
						if($res['success'])
						{
							return true;
						}
						else
						{
							return false;
						}
						
					}
					else
					{
						return false;
					}
				}
				
				$model->attributes = $_POST['Reviews'];
				$model->scenario = 'user_question';
				if(recaptcha($_POST['g-recaptcha-response']))
				{
					if($model->isNewRecord) {
						$model->status = Reviews::STATUS_PENDING;
						$model->visible = Reviews::STATE_HIDDEN;
					}
					
					if ($model->save()) {
						Yii::app()->user->setFlash('reviews', 'Отзыв успешно отправлен');
						$this->getOwner()->refresh();
					}
					}else{
					Yii::app()->user->setFlash('reviews', 'Вы не прошли проверку');
					$this->getOwner()->refresh();
				}
			}
			
			$this->render('newReview', array('model'=>$model));
		}
	}			
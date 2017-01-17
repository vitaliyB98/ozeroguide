<?php
	class Widget {
		static public function Weather () {
			echo "
				<div class = 'weather'>
					<div id='SinoptikInformer' style='width:300px;' class='SinoptikInformer type4c1'>
						<div class='siHeader'>
							<div class='siLh'>
								<div class='siMh'>
									<a onmousedown='siClickCount();' class='siLogo' href='https://ua.sinoptik.ua/' target='_blank' rel='nofollow' title='Погода'></a>
									Погода 
								</div>
							</div>
						</div>
						<div class='siBody'>
							<div class='siTitle'>
								<span id='siHeader'></span>
							</div>
							<a onmousedown='siClickCount();' href='https://ua.sinoptik.ua/погода-ківерці' title='Погода у Ківерцях' target='_blank' rel='nofollow'>
							<div class='siCity'>
								<div class='siCityName'>Погода в <span>Озері</span></div>
								<div id='siCont0' class='siBodyContent'>
									<div class='siLeft'>
										<div class='siTerm'></div>
										<div class='siT' id='siT0'></div>
										<div id='weatherIco0'></div>
									</div>
								</div>
							</div>
							</a>
							<div class='siLinks'>Погода на <a href='https://ua.sinoptik.ua/погода-київ/10-днів/' title='Погода у Києві на 10 днів' target='_blank' rel='nofollow' onmousedown='siClickCount();'>sinoptik.ua</a>  у Донецьку
							</div>
						</div>
						<div class='siFooter'>
							<div class='siLf'>
								<div class='siMf'>	
								</div>
							</div>
						</div>
					</div><script type='text/javascript' charset='UTF-8' src='//sinoptik.ua/informers_js.php?title=3&amp;wind=2&amp;cities=303010776&amp;lang=ua'></script>
				</div>
			";
		}

		static public function PopularNews () {
			$DBH = DB::Connect();
			$STH = $DBH->query("SELECT `id`,`title`,`date` FROM `news` ORDER BY `views` DESC LIMIT 3");
			$STH->setFetchMode(PDO::FETCH_ASSOC); 

  			while ($row = $STH->fetch()) {
  				$list[] = $row;
  			}

  			if ( $list == NULL ) {
  				echo "Тут пусто";
  				return 0;
  			}

			foreach ($list as $value) {
				$date = date('Y.m.d   H:i', $value['date']);

				echo "
					<a href = '/news/view?id={$value['id']}' class = 'news-title-reference'>{$value['title']}</a>
					<div class = 'date'>$date</div>
					<hr>
				";	
			}
			
		}

		static public function TwoRandomNews ($table) {
			$DBH = DB::Connect();
			$STH = $DBH->query("SELECT `id`,`title`,`date` FROM `$table` ORDER BY RAND() DESC LIMIT 2");
			$STH->setFetchMode(PDO::FETCH_ASSOC); 

  			while ($row = $STH->fetch()) {
  				$list[] = $row;
  			}

  			if ( $list == NULL ) {
  				echo "Тут пусто";
  				return 0;
  			}

			foreach ($list as $value) {
				$date = date('Y.m.d   H:i', $value['date']);

				echo "
					<a href = '/$table/view?id={$value['id']}' class = 'news-title-reference'>{$value['title']}</a>
					<div class = 'date'>$date</div>
					<hr>
				";	
			}
		}

		static public function RandomNews () {
			
			Widget::TwoRandomNews('news');
			Widget::TwoRandomNews('interest');
			
		}
		
		static public function VKShare ( $image ) {
			$url = Widget::getUrl();

			echo "
				<div class = 'VKShare'>
				<script type='text/javascript' src='http://vk.com/js/api/share.js?90' charset='windows-1251'></script>
				<script type='text/javascript'>
				document.write(VK.Share.button({
					url: '$url',
		  			image: 'http://shop1/images/$image',
				}));
				</script>
				</div>
			";
			
		}

		static public function FacebookShare () {
			$url = Widget::getUrl();

			echo "
				<div class = 'facebookShare'>
				<a name='fb_share' type='button_count' share_url = '$url'>Поділитися</a>
				<script src='https://www.facebook.com/connect.php/js/FB.Share' type='text/javascript'></script>
				</div>
			";
		}

		static public function getUrl () {
			$url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
			$url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
			$url .= $_SERVER["REQUEST_URI"];
			return $url;		
		}

		static public function VKPublic () {
			echo "
				<script type='text/javascript' src='//vk.com/js/api/openapi.js?136'></script>

				<!-- VK Widget -->
				<div id='vk_groups'></div>
				<script type='text/javascript'>
				VK.Widgets.Group('vk_groups', {mode: 3, width: '300', color1: 'blue'}, 135762411);
				</script>
			";
		}

		static public function Metrica () {
			echo "
				<div class = 'metrika'>
					<a href='https://metrika.yandex.ru/stat/?id=41748394&amp;from=informer'target='_blank' rel='nofollow'>
					<img src='https://informer.yandex.ru/informer/41748394/3_0_B9B9B9FF_999999FF_0_visits'style='width:88px; height:31px; border:0;'' alt='Яндекс.Метрика' title='Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)' class='ym-advanced-informer' data-cid='41748394' data-lang='ru' />
					</a>
				</div>
			";
		}

		static public function MetricaCounter () {
			echo "
				<script type='text/javascript'>
    				(function (d, w, c) {
				        (w[c] = w[c] || []).push(function() {
				            try {
				                w.yaCounter41748394 = new Ya.Metrika({
				                    id:41748394,
				                    clickmap:true,
				                    trackLinks:true,
				                    accurateTrackBounce:true,
				                    webvisor:true
				                });
				            } catch(e) { }
				        });

				        var n = d.getElementsByTagName('script')[0],
				            s = d.createElement('script'),
				            f = function () { n.parentNode.insertBefore(s, n); };
				        s.type = 'text/javascript';
				        s.async = true;
				        s.src = 'https://mc.yandex.ru/metrika/watch.js';

				        if (w.opera == '[object Opera]') {
				            d.addEventListener('DOMContentLoaded', f, false);
				        } else { f(); }
				    })(document, window, 'yandex_metrika_callbacks');
				</script>
				<noscript><div><img src='https://mc.yandex.ru/watch/41748394' style='position:absolute; left:-9999px;'' alt='' /></div></noscript>
			";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="ru" class="no-js ie7 index"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="ru" class="no-js ie8 index"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="ru" class="no-js ie9 index"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html dir="ltr" lang="ru" class="no-js index"><!--<![endif]-->
<head>
<?php
        $assetManager = Yii::app() -> assetManager;
        $baseUrl = $assetManager -> publish(Yii::getPathOfAlias('webroot.themes.classic.assets'));

        $clientScript = Yii::app() -> clientScript;
        $clientScript//->registerCoreScript('jquery')
					 ->registerCoreScript('jquery.ui')
                     //->registerCssFile($baseUrl . '/css/styles.css')
                     ->registerCssFile($baseUrl . '/js/colorbox/colorbox.css')
					 ->registerCssFile($clientScript->getCoreScriptUrl(). '/jui/css/base/jquery-ui.css')
                     //->registerCssFile($baseUrl . '/css/bootstrap.min.css')
					 ->registerCssFile($baseUrl . '/js/ui/jquery-ui-1.8.21.custom.css')
					 ->registerCssFile($baseUrl . '/js/Ctimepiker/jquery-ui-timepicker-addon.css')
					 ->registerCssFile($baseUrl . '/css/reset.css')
					 ->registerCssFile($baseUrl . '/css/common.css')
					 ->registerCssFile($baseUrl . '/css/layout.css')
					 ->registerCssFile($baseUrl . '/css/slider.css')
					 ->registerCssFile($baseUrl . '/css/styles-low-wision.css')

                     ->registerScriptFile($baseUrl . '/js/colorbox/jquery.colorbox.js')
					 ->registerScriptFile($baseUrl . '/js/ui/jquery-ui-1.8.21.custom.min.js')
                     ->registerScriptFile('http://maps.api.2gis.ru/1.0')
					 ->registerScriptFile($baseUrl . '/js/Ctimepiker/jquery-ui-timepicker-addon.js')
					 ->registerScriptFile($baseUrl . '/js/Ctimepiker/localization/jquery-ui-timepicker-ru.js')
                     ->registerScriptFile($baseUrl . '/js/script.js')
					// ->registerScriptFile($baseUrl . '/js/jquery-1.7.2.min.js')
					 ->registerScriptFile($baseUrl . '/js/mobilyslider.js')
					 ->registerScriptFile($baseUrl . '/js/jquery.tools.min.js')
                     ->registerScriptFile($baseUrl . '/js/cufon-yui.js')
                     ->registerScriptFile($baseUrl . '/js/jquery.cookie.js')
                     ->registerScriptFile($baseUrl . '/js/low_vision.js')
					 ->registerScriptFile($baseUrl . '/js/main.js')
                      ->registerScriptFile('https://www.google.com/recaptcha/api.js')
                     /* ->registerScriptFile($baseUrl . '/js/capcha.js')*/
                     ->registerMetaTag('text/html; charset=utf-8', null, 'Content-Type', null)
                     ->registerMetaTag($this->clips['keywords'], 'Keywords')
                     ->registerMetaTag($this->clips['description'], 'Description')
         ;
        echo CHtml::tag('title', array(), $this->pageTitle);
        echo CHtml::linkTag('shortcut icon', 'image/x-icon', '/favicon.ico');
        echo CHtml::linkTag('icon', 'image/x-icon', '/favicon.ico');
    ?>
</head>
<body class="front">
<div class="wrapper">
<div id="CecutientWrapper">

  <div id="CecutientBlock">
        <span>
          Изображения:
          <a id="ImageOn" class="button">Выкл</a>
          <a id="ImageOff" class="button">Вкл</a>
        </span>
    <span>
          Шрифт:
          <a id="SmallFonts" class="button">A</a>
          <a id="MediumFonts" class="button">A</a>
          <a id="BigFonts" class="button">A</a>
        </span>
    <span>
          Цвет:
          <a id="WhiteStyle" class="button">A</a>
          <a id="BlackStyle" class="button">A</a>
          <a id="BlueStyle" class="button">A</a>
          <a id="GreenStyle" class="button">A</a>
        </span>

    <a id="CecutientOff1"><span class="img"></span>Обычная версия</a>
  </div>

</div>

 

<!--  END CecutientBtn__wrap-->

	<!-- MENU TOP -->
	<div class="main_menu cf">
		<?php $this->widget('pages.components.Menu', array('view'=>'mainMenu', 'level'=>'2')); ?>
		<div class="header-search">
		    <input type="text" class="input-search-header" id="header-search" name="header-search" placeholder="Поиск">
			<label for="header-search" class="label-header-search">
			<i class="icon-search"></i>
		    </label>
		</div>
	</div>
	<?php //$this->widget('SiteSearch'); ?>
	<!-- end MENU TOP -->
    <div class="header cf">
		<ul class="menu-list">
		<li>
			<?php if ($_SERVER['REQUEST_URI'] != '/') echo "<a href = '/'>"; ?>
			<div class="slogan pfdintextcondpro">Здоровая семья<br><span>начинается с тебя!</span></div>
			<div class="logo">БУЗ УР «Республиканский кожно-венерологический диспансер МЗ УР» г. Ижевск</div>
			<?php if ($_SERVER['REQUEST_URI'] != '/') echo "</a>"; ?>
		</li>
		
		<li>
			<div class="one-block adress vcard">
			<!--  ADRESS -->
				<div class="fn org hidden">БУЗ УР «Республиканский кожно-венерологический диспансер МЗ УР»</div>
				<span class="tel hidden"><span class="type">work</span><span class="value">+7 (3412) 68-32-08</span></span>

				<div class="adress-top"><span class="adr"><span class="region">Ижевск</span>, <a href="/map" class="ajax">ул. Ленина, 100</a></span></div>
                <div class="clear"></div>
				<div class="working cf">
					<div class="working-name">Режим<br>работы</div>
					<div class="working-time">Пн–пт: 8–18<br>Сб: 8–14<br><span class="weekend">Вс: выходной</span></div>
				</div>
			<!--  end ADRESS -->
			</div>
		</li>
        
		<li>
			<div class="one-block phone">
			<!--  PHONE -->
				<div class="phone-top cf"><span class="pfdintextcondpro phone-name">СПРАВОЧНАЯ</span>+7&nbsp;(3412)</div>
				<div class="phone-num pfdintextcondpro">68-32-08</div>
			<!--  end PHONE -->
			</div>
		</li>
		
		<li class="CecutientBtn__wrap">
			<a href="http://lenina100.picom.su/" class="CecutientBtn" id="CecutientOn" title="Версия для слабовидящих" alt="Версия для слабовидящих">
			    <span class="img"></span>Версия для слабовидящих
			</a>


			<a href="http://lenina100.picom.su/" class="CecutientBtn" id="CecutientOff" title="Версия для слабовидящих" alt="Версия для слабовидящих">
			    <span class="img"></span>Обычная версия
			</a>

		</li>
		
		<li class="last">
			<div class="one-block buttons">
				<a href="/write" class="faq button cboxForm red front"><center>Запишитесь <br /> на приём</center></a>
			</div>
			<div class="one-block buttons link_message">
				<a href="/message" class="faq button cboxForm front"><center>Задайте вопрос <br /> специалисту</center></a>
			</div>
		</li>
		<li class="helper"></li>
		</ul>
	</div>
	
	<!-- MENU -->
	<div class="menu">
		<?php $this->widget('pages.components.CategoryMenu'); ?>
	</div>
	<!--  end MENU -->
        
	<div class="content cf">
			
		<?php echo $content; ?>

	</div> <!-- End of content_area -->
	
	<!--  SLIDE BANNERS  -->
	<div class="slider-banners">
		<div class="scrollable" id="scrollable">
			<?php $this->widget('banner.components.BannerWidget'); ?>
		</div>
		<a class="prev browse left"> </a>
		<a class="next browse right"> </a>
	</div>

	<!--  BANNERS  -->
	<div class="banners">
		<ul class="menu-list">
			<center>
			<li>
				<a href ="http://gosuslugi.ru" style = "text-decoration:none;">
					<img src = "/themes/classic/assets/images/banners/1.png" alt = "1" style = "height: 60px"/>
				</a>
				<a href ="http://minzdravur.ru" style = "text-decoration:none;">
					<img src = "/themes/classic/assets/images/banners/2.png" alt = "1" style = "height: 60px"/>
				</a>
				<a href ="http://zdorovie.perm.ru" style = "text-decoration:none;">
					<img src = "/themes/classic/assets/images/banners/3.png" alt = "1" style = "height: 60px"/>
				</a>
				<a href ="http://rmcis.udmnet.ru" style = "text-decoration:none;">
					<img src = "/themes/classic/assets/images/banners/4.png" alt = "1" style = "height: 60px"/>
				</a>
      </li>
			</center>
		</ul>
	</div>
	<!--  end BANNERS  -->
        
</div><!-- End Of Container -->

<div class="bottom">
<div class="table_wrap">
	<table align="center" class="warning heliosct">
		<tr align="center">
			<td>И</td><td>м</td><td>е</td><td>ю</td><td>т</td><td>с</td><td>я</td><td style="width:15px;"></td><td>п</td><td>р</td><td>о</td><td>т</td><td>и</td><td>в</td><td>о</td><td>п</td><td>о</td><td>к</td><td>а</td><td>з</td><td>а</td><td>н</td><td>и</td><td>я</td><td>,</td><td style="width:15px;"></td><td>н</td><td>е</td><td>о</td><td>б</td><td>х</td><td>о</td><td>д</td><td>и</td><td>м</td><td>а</td><td style="width:15px;"></td><td>к</td><td>о</td><td>н</td><td>с</td><td>у</td><td>л</td><td>ь</td><td>т</td><td>а</td><td>ц</td><td>и</td><td>я</td><td style="width:15px;"></td><td>с</td><td>п</td><td>е</td><td>ц</td><td>и</td><td>а</td><td>л</td><td>и</td><td>с</td><td>т</td><td class="last">а</td>
		</tr>
	</table>
    <div class="line"></div>
    </div>
	<div class="footer cf">
		<div class="copy">
			&copy; 1941—<?php echo date('Y')?><br/>
			БУЗ УР «Республиканский кожно-венерологический диспансер МЗ УР» г. Ижевск<br />
			Лицензия № ФС-18-01-000688 от 21 июня 2012 года 
		</div>
		<div class="studio">
			<a href="http://www.3colors.ru/portfolio/sites" target="_blank">Создание сайта</a> — <br>Дизайн–студия «Три Цвета»
		</div>
	</div>
</div>
        <!-- {literal} --> 
        <script type='text/javascript'> 
            window['l'+'i'+'v'+'eTe'+'x'] = true, 
            window['liv'+'eTe'+'xI'+'D'] = 139338, 
            window['liveT'+'ex_obje'+'ct'] = true; 
            (function() { 
            var t = document['crea'+'te'+'Elem'+'ent']('script'); 
            t.type ='text/javascript'; 
            t.async = true; 
            t.src = '//cs15.l'+'ive'+'t'+'ex'+'.ru/js/clien'+'t'+'.js'; 
            var c = document['getEle'+'men'+'tsByTa'+'gN'+'ame']('script')[0]; 
            if ( c ) c['p'+'aren'+'tNod'+'e']['inse'+'rtBefo'+'re'](t, c); 
            else document['docume'+'n'+'tEleme'+'nt']['firs'+'tChil'+'d']['appen'+'dC'+'hil'+'d'](t); 
            })(); 
        </script> 
        <!-- {/literal} --> 
</body>
</html>
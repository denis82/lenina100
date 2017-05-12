$(document).ready(function(){ 

	$(".expert_box").colorbox({
	});
	
	$(".link_message button").colorbox({scrolling:false});   
	
$('#cboxLoadedContent form').live('submit', function(){
    $.post(
        $(this).attr('action'),
        $(this).serialize(),
        function(data){
            $.colorbox({
                html:data
            })
        }
    );
    return false;
})
	// $('#message_request').live('submit', function(){
    // $.ajax({
        // url:$(this).prop('action'),
        // data:$(this).serialize(),
        // dataType: 'json',
        // type:'POST',
        // context: this,
        // success: function(data) {
            // if (data.error) {
                // $(this).find('#message').html(data.error);
            // } else {
                // $(this).replaceWith(data.status);
            // }
        // $.colorbox.resize();
        // }
    // });
    // return false;
    // });
	
	$(".link_message a").colorbox({
		onComplete:function(){
			$('#message_appointment .datatime').datetimepicker();
			$('#message_appointment .date_picker').datepicker()	;
			$.datepicker.regional['ru'] = {
				closeText: 'Закрыть',
				prevText: '<Пред',
				nextText: 'След>',
				currentText: 'Сегодня',
				monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
				'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
				monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
				'Июл','Авг','Сен','Окт','Ноя','Дек'],
				dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
				dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
				dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
				weekHeader: 'Не',
				dateFormat: 'dd.mm.yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['ru']);

			$.timepicker.regional['ru'] = {
				timeOnlyTitle: 'Выберите время',
				timeText: 'Время',
				hourText: 'Часы',
				minuteText: 'Минуты',
				secondText: 'Секунды',
				millisecText: 'миллисекунды',
				currentText: 'Теперь',
				closeText: 'Закрыть',
				ampm: false
			};
			$.timepicker.setDefaults($.timepicker.regional['ru']);
            //$('#cboxClose').css({display:'none'});
		}
	});
	
	// $('#message_appointment').live('submit', function(){
    // $.ajax({
        // url:$(this).prop('action'),
        // data:$(this).serialize(),
        // dataType: 'json',
        // type:'POST',
        // context: this,
        // success: function(data) {
            // if (data.error) {
                // $(this).find('#appointment').html(data.error);
            // } else {
                // $(this).replaceWith(data.status);
            // }
        // $.colorbox.resize();
        // }
    // });
    // return false;
    // });
    
    $('.maplink').colorbox({
        //href: '/addresses .map',
        html:"<div id='myMapId' style='width:620px; height:450px;'></div>",
        onComplete:function(){
            loadMap('IzhevskMap');
            /*
             city = '';
             yandexMap(ymaps);
             * */
        }
    });
    
    //*************//
    $("a.more").parents(".item_photo").find("ul li:gt(4)").hide();
		$(".item_photo .more").click( function(event){
		event.stopPropagation();
		event.preventDefault();
		var more = $(this);
		var item = more.parents(".item_photo").find("ul").children("li");
		more.parents(".item_photo").find("ul li:gt(4)").slideToggle();
		moreText = jQuery(this).text();
		if (moreText == "Меньше фото") {
			more.text("Больше фото");
		} else {
			more.text("Меньше фото");
		}
	});

    $('.form_feedback input, .form_feedback textarea')
    .each(function(){
        if ( $(this).val() != '' ) $(this).prev().css('top', '-9999px');
    })
    .focus(function(){
        clean($(this));
    })
	
	// Окно с картой
  $('.adr a').colorbox({
    scrolling: false,
    onComplete : function() {
        loadMap('ajaxMap')
    }
  });
  
  $('input.error, textarea.error').live('change, keyup, keydown', function(e){
    $(this).removeClass('error');
  });
});


function clean(i) {
    l = i.prev();
    if ( !i.extended ) {
        i.blur(function(){
            if ( i.val() == '' ) l.css('top', '');
        })
        i.extended = true;
    }
    l.css('top', '-9999px')
}

function clearText(field)
{
	if (field.defaultValue == field.value) field.value = '';
	else if (field.value == '') field.value = field.defaultValue;
}

/* CartButton */
$('.CartButton form input').live('change', function(){
    $.get(
        '/cart/add?'+$(this).parents('form').serialize(), 
        function(){ window.location.reload();}
    )
})


/* MAPS */
var cities = {
    'IzhevskMap':{
        latitude:53.209934, 
        longitude:56.847632,
        title:'"Демо-версия"<br>Ижевск, ул. Свободы, 173'
    }
}

//Карта 2gis
function loadMap(city){
    if(!document.getElementById('myMapId')) return;
    // Создаем объект карты, связанный с контейнером: 
    var myMap = new DG.Map('myMapId'); 
    // Устанавливаем центр карты: 
    myMap.setCenter(new DG.GeoPoint(cities[city].latitude,cities[city].longitude)); 
    // Устанавливаем коэффициент масштабирования: 
    myMap.setZoom(16); 
    // Добавляем элемент управления коэффициентом масштабирования: 
            myMap.controls.add(new DG.Controls.Zoom()); 
 
            // Создаем балун: 
    var myBalloon = new DG.Balloons.Common({ 
        // Местоположение на которое указывает балун: 
        geoPoint: new DG.GeoPoint(cities[city].latitude,cities[city].longitude), 
        // Текст внутри балуна: 
        contentHtml: cities[city].title 
    }); 
    // Создаем маркер: 
    var myMarker = new DG.Markers.Common({ 
        // Местоположение на которое указывает маркер (в нашем случае, такое же, где и балун): 
        geoPoint: new DG.GeoPoint(cities[city].latitude,cities[city].longitude), 
        // Функция, которая будет вызвана при клике по маркеру: 
        clickCallback: function() { 
            // Если балун еще не был добавлен: 
            if (! myMap.balloons.getDefaultGroup().contains(myBalloon)) { 
                // Добавить балун на карту: 
                myMap.balloons.add(myBalloon); 
            } else { 
            // Если балун уже был добавлен на карту, но потом был скрыт: 
                // Показать балун: 
                myBalloon.show(); 
            } 
        } 
    }); 
    // Добавить маркер: 
    myMap.markers.add(myMarker);
}
 // Создаем обработчик загрузки страницы: 
DG.autoload(function() { 
    loadMap('IzhevskMap');
}); 

function loadMap(id) {
  if(!document.getElementById(id)) return false;
  var map = new DG.Map(id)
  var point = new DG.GeoPoint(53.245533,56.846375)
  map.setCenter(point, 16)
  map.controls.add(new DG.Controls.Zoom())
 
  var balloon = new DG.Balloons.Common({
    geoPoint: point,
    contentHtml: '<strong>г. Ижевск, ул. Ленинская, 100</strong>'
  })
  var marker = new DG.Markers.Common({
    geoPoint: point,
    clickCallback: function(){
      if (!map.balloons.getDefaultGroup().contains(balloon))
        map.balloons.add(balloon)
      else
        balloon.show()
    }
  })
  map.markers.add(marker)
}
 
 
DG.autoload(function() {
  loadMap('contactsMap');//То где, альтернативно будет отабражена схема проезда
});
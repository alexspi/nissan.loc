<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20.09.2016
 * Time: 12:38
 */?>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<script type="text/javascript">
    ymaps.ready(init);
    var myMap, myPlacemark;

    var myMap2, myPlacemark2;
    
    function init(){
        myMap = new ymaps.Map("map", {
            center: [60.02984601095928,30.334898145507807],
            zoom: 16
        });
        
        myPlacemark = new ymaps.Placemark([60.03017080912556,30.334275873016363], {
            hintContent: 'Магазин автозапчастей Nissan, Infiniti',
            balloonContent: 'Северный 5к3, 2 этаж, секция 209'
        });
        
        myMap.geoObjects.add(myPlacemark);

        myMap2 = new ymaps.Map("map2", {
            center: [59.862551, 30.234328],
            zoom: 16
        });
        
        myPlacemark2 = new ymaps.Placemark([59.862551, 30.234328], {
            hintContent: 'Магазин автозапчастей Nissan, Infiniti',
            balloonContent: 'Северный 5 к.3, 2 этаж, секция 208'
        });
        
        myMap2.geoObjects.add(myPlacemark2);
    }
</script>

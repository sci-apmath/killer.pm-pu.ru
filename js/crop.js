// x1, y1, x2, y2 - Координаты для обрезки изображения
// crop - Папка для обрезанных изображений
var x1, y1, x2, y2, crop = 'img/users/';
var jcrop_api;

jQuery(function($){             

	$('#target').Jcrop({		
		onChange:   showCoords,
		onSelect:   showCoords
	},function(){		
		jcrop_api = this;
		jcrop_api.setOptions({ aspectRatio: 4/4 });
	jcrop_api.setOptions({
			minSize: [ 300, 300 ],
			maxSize: [ 1000, 1000 ]
	});
	jcrop_api.focus();
	});
	// Снять выделение	
    $('#release').click(function(e) {		
		release();
    }); 
	
	
	
		// Изменение координат
	function showCoords(c){
		x1 = c.x; $('#x1').val(c.x);		
		y1 = c.y; $('#y1').val(c.y);		
		x2 = c.x2; $('#x2').val(c.x2);		
		y2 = c.y2; $('#y2').val(c.y2);
		
		$('#w').val(c.w);
		$('#h').val(c.h);
		
		if(c.w > 0 && c.h > 0){
			$('#crop').show();
		}else{
			$('#crop').hide();
		}
		
	}	
});

function release(){
	jcrop_api.release();
	$('#crop').hide();
}
// Обрезка изображение и вывод результата
jQuery(function($){
	$('#crop').click(function(e) {
		var img = $('#target').attr('src');
		var id  = $('#crop').parent().attr('id');
		
		if ((x1!=x2) && (y1 != y2)){
			$.post('action.php', {'x1': x1, 'x2': x2, 'y1': y1, 'y2': y2, 'img': img, 'crop': crop, 'id': id}, function(file) {
				$("#img-target").hide();
				$("#cropresult").append('<img  src="../'+crop+file+'">');
			//	release();
		//		document.location.href='http://killer.pm-pu.ru/start.php';
			});
		}
    });   
});
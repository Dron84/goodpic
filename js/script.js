$(document).ready(function(){
	// var data=jQuery.parseJSON('load.php?where=w600')
	// $('#loadw600').load(data)

	// loadJSON('w600','loadw600');

	$('#searchtext').keyup(function(e){
		values=$(this).val();
		$('#searchhref').attr('href', '/search.php?words='+values);
		if(e.which == 13) {
			window.location.href = $('#searchhref').attr('href');
		}
	});
	$('button.btn.btn-info[data-cart]').on('click', function(){
		id = $(this).attr('data-cart');
		$.post('/function/', {'cart': 'add', 'id': id})
			.done(function(data){
				$(this).html(data);
				setTimeout(function(){
					$(this).html("<i class='fa fa-cart-plus'></i>");
				},1500);
				// console.log(data);
			})
			.fail(function(data){
				console.log(data);
			})
	});

	$('#logo').bind('trplclick', function(){
		window.location.href='/admin';
	});

	if ($.cookie('cart')!=null){
		$('#sending_form').css({'display':'block'});
	}else{
		$('#sending_form').css({'display':'none'});
	};

	setInterval(function(){
		if ($.cookie('cart')!=null){
			cart = $.cookie('cart');
			$('#sending_form').css({'display':'block'});
			// console.log(cart);
			cart_array = cart.split("::");
			// console.log(cart_array);
			len = cart_array.length - 1;
			// console.log(len);
			$('.cart_txt').html(len);
		}else{
			$('#sending_form').css({'display':'none'});
		}
	},3000);

	$('#cart_send').on('click', function(){
		email = $('input[name=email]').val();
		tel = $('input[name=tel]').val();
		$.post('/function/sendmail.php', {'order': '1', 'email': email, 'phone':tel})
			.done(function(data){
				$('#sendemail_error').html(data);
				$('#sendemail_error').css({'color':'green'});
				setTimeout(function(){
					$('#sendemail_error').html('');
					$.removeCookie('cart');
					window.location.reload();
				},1500);
			})
			.fail(function(data){
				$('#sendemail_error').html(data);
					$('#sendemail_error').css({'color':'red'});
			})
	});

	$('input[name=email]').change(function() {
        if($(this).val() != '') {
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if(pattern.test($(this).val())){
                $(this).css({'border' : '2px solid #569b44'});
								$('#cart_send').removeAttr('disabled');
            } else {
                $(this).css({'border' : '2px solid #ff0000'});
								$('#cart_send').attr('disabled','disabled');
            }
        } else {
            $(this).css({'border' : '1px solid #ff0000'});
						$('#cart_send').attr('disabled','disabled');
        }
    });
});


function loadJSON(from,whereID){
	$.getJSON('load.php?where='+from, function(data){
		$('#'+whereID).html(data);

	})
}

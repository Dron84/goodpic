$(document).ready(function(){
	$("#image").on('change', function(){
		$("#img-submit").prop("disabled", false);
	});
	$('#tags_clear').on('click',function(){
		$('#tags').val('');
	})
	$('#add_category_text').on('change',function(){
		var category_text = $('#add_category_text').val();
		if (category_text.length>3){
			$('#add_catname').prop('disabled',false);
		}else{
			$('#add_catname').prop('disabled',true);
		}
	});
	$('tag').on('click',function(){
		if (window.location.search!='?page=add_image'){
			tags_id = $(this).attr('data-tagsid');
			// console.log('tags_id='+tags_id);
			old_value = $('[data-tags='+tags_id+']').val();
			// console.log('old_value='+old_value);
			new_value = $(this).html();
			// console.log('new_value='+new_value);
			if (old_value.length!=0){
				old_value = $('[data-tags='+tags_id+']').val();
				value=old_value+', '+new_value;
				// console.log('value='+value);
				$('[data-tags='+tags_id+']').val(value);
			}else{
				$('[data-tags='+tags_id+']').val(new_value);
			}
		}else{
			old_value = $('#tags').val();
			new_value = $(this).html();
			if (old_value.length!=0){
				value=old_value+', '+new_value;
				$('#tags').val(value);
			}else{
				$('#tags').val(new_value);
			}
		}

	});
  $('#add_catname').on('click', function(){
  	var catname = $('#add_category_text').val();
  	var str = Base64.encode(catname);
  	$.post("/admin/func.php", { catname: str, addcat: "1",loadcatname:"1"})
		.done(function(data) {
			$('i.fa.fa-check.check').css({'display': 'inline-block', 'color': 'green'});
				setTimeout(function(){
					$('i.fa.fa-check.check').css({'display': 'none'});
					$('#category').html(data);
				}, 1500);

		})
		.fail(function(data){
			$('i.fa.fa-check.check').html(data);
			$('i.fa.fa-check.check').css({'display': 'inline-block', 'color': 'red'});
		});
  });
	$('#newname').blur(function() {
      if($(this).val() != '') {
          var pattern = /^[A-Za-z0-9]{2,15}$/i;
          if(pattern.test($(this).val())){
              $(this).css({'border' : '2px solid #569b44'});
              $('#newname_error').css({'color': 'green'});
							$('#newname_error').html('Будет новое имя');
          } else {
              $(this).css({'border' : '2px solid #ff0000'});
							$('#newname_error').css({'color': 'red'});
              $('#newname_error').html('Имя не корректно');
          }
      }
  });
	$("button[type='submit']").on('click', function(){
		hrefid = $(this).attr('data-hrefid');
		oldname = $('input[data-oldname='+hrefid+']').val();
		name = $('input[data-name='+hrefid+']').val();
		category = $("select:input[data-category="+hrefid+"]").val();
		tags = $('input[data-tags='+hrefid+']').val();
		comment = $('input[data-comment='+hrefid+']').val();
		width = $('input[data-width='+hrefid+']').val();
		height = $('input[data-height='+hrefid+']').val();
		price = $('input[data-price='+hrefid+']').val();
		$.post('edit_image.php',{'name':name,'category':category,'tags':tags, 'comment':comment, 'size': width+'x'+height,'id': hrefid , edit_image: 'edit', 'old_name': oldname, 'price': price})
			.done(function(data){
				$('span[data-error='+hrefid+']').html(data);
				$('span[data-error='+hrefid+']').css({'color':'green'})
				setTimeout(function(){$('span[data-error='+hrefid+']').html('')},1500);
			})
			.fail(function(data){
				console.log('Ошибка передачи данных')
			});
	})
	$('button[data-dismiss=modal]').on('click', function(){
		window.location.reload();
	})
	$('#config_save').on('click',function(){
		db_server = $('#db_server').val();
		db_user = $('#db_user').val();
		db_password = $('#db_password').val();
		db_base_name = $('#db_base_name').val();
		sendmail_to = $('#sendmail_to').val();
		sendmail_from = $('#sendmail_from').val();
		ssh_server = $("#ssh_server").val();
		ssh_server_port = $("#ssh_server_port").val();
		ssh_user = $("#ssh_user").val();
		ssh_pass =$("#ssh_pass").val();
		$.post('/admin/func.php', {'db_server':db_server,'db_user':db_user, 'db_password':db_password, 'db_base_name':db_base_name, db_config: true, 'sendmail_to': sendmail_to, 'sendmail_from': sendmail_from, "ssh_server":ssh_server, "ssh_server_port":ssh_server_port, "ssh_user":ssh_user, "ssh_pass":ssh_pass})
			.done(function(data){
				$('#config_msg').html(data);
				$('#config_msg').css({'color':'green'});
			})
			.fail(function(data){
				$('#config_msg').html(data);
				$('#config_msg').css({'color':'red'});
			});
	})
})

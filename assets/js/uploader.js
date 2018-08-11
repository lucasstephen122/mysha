(function($){
	var jcrop_api;

	$.fn.extend({

		uploader : function(options , attachment)
		{
			var defaults =
			{
				on_success : function(){},
				on_progress : function(){},
				on_error : function(){},
				dragDrop : false,
				module : 'DEFAULT',
				rel : null,
				type : 0,
				size: '',
				acceptFileTypes : /(\.|\/)(gif|jpe?g|png)$/i
			};
			var options = $.extend(true, defaults, options);

			var $this = $(this);
			var id = $this.attr('id');

			$this.data('uploader-options' , options);

			if(options.dragDrop)
			{
				$this.addClass('drop-zone');
			}
			$this.addClass('fileinput-button');

			$('fileupload_'+ id).remove();
			var $fileupload =$('<input id="fileupload_'+ id +'" name="fileupload_'+ id +'" type="file">');
			$this.append($fileupload);

			var $remove = $('<span class="remove dev_remove"><i class="fa fa-times"></i></span>');
			var $crop = $('<span class="lnk-crop dev_crop"><i class="fa fa-crop"></i></span>');

			if($this.hasClass('file-thumbnail'))
			{
				// $this.append($remove);
				// $this.append($crop);
			}

		    $fileupload.fileupload(
		    {
			    url : g.base_url + 'common/attachment/upload',
		       	dataType: 'json',
		       	formData : {module : options.module , type:options.type},
				dropZone : options.dragDrop ? $this : null,
		        done: function (e, response)
		       	{
		        	var attachment = response['result']['result'];
		        	show_attachment($this , attachment);

		        	// crop_attachment($this , $crop);

		        	if($.isFunction(options.on_success))
		        		options.on_success(attachment);

		        },
		        singleFileUploads : true,
		        paramName : 'attachment',
				acceptFileTypes : options.acceptFileTypes
		    });

		    $fileupload
				.bind('fileuploadadd', function (e, data)
				{
					console.log($this);
					var $outer = $this.closest('.file-uploader-outer');
					console.log($outer);

					$outer.find('.uploader-progress-inner').width('0%');
					$outer.find('.uploader-progress').fadeIn('fast');

					$this.trigger('upload-start' , [data]);
				})
				.bind('fileuploaddone', function (e, data)
				{
					console.log($this);
					var $outer = $this.closest('.file-uploader-outer');
					console.log($outer);

					$outer.find('.uploader-progress-inner').width('100%');
					$outer.find('.uploader-progress').fadeOut('fast');

					$this.trigger('upload-end' , [data]);
				})
				.bind('fileuploadprogress', function (e, data)
				{
					console.log($this);
					var $outer = $this.closest('.file-uploader-outer');
					console.log($outer);

					var file = data.files[0];
		            var total = data._progress.total;
		            var loaded = data._progress.loaded;
		            var progress = parseInt(loaded / total * 100);

					$outer.find('.uploader-progress-inner').width(progress + '%');

					$this.trigger('upload-progress' , [data]);
				});

		    $remove.click(function()
		    {
		    	remove_attachment($this , $remove);
		    	return false;
		    });

		    $crop.click(function()
		    {
		    	crop_attachment($this , $crop);
		    	return false;
		    });

		    if(attachment)
		    {
		    	show_attachment($this , attachment);

	        	if($.isFunction(options.on_success))
	        		options.on_success(attachment);
		    }
		    else
		    {
		    	reset_attachment($this);
		    	$remove.hide();
		    	$crop.hide();
		    }


			$this.unbind('render').bind('render' , function()
			{
				var $parent = $this.closest('.file-uploader-outer');
				var $download = $('a.download' , $parent);
				if($download.attr('href') != "#")
				{
					if(!$download.find('i').length)
					{
						$('<i class="fa fa-paperclip" style="margin-right: 5px;"></i>').prependTo($download);
					}
				}
			});


		    function show_attachment($this , attachment)
		    {
		    	var $remove = $this.find('.dev_remove');
		    	var $crop = $this.find('.dev_crop');

		    	$this.data('attachment' , attachment);
		    	var $outer = $this.closest('.file-uploader-outer');

	        	$('input[type="hidden"]' , $this).val(attachment['attachment_id']);
	        	$('img.thumb' , $this).attr('src' , attachment['render_url']);

	        	var $parent = $this.closest('.file-uploader-outer');
	        	if($parent.length > 0)
	        	{
	        		$('a.download' , $parent).attr('href' , attachment['download_url']).html(attachment['name'] ? attachment['name'] : "Download");
	        	}

	        	$remove.show();
	        	$crop.show();

	        	var options = $this.data('uploader-options');
	        	if(options.rel)
	        	{
	        		var $that = $('#'+options.rel);
	        		show_attachment($that , attachment);
	        		// crop_attachment($that , $that.find('.dev_crop'));
	        	}

	        	$this.trigger('attachment_shown' , [attachment]).trigger('render');
		    }

		    function reset_attachment($this)
		    {
		    	var $parent = $this.closest('.file-uploader-outer');
	        	if($parent.length > 0)
	        	{
	        		// $('a.download' , $parent).attr('href' , '#').html("");
	        	}
		    }

		    function remove_attachment($this , $remove)
		    {
		    	$this.data('attachment' , {});

	        	$('input[type="hidden"]' , $this).val('');
	        	$('img.thumb' , $this).attr('src' , $('img.thumb' , $this).data('src'));
	        	Holder.run({images:$('img.thumb' , $this).get(0)});
	        	$('a.link' , $this).attr('href' , '#');
	        	$remove.hide();
	        	$crop.hide();
		    }

		    function crop_attachment($this , $crop)
		    {
		    	if(!$this.hasClass('file-thumbnail'))
				{
					return false;
				}

		    	$modal = bdialog('upload_crop' , 'Crop image' ,
		    	{
		    		on_show : function($modal)
		    		{
		    			var $body = $('.dev_body' , $modal);
					    $modal.modal('show');

					    var attachment = $this.data('attachment');
					    var body = '<div class="img-crop"><img class="img-block dev_image"></img></div>';
					    $body.html(body);

					    $('.dev_image' , $modal).attr('src' , attachment['render_url']+'?rand='+Math.random());

					    $('.dev_image' , $modal).Jcrop(
					    {
							bgOpacity: 0.4,
							bgColor: 'black',
							addClass: 'jcrop-light',
							onSelect: function(coords)
							{
								$('.dev_image' , $modal).data('coords' , coords);
							}
						},function()
						{
							jcrop_api = this;
							// jcrop_api.setSelect([130,65,130+350,65+285]);
							// jcrop_api.setOptions({ bgFade: true });
							// jcrop_api.ui.selection.addClass('jcrop-selection');
						});
		    		},
		    		on_save : function($modal)
			    	{
			    		var attachment = $this.data('attachment');
			    		var $image = $('.dev_image' , $modal);
			    		var coords = $image.data('coords');

			    		if(coords && coords.w && coords.h)
			    		{

				    		var data = new Object();
				    		data['attachment_id'] = attachment['attachment_id'];
				    		data['x'] = coords.x;
				    		data['y'] = coords.y;
				    		data['w'] = coords.w;
				    		data['h'] = coords.h;
				    		data['width'] = $image.width();
				    		data['height'] = $image.height();

				    		post_data('common/attachment/crop' , data , function(response)
	            			{
	            				var attachment = response.result;
	            				attachment['render_url'] = attachment['render_url']+'?rand='+Math.random();
	            				show_attachment($this , attachment);

	            				$modal.modal('hide');
	            			});
				    	}
				    	else
				    	{
				    		$modal.modal('hide');
				    	}
			    	},
			    	on_close : function ($modal)
			    	{
			    		jcrop_api.destroy();
			    	}
			    });
		    }


		    $(document).bind('drop dragover', function (e)
		    {
		        // Prevent the default browser drop action:
		        e.preventDefault();
		    });


		    $(document).bind('dragover', function (e)
		    {
		        var dropZone = $this,
		            timeout = window.dropZoneTimeout;
		        if (!timeout) {
		            dropZone.addClass('in');
		        } else {
		            clearTimeout(timeout);
		        }
		        var found = false,
		          	node = e.target;
		        do {
		            if (node === dropZone[0]) {
		           		found = true;
		           		break;
		           	}
		           	node = node.parentNode;
		        } while (node != null);
		        if (found) {
		            dropZone.addClass('hover');
		        } else {
		            dropZone.removeClass('hover');
		        }
		        window.dropZoneTimeout = setTimeout(function () {
		            window.dropZoneTimeout = null;
		            dropZone.removeClass('in hover');
		        }, 100);
		    });

		}
	});
})(jQuery);


$(document).ready(function()
{
	$('.file-uploader').each(function(index, el)
	{
		init_uploader($(this));
	});
});

function init_uploaders($file_uploaders)
{
	$file_uploaders.each(function(index, el)
	{
		init_uploader($(this));
	});
}

function init_uploader($this)
{
	if(!$this.hasClass('file-uploader-template'))
	{
		$this.uploader(
		{
			module : $this.data('module'),
			rel : $this.data('rel'),
			dragDrop : true
		});
	}
}

function refresh_attachment($this , attachment)
{
	var $remove = $this.find('.dev_remove');
	var $crop = $this.find('.dev_crop');

	$this.data('attachment' , attachment);
	var $outer = $this.closest('.file-uploader-outer');

	$('input[type="hidden"]' , $this).val(attachment['attachment_id']);
	$('img.thumb' , $this).attr('src' , attachment['render_url']);

	var $parent = $this.closest('.file-uploader-outer');
	if($parent.length > 0)
	{
		$('a.download' , $parent).attr('href' , attachment['download_url']).html(attachment['name'] ? attachment['name'] : "Download");
	}

	$remove.show();
	$crop.show();

	var options = $this.data('uploader-options');
	if(options.rel)
	{
		var $that = $('#'+options.rel);
		show_attachment($that , attachment);
		crop_attachment($that , $that.find('.dev_crop'));
	}
}

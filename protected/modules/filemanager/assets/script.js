(function($, window, undefined) {
    
    $(function() {
        
        var Container = $('#GalleryContainer');
        
        ////////////////////////////////////////////////////////////////////////
        // Пэджинация
        var pagination = function(){
            var pager = $('#GalleryContainer .pager');
            var pagerLi_next = pager.find('li.next');
            if ( ! pagerLi_next.hasClass('hidden') ) {
                var nextLink = pagerLi_next.find('a')
                                .addClass('more-comments-widget')
                                .addClass('rounded')
                                .text('Еще фотографии');
                                
                $('#GalleryContainer').append(nextLink);
                pager.remove();

                nextLink.click(function(event){
                    event.stopPropagation();
                    event.preventDefault();

                    var href = nextLink.attr('href');
                    $.ajax({
                        type: 'GET',
                        url: href,
                        success: function(response) {
                            var response = $('<div />').html(response);
                            var content = $(response).find('#GalleryContainer').html();
                            Container.append(content);
                            nextLink.remove();
                            pagination();
                        }
                    })
                })
            } else {
                pager.remove();
            }
        }
        pagination();
        ////////////////////////////////////////////////////////////////////////
        Container.delegate('.UploadPhotoToAlbum', 'click', function(event){
            event.stopPropagation();
            event.preventDefault();
            var link = $(this),
                url = link.attr('href');
                
            $.ajax({
                url: url,
                success: function(response) {
                    $.fancybox({
                        content: response
                    });
                }
            });
        });
                
        Container.delegate('.UpdateAlbum', 'click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            var link = $(this),
                url = link.attr('href'),
                Section = link.parents('article');
                
            $.ajax({
                url: url,
                type: 'get',
                success: function(response) {
                    Section.replaceWith(response);
                    UpdateTagCloud();
                }
            });
        });
        Container.delegate('.ViewAlbum', 'click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            var link = $(this),
                url = link.attr('href'),
                Section = link.parents('article');
            
            $.ajax({
                url: url,
                type: 'get',
                success: function(response) {
                    Section.replaceWith(response);
                }
            });
        });
        Container.delegate('.DeleteAlbum', 'click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            var link = $(this),
                url = link.attr('href'),
                Section = link.parents('article');
                
            if (window.confirm('Вы действительно хотите удалить весь альбом?')) {
                $.ajax({
                    url: url,
                    type: 'post',
                    success: function(response) {
                        Section.remove();
                        UpdateTagCloud();
                    }
                });
            }
        });
        /*Container.delegate('.UpdatePhoto', 'click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            var link = $(this),
                url = link.attr('href'),
                Section = link.parents('article');
                
            $.ajax({
                url: url,
                type: 'get',
                success: function(response) {
                    var content = $(response);
                    content.find('form').bind('submit', function() {
                        UpdateTagCloud();
                    });
                    Section.replaceWith(content);
                }
            });
        }); */
        Container.delegate('.UpdatePhoto', 'click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            var link = $(this),
                url = link.attr('href');
                
            var Proccess = function(response) {
                    var content = $(response);
                    content.find('form').bind('submit', function(event) {
                        event.stopPropagation();
                        event.preventDefault();
                        
                        var form = $(this),
                            url = form.attr('action'),
                            method = form.attr('method'),
                            data = form.serialize();
                            
                        $.ajax({
                            url: url,
                            type: method,
                            data: data,
                            dataType: 'text',
                            success: function(response) {
                                try {
                                    var obj = $.parseJSON(response);
                                    if ( typeof obj.url != 'undefined' ) {
                                        $.fancybox.close();
                                        UpdateTagCloud();
                                    }
                                }
                                catch(e) {
                                    Proccess(response);
                                }
                            }
                        });
                        
                    });
                    content.find('.Cancel').bind('click', function(event) {
                        event.stopPropagation();
                        event.preventDefault();
                        
                        $.fancybox.close();
                    });
                    
                    $.fancybox({
                        content: content,
                        autoDimension: true,
                        atuoScale: true
                    });
                };
                
            $.ajax({
                url: url,
                type: 'get',
                success: function(response) {
                    Proccess(response);
                }
            });
                
        });
        Container.delegate('.DeletePhoto', 'click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            var link = $(this),
                item = link.parents('.item'),
                url = link.attr('href'),
                Section = link.parents('article');
            
            $.ajax({
                url: url,
                type: 'post',
                success: function(response) {
                    item.remove();
                    UpdateTagCloud();
                }
            });
        });
        // Обработка форм
        var ProccessForm = function(response) {
            try {
                var obj = $.parseJSON(response);
                if ( typeof obj.url != 'undefined' ) {
                    $.ajax({
                        url: obj.url,
                        type: 'get',
                        success: function(response) {
                            ProccessForm.Section.replaceWith(response);
                        }
                    });
                }
            }
            catch(e) {
                ProccessForm(response);
            }
        }
        
        Container.delegate('form', 'submit', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            ProccessForm.form = $(this);
            ProccessForm.url = ProccessForm.form.attr('action');
            ProccessForm.method = ProccessForm.form.attr('method');
            ProccessForm.data = ProccessForm.form.serialize();
            ProccessForm.Section = ProccessForm.form.parents('article');
                
            $.ajax({
                url: ProccessForm.url,
                type: ProccessForm.method,
                data: ProccessForm.data,
                dataType: 'text',
                success: function(response) {
                    ProccessForm(response);
                }
            });
        });
        
        Container.delegate('.Cancel', 'click', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            var Section = $(this).parents('article'),
                link = $(this),
                url = $(this).data('url');
                
            if ( typeof url != 'undefined' ) {
                $.ajax({
                    url: url,
                    method: 'get',
                    success: function(response) {
                        Section.replaceWith(response);
                    }
                });
            } else {
                Section.remove();
            }
        });
        
        var timer = null;
        var UpdateTagCloud = function() {
            if ( timer === null ) {
                timer = setTimeout(function() {
                    var TagCloud = $('.tag-cloud-widget'),
                        url = TagCloud.data('url');

                    $.ajax({
                        url: url,
                        type: 'get',
                        success: function(response) {
                            var content = $(response).find('.tag-cloud');
                            
                            TagCloud.find('tag-cloud').replaceWith(content);
                        }
                    });
                    
                    timer = null;
                }, 2000);
            }
        }
        
        /* Галерея */
        Galleria.loadTheme('/themes/santehnik/js/galleria/themes/classic/galleria.classic.min.js');
        var ShowGalleria = function (dataSource, index) {
            var galleryContainer = $('<div id="mega_gallery"></div>').appendTo('body');
            $.fancybox({
                content: galleryContainer,
                autoScale: false
            });
            if ( typeof index == 'undefined' ) {
                index = 0;
            }
            $("#mega_gallery").galleria({
                preload: 0,
                dataSource : dataSource,
                showInfo: true,
                showCounter: false,
                maxScaleRatio: 1,
                showImagenav: dataSource.length>1 ? true : false,
                extend: function(options) {
                    this.attachKeyboard({
                        left: this.prev, // applies the native prev() function
                        right: this.next
                    });
                },
                show: index
            });
            
        }
        
//		Container.delegate('.photos .entry .item a.image', 'click', function(event) {
        Container.delegate('.photos a.image', 'click', function(event) {
				event.preventDefault();
				event.stopPropagation();
                
                var link = $(this),
                    Section = link.parents('article'),
                    url = Section.data('url');
                
                if ( typeof url != 'undefined' ) {
                    
                url = url+'&url='+link.children('img').attr('src');
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        ShowGalleria(response);                            
                    }
                });
                } else {
                    var dataSource = [];
                    var images = Container.find('a.image');
                    var curUrl = link.attr('href');
                    var index = 0;
                    images.each(function(i, e) {
                        var elem = $(e);
                        var image = elem.attr('href');
                        var thumb = elem.find('img').attr('src');
                        var description = elem.find('img').data('description');
                        dataSource.push({
                            image: image,
                            thumb: thumb,
                            title: description
                        });
                        if (curUrl==image) {
                            index = i;
                        }
                    });
                    
                    ShowGalleria(dataSource, index);
                }
                
			}
		);
        /* Все теги в картинках */
        var timer = null;
        $('a.TagImage').each(function(i, v) {
            
            var link = $(this),
                url = link.data('url'),
                image = link.find('img');
            
            $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if ( typeof response.thumb != 'undefined' ) {
                            image.attr('src', response.thumb);
                            link.attr('alt', response.title);
                        }
                    }
                });
        });
        
        Container.delegate('a.TagImage', 'mouseover', function(event) {
            event.stopPropagation();
            event.preventDefault();
            
            if (timer!==null) {
                return;
            }
            
            var link = $(this),
                url = link.data('url'),
                image = link.find('img');
            
            timer = setInterval(function() {
                $.ajax({
                    url: url,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if ( typeof response.thumb != 'undefined' ) {
                            image.attr('src', response.thumb);
                            link.attr('alt', response.title);
                        }
                    }
                });
            }, 500);
        });
        Container.delegate('a.TagImage', 'mouseout', function(event) {
            event.stopPropagation();
            event.preventDefault();

            clearInterval(timer);
            timer = null;
        });
        
        
    });
    
})(jQuery, window);
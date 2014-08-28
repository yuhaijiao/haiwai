function toJson( str ) {
	var json = {}, arr = str.split( ';' );
	
	for( var i = 0; i < arr.length; i ++ ) {
		if( arr[i] !== '' ) {
			var item = arr[i].split( ':' );
			
			if( item.length && item.length == 2 ) {
				json[ item[0] ] = item[1];
			}
		}
	}
	
	return json;
}

/**
 * 查看用户消费的详细信息
 *  
 */
$.fn.ajaxdetail = function() {
	var in_range = false;
	
	$( document ).bind( 'click.cover', function() {
		if( !in_range ) {
			lose();
		}
	});
	
	$( this ).parents( 'td' ).hover(function() {
		in_range = true;
	}, function() {
		in_range = false;
	});
		
	$( this ).click(function( event ) {
		var url = $( this ).attr( 'href' );
		
		load( $( this ).parents( 'table' ), $( this ).parents( 'td' ), url );
		
		event.preventDefault();
	});
	
	function load( layout, cell, url ) {
		
		var O_c = getCover( layout, cell ), O_content = O_c.find( '.S_cover_content' ), to = toJson( O_c.attr( 'cover-end' ) );
		
		if( O_c.is( ':hidden' ) ) {
			O_c.css( toJson( O_c.attr( 'cover-start' ) ) );
			to.opacity = 'show';
			O_c.animate( to, 200 );
		}
		
		$.ajax({
			url: url,
			beforeSend: function() {
				O_content.html( 'loading...' );
			},
			success: function( htmlStr ) {
				O_content.html( htmlStr );
			}
		});
	}
	
	function getCover( layout, cell ) {
		var O_c = $( '#S_cover_layout' ), O_l = $( layout ), O_cell = $( cell );
		
		var w = O_l.innerWidth() - O_cell.innerWidth(), 
			h = O_l.innerHeight(),
			l = O_l.offset().left + O_cell.innerWidth(), 
			t = O_l.offset().top;
		
		if( !O_c.length ) {
			$( 'body' ).append( O_c = $( '<div id="S_cover_layout" style="position: absolute;display:none;"><div class="S_cover_content"></div></div>' ) );
			
			O_c.hover(function() {
				in_range = true;
			}, function() {
				in_range = false;
			});
		}
		
		O_c.attr( 'cover-start', 'width:'+ w * 0.8 +'px;height:'+ h +'px;left:'+ l * 1.2 + 'px;top:'+ t * 1.2 +'px;' );
		O_c.attr( 'cover-end', 'width:'+ w +'px;height:'+ h +'px;left:'+ l + 'px;top:'+ t +'px;' );
		
		return O_c;
	}
	
	function lose() {
		var O_c = $( '#S_cover_layout' );
		
		if( O_c.length ) {
			var to = toJson( O_c.attr( 'cover-start' ) );
			to.opacity = 'hide';
			O_c.animate( to, 260 );
		}
	}
};

	
function getFormDataJson( form ) {
	var json = {};
	
	$( form ).find( 'input, textarea' ).each(function() {
		json[ $( this ).attr( 'name' ) ] = $( this ).val();
	});
	
	return json;
}

/**
 * 单人操作的控制层
 *  
 */
$.fn.popfollow = function() {
	var in_range = false;
	
	$( document ).bind( 'click.pop', function() {
		if( !in_range ) {
			lose();
		}
	});
	
	$( this ).parents( 'td' ).hover(function() {
		in_range = true;
	}, function() {
		in_range = false;
	});
	
	this.click(function( event ) {
		var url = $( this ).attr( 'href' );
		
		load( $( this ).parents( 'td' ), url );
		
		event.preventDefault();
	});
	
	function load( cell, url ) {
		var O_c = getCover( cell );
		
		if( O_c.is( ':hidden' ) ) {
			O_c.fadeIn( 120 );
		}
		
		$.ajax({
			url: url,
			beforeSend: function() {
				O_c.html( '<div class="poplayout">loading...</div>' );
			},
			success: function( htmlStr ) {
				O_c.html( htmlStr );
				
				$( '#S_pop_layout' ).find( 'input[type=text]' ).first().focus();
				
				ajaxForm();
			}
		});
	}
	
	function ajaxForm() {
		var form = $( '#S_pop_layout' ).find( 'form' );
		
		form.submit(function() {
			var action = this.action, params = getFormDataJson( form );
			
			$.post( action, params, function( state ) {
				if( state ) {
					location.reload();
				}
			});
		
			return false;
		});
	}
	
	function getCover( cell ) {
		var O_c = $( '#S_pop_layout' ), O_l = cell.parents( 'table' ), O_cell = $( cell );
		
		var w = O_l.innerWidth() - O_cell.innerWidth(), 
			h = O_cell.innerHeight(),
			l = O_l.offset().left + O_cell.innerWidth(), 
			t = O_cell.offset().top;
		
		if( !O_c.length ) {
			$( 'body' ).append( O_c = $( '<div id="S_pop_layout" style="position: absolute;display:none;"></div>' ) );
			
			O_c.hover(function() {
				in_range = true;
			}, function() {
				in_range = false;
			});
		}
		
		O_c.css({ 'width': w +'px', 'height': h +'px', 'left': l + 'px', 'top': t +'px' });
		
		return O_c;
	}
	
	function lose() {
		var O_c = $( '#S_pop_layout' );
		
		if( O_c.length ) {
			O_c.fadeOut( 120 );
		}
	}
};


$.fn.ajaxform = function( list ) {
	var O_layout = $( '#s_ajaxform' );
	
	this.click(function( event ) {
		var target = this, url = $( this ).attr( 'href' );
		
		if( $( this ).hasClass( 's_curtab' ) ) {
			O_layout.fadeOut( 100 );
			list.removeClass( 's_curtab' ).fadeTo( 100, 1 );
		} else {
		
			list.each(function() {
				if( this === target ) {
					$( this ).addClass( 's_curtab' ).fadeTo( 100, 1 );
				} else {
					$( this ).removeClass( 's_curtab' ).fadeTo( 100, 0.5 );
				}
			});
			
			$.ajax({
				url: url,
				beforeSend: function() {
					O_layout.show().html( 'loading...' );
				},
				success: function( htmlStr ) {
					O_layout.html( htmlStr );
					
					O_layout.find( 'input[type=text]' ).first().focus();
					
					O_layout.find( 'form' ).submit(function() {
						ajaxAverageDebit( this );
						
						return false;
					});
				}
			});
		}
		
		event.preventDefault();
	});
};


function ajaxAverageDebit( form ) {
	var O_layout = $( '#s_ajaxform' ), action = form.action;
	
	var params = getFormDataJson( form );
	
	$.ajax({
		url: action,
		data: params,
		beforeSend: function() {
			O_layout.html( 'loading...' );
		},
		success: function( htmlStr ) {
			O_layout.html( 'success' );
			window.location.reload();
		}
	});
}



$(function() {
	
	$( '.s_ajax' ).ajaxform( $( '#s_control-bar > a.button' ) );
	$( '.s_ajaxdetail' ).ajaxdetail();
	$( '.s_popfollow' ).popfollow();
	
});

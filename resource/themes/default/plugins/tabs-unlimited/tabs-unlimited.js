function tabs_unlimited() {
	$('.tabs-unlimited').append(function() {
		let html = ''
		html += '<li class="__left-tabunlimited"><i class="fa fa-chevron-circle-left"></i></li>'
		html += '<li class="__right-tabunlimited"><i class="fa fa-chevron-circle-right"></i></li>'
		return html
	})

	$('.tabs-unlimited').each(function() {
		let r = $(this),
			o = r.width(),
			f = 0,
			l = 0

		r
			.find('> li')
			.not('.__left-tabunlimited, .__right-tabunlimited')
			.each(function() {
				f += $(this).width()
			})

		r
			.find('.__right-tabunlimited')
			.click(function() {
				if(l < f-o+60) {
					l+=60
					r
						.find('li')
						.eq(0)
						.animate({
							'margin-left' : -l
						})
				}
			})

		r
			.find('.__left-tabunlimited')
			.click(function() {
				if(l > 0) {
					l-=60
					r
						.find('li')
						.eq(0)
						.animate({
							'margin-left' : -l
						})
				}
			})

	})

	let css = {
		'.tabs-unlimited' : {
			'white-space': 'nowrap',
			'overflow': 'hidden',
			'position': 'relative',
	        'padding': '0 30px'
		},
		'.tabs-unlimited .__left-tabunlimited' : {
			'left': '0px'
		},
		'.tabs-unlimited .__right-tabunlimited' : {
			'right': '0px'
		},
		'.tabs-unlimited .__left-tabunlimited, .tabs-unlimited .__right-tabunlimited' : {
		    'position': 'absolute',
		    'top': '0px',
		    'background': '#fff',
		    'padding': '5px',
		    'line-height': '35px',
		    'text-align': 'center',
		    'cursor': 'pointer',
		},
		'.tabs-unlimited>li' : {
		    'display': 'inline-block !important',
		    'vertical-align': 'top',
		    'white-space': 'normal',
		    'float': 'none !important',
		    'margin-bottom': '0px'
		}
	}

	$('head').append(function() {
		let str = '<style>'
		for (let selector in css) {
			str += selector+'{'
			for(let property in css[selector]) {
				str += property+':'
				str += css[selector][property]+';'
			}
			str += '}'
		}
		str += '</style>'
		return str
	})

}

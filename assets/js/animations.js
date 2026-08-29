/**
 * انیمیشن‌ها و اسلایدرهای قالب BajiStyle
 *
 * شامل اسلایدر هیرو (افقی حرکتی)، اسلایدر نظرات مشتریان و انیمیشن fade-up
 * عناصر هنگام ورود به viewport (با استفاده از IntersectionObserver).
 *
 * @package BajiStyle
 * @since 1.0.0
 */

/**
 * مقداردهی اولیه اسلایدر بخش هیرو صفحه اصلی (مدل افقی حرکتی + انیمیشن محتوا).
 *
 * @since 1.0.0
 */
function initHeroSlider() {
	const sliderContainer = document.querySelector( '[data-baji-slider]' );
	if ( ! sliderContainer ) {
		return;
	}

	const track = sliderContainer.querySelector( '.baji-slider-track' );
	const slides = Array.from( sliderContainer.querySelectorAll( '.baji-hero-slide' ) );
	const dots = Array.from( sliderContainer.querySelectorAll( '.baji-hero-dot' ) );
	const nextBtn = sliderContainer.querySelector( '.baji-slider-next' );
	const prevBtn = sliderContainer.querySelector( '.baji-slider-prev' );
	
	let currentIndex = 0;
	const totalSlides = slides.length;
	if ( totalSlides === 0 ) {
		return;
	}

	const autoplayDelay = parseInt( sliderContainer.getAttribute( 'data-autoplay' ), 10 ) || 6000;
	let autoPlayInterval = null;
	let isTransitioning = false;

	// به‌روزرسانی ابعاد Track و اسلایدها
	const initSliderLayout = () => {
		track.style.width = ( totalSlides * 100 ) + '%';
		
		slides.forEach( ( slide ) => {
			slide.style.width = ( 100 / totalSlides ) + '%';
		} );
		
		updateSliderPosition();
	};

	// جابه‌جایی اسلایدر و مدیریت انیمیشن متن‌ها بدون تأخیر اضافی
	const updateSliderPosition = () => {
		const isRTL = window.getComputedStyle( sliderContainer ).direction === 'rtl';
		const translatePercent = currentIndex * ( 100 / totalSlides );
		const translateValue = isRTL ? translatePercent : -translatePercent;
		
		track.style.transform = `translateX(${ translateValue }%)`;

		// مدیریت انیمیشن متن‌های داخل اسلاید فعال و غیرفعال
		slides.forEach( ( slide, index ) => {
			const animItems = slide.querySelectorAll( '.baji-anim' );
			
			if ( index === currentIndex ) {
				animItems.forEach( ( item, itemIndex ) => {
					window.setTimeout( () => {
						item.style.opacity = '1';
						item.style.transform = 'translateY(0)';
					}, itemIndex * 100 );
				} );
			} else {
				animItems.forEach( ( item ) => {
					item.style.opacity = '0';
					item.style.transform = 'translateY(24px)';
				} );
			}
		} );

		// به‌روزرسانی استایل نقطه‌ها (Dots)
		dots.forEach( ( dot, dotIndex ) => {
			const isActive = dotIndex === currentIndex;
			dot.classList.toggle( 'w-5', isActive );
			dot.classList.toggle( 'bg-white', isActive );
			dot.classList.toggle( 'w-1.5', ! isActive );
			dot.classList.toggle( 'bg-white/50', ! isActive );
		} );
	};

	// رفتن به اسلاید مشخص
	const goToSlide = ( index ) => {
		if ( isTransitioning ) {
			return;
		}
		
		if ( index < 0 ) {
			index = totalSlides - 1;
		}
		if ( index >= totalSlides ) {
			index = 0;
		}
		
		currentIndex = index;
		isTransitioning = true;
		
		updateSliderPosition();
		
		window.setTimeout( () => {
			isTransitioning = false;
		}, 700 );
	};

	// رویدادهای دکمه‌ها
	if ( nextBtn ) {
		nextBtn.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			goToSlide( currentIndex + 1 );
			resetAutoplay();
		} );
	}

	if ( prevBtn ) {
		prevBtn.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			goToSlide( currentIndex - 1 );
			resetAutoplay();
		} );
	}

	// رویدادهای نقطه‌ها
	dots.forEach( ( dot, index ) => {
		dot.addEventListener( 'click', () => {
			goToSlide( index );
			resetAutoplay();
		} );
	} );

	// پشتیبانی از لمس و سوایپ در موبایل
	let touchStartX = 0;
	let touchEndX = 0;

	sliderContainer.addEventListener( 'touchstart', ( e ) => {
		touchStartX = e.changedTouches[0].screenX;
		stopAutoplay();
	}, { passive: true } );

	sliderContainer.addEventListener( 'touchend', ( e ) => {
		touchEndX = e.changedTouches[0].screenX;
		const diff = touchStartX - touchEndX;
		
		if ( Math.abs( diff ) > 40 ) {
			if ( diff > 0 ) {
				goToSlide( currentIndex + 1 );
			} else {
				goToSlide( currentIndex - 1 );
			}
			resetAutoplay();
		} else {
			startAutoplay();
		}
	}, { passive: true } );

	// کنترل پخش خودکار (Autoplay)
	const startAutoplay = () => {
		if ( ! autoplayDelay ) {
			return;
		}
		stopAutoplay();
		autoPlayInterval = window.setInterval( () => {
			goToSlide( currentIndex + 1 );
		}, autoplayDelay );
	};

	const stopAutoplay = () => {
		if ( autoPlayInterval ) {
			window.clearInterval( autoPlayInterval );
			autoPlayInterval = null;
		}
	};

	const resetAutoplay = () => {
		stopAutoplay();
		startAutoplay();
	};

	// توقف پخش خودکار هنگام هاور ماوس
	sliderContainer.addEventListener( 'mouseenter', stopAutoplay );
	sliderContainer.addEventListener( 'mouseleave', startAutoplay );
	
	// به‌روزرسانی ابعاد در زمان تغییر اندازه پنجره مرورگر
	let resizeTimeout;
	window.addEventListener( 'resize', () => {
		window.clearTimeout( resizeTimeout );
		resizeTimeout = window.setTimeout( updateSliderPosition, 150 );
	} );

	// راه‌اندازی اولیه
	initSliderLayout();
	startAutoplay();
}

/**
 * یک اسلایدر ساده و عمومی (برای نظرات مشتریان) با autoplay و dot navigation.
 *
 * @param {Object} options تنظیمات اسلایدر.
 * @since 1.0.0
 */
function createBajiSlider( options ) {
	const container = document.querySelector( options.containerSelector );
	if ( ! container ) {
		return;
	}

	const slides = Array.from( container.querySelectorAll( options.slideSelector ) );
	const dots = Array.from( container.querySelectorAll( options.dotSelector ) );

	if ( slides.length <= 1 ) {
		return;
	}

	const activeClasses = options.activeSlideClass.split( ' ' );
	const inactiveClasses = options.inactiveSlideClass.split( ' ' );
	const autoplayDelay = parseInt( container.dataset.autoplay, 10 ) || 0;

	let currentIndex = 0;
	let autoplayTimer = null;

	const showSlide = ( index ) => {
		slides.forEach( ( slide, slideIndex ) => {
			const isActive = slideIndex === index;
			slide.classList.remove( ...( isActive ? inactiveClasses : activeClasses ) );
			slide.classList.add( ...( isActive ? activeClasses : inactiveClasses ) );
		} );

		dots.forEach( ( dot, dotIndex ) => {
			dot.classList.toggle( 'bg-baji-white', dotIndex === index );
			dot.classList.toggle( 'bg-transparent', dotIndex !== index );
		} );

		currentIndex = index;
	};

	const nextSlide = () => {
		showSlide( ( currentIndex + 1 ) % slides.length );
	};

	const startAutoplay = () => {
		if ( ! autoplayDelay ) {
			return;
		}
		stopAutoplay();
		autoplayTimer = window.setInterval( nextSlide, autoplayDelay );
	};

	const stopAutoplay = () => {
		if ( autoplayTimer ) {
			window.clearInterval( autoplayTimer );
			autoplayTimer = null;
		}
	};

	dots.forEach( ( dot, index ) => {
		dot.addEventListener( 'click', () => {
			showSlide( index );
			startAutoplay();
		} );
	} );

	container.addEventListener( 'mouseenter', stopAutoplay );
	container.addEventListener( 'mouseleave', startAutoplay );

	showSlide( 0 );
	startAutoplay();
}

/**
 * مقداردهی اولیه اسلایدر نظرات مشتریان.
 *
 * @since 1.0.0
 */
function initTestimonialSlider() {
	createBajiSlider( {
		containerSelector: '.baji-testimonial-slider',
		slideSelector: '.baji-testimonial-slide',
		dotSelector: '.baji-testimonial-dot',
		activeSlideClass: 'block',
		inactiveSlideClass: 'hidden',
	} );
}

/**
 * افزودن انیمیشن ورودی (fade-up) به عناصر هنگام ورود به viewport.
 *
 * @since 1.0.0
 */
function initScrollAnimations() {
	const animatedElements = document.querySelectorAll(
		'.baji-product-card, .baji-category-card, .baji-post-card, .baji-dashboard-card'
	);

	if ( ! animatedElements.length || typeof window.IntersectionObserver === 'undefined' ) {
		return;
	}

	const observer = new IntersectionObserver(
		( entries, observerInstance ) => {
			entries.forEach( ( entry ) => {
				if ( entry.isIntersecting ) {
					entry.target.classList.add( 'animate-baji-fade-up' );
					observerInstance.unobserve( entry.target );
				}
			} );
		},
		{ threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
	);

	animatedElements.forEach( ( element ) => observer.observe( element ) );
}

/**
 * مقداردهی اولیه تمام ماژول‌های انیمیشن.
 *
 * @since 1.0.0
 */
function initBajiStyleAnimations() {
	initHeroSlider();
	initTestimonialSlider();
	initScrollAnimations();
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initBajiStyleAnimations );
} else {
	initBajiStyleAnimations();
}
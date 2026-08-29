/**
 * Homepage product stories controller.
 */
( () => {
	const viewer = document.getElementById( 'baji-product-stories-viewer' );
	const triggers = Array.from( document.querySelectorAll( '.baji-product-story-trigger' ) );

	if ( ! viewer || ! triggers.length ) return;

	const video = viewer.querySelector( '[data-story-video]' );
	const title = viewer.querySelector( '[data-story-title]' );
	const productLink = viewer.querySelector( '[data-story-product]' );
	const progressItems = Array.from( viewer.querySelectorAll( '.baji-story-progress span' ) );
	const soundButton = viewer.querySelector( '[data-story-sound]' );
	let activeIndex = 0;
	let returnFocus = null;

	function updateProgress() {
		progressItems.forEach( ( item, index ) => {
			item.classList.toggle( 'is-complete', index < activeIndex );
			item.classList.toggle( 'is-active', index === activeIndex );
			if ( index !== activeIndex ) item.style.removeProperty( '--story-progress' );
		} );
	}

	function showStory( index ) {
		activeIndex = ( index + triggers.length ) % triggers.length;
		const trigger = triggers[ activeIndex ];
		video.src = trigger.dataset.videoUrl;
		title.textContent = trigger.dataset.productName;
		productLink.href = trigger.dataset.productUrl;
		updateProgress();
		video.play().catch( () => {} );
	}

	function openStory( index, trigger ) {
		returnFocus = trigger;
		viewer.classList.add( 'is-open' );
		viewer.setAttribute( 'aria-hidden', 'false' );
		document.documentElement.classList.add( 'baji-story-open' );
		showStory( index );
		viewer.querySelector( 'button[data-story-close]' ).focus();
	}

	function closeStory() {
		video.pause();
		video.removeAttribute( 'src' );
		video.load();
		viewer.classList.remove( 'is-open' );
		viewer.setAttribute( 'aria-hidden', 'true' );
		document.documentElement.classList.remove( 'baji-story-open' );
		if ( returnFocus ) returnFocus.focus();
	}

	triggers.forEach( ( trigger, index ) => {
		trigger.addEventListener( 'click', () => openStory( index, trigger ) );
	} );

	viewer.querySelectorAll( '[data-story-close]' ).forEach( ( button ) => button.addEventListener( 'click', closeStory ) );
	viewer.querySelector( '[data-story-prev]' ).addEventListener( 'click', () => showStory( activeIndex - 1 ) );
	viewer.querySelector( '[data-story-next]' ).addEventListener( 'click', () => showStory( activeIndex + 1 ) );
	video.addEventListener( 'ended', () => {
		if ( activeIndex === triggers.length - 1 ) closeStory();
		else showStory( activeIndex + 1 );
	} );
	video.addEventListener( 'timeupdate', () => {
		const progress = video.duration ? Math.min( 1, video.currentTime / video.duration ) : 0;
		progressItems[ activeIndex ].style.setProperty( '--story-progress', progress );
	} );
	soundButton.addEventListener( 'click', () => {
		video.muted = ! video.muted;
		soundButton.setAttribute( 'aria-pressed', video.muted ? 'false' : 'true' );
		soundButton.querySelector( 'i' ).className = video.muted ? 'fa-solid fa-volume-xmark' : 'fa-solid fa-volume-high';
	} );
	document.addEventListener( 'keydown', ( event ) => {
		if ( ! viewer.classList.contains( 'is-open' ) ) return;
		if ( event.key === 'Escape' ) closeStory();
		if ( event.key === 'ArrowLeft' ) showStory( activeIndex + 1 );
		if ( event.key === 'ArrowRight' ) showStory( activeIndex - 1 );
	} );
} )();

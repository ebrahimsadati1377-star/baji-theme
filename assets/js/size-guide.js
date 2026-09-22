document.addEventListener('DOMContentLoaded', () => {
	const shortcut = document.querySelector('.baji-size-guide-shortcut');
	if (!shortcut) return;

	shortcut.addEventListener('click', (event) => {
		const tabLink =
			document.querySelector('.baji_size_guide_tab a[href="#tab-baji_size_guide"]') ||
			document.querySelector('a[href="#tab-baji_size_guide"]');

		if (!tabLink) return;

		event.preventDefault();
		tabLink.click();

		window.setTimeout(() => {
			const panel = document.getElementById('tab-baji_size_guide');
			if (!panel) return;

			const top = panel.getBoundingClientRect().top + window.scrollY - 110;
			window.scrollTo({ top, behavior: 'smooth' });
		}, 80);
	});
});

document.addEventListener('DOMContentLoaded', () => {
	const modal = document.getElementById('baji-size-guide-modal');
	const openButtons = document.querySelectorAll('[data-baji-size-guide-open]');
	const closeButtons = document.querySelectorAll('[data-baji-size-guide-close]');
	let lastFocused = null;

	const selectTableRow = (row) => {
		const table = row.closest('.baji-size-guide__table');
		if (!table) return;
		table.querySelectorAll('tbody tr').forEach((item) => item.classList.remove('is-selected'));
		row.classList.add('is-selected');
	};

	document.querySelectorAll('.baji-size-guide__table tbody tr').forEach((row) => {
		row.addEventListener('click', () => selectTableRow(row));
		row.addEventListener('keydown', (event) => {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				selectTableRow(row);
			}
		});
	});

	if (!modal) return;

	const dialog = modal.querySelector('.baji-size-guide-modal__dialog');
	const modalBody = modal.querySelector('.baji-size-guide-modal__body');

	const openModal = (trigger) => {
		lastFocused = trigger || document.activeElement;
		modal.classList.add('is-open');
		modal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('baji-size-guide-open');
		if (modalBody) modalBody.scrollTop = 0;

		window.setTimeout(() => {
			const closeButton = modal.querySelector('[data-baji-size-guide-close]');
			if (closeButton) closeButton.focus();
		}, 80);
	};

	const closeModal = () => {
		modal.classList.remove('is-open');
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('baji-size-guide-open');
		if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
	};

	openButtons.forEach((button) => {
		button.addEventListener('click', (event) => {
			event.preventDefault();
			openModal(button);
		});
	});

	closeButtons.forEach((button) => {
		button.addEventListener('click', closeModal);
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && modal.classList.contains('is-open')) {
			closeModal();
		}

		if (event.key === 'Tab' && modal.classList.contains('is-open') && dialog) {
			const focusable = dialog.querySelectorAll('button,[href],[tabindex]:not([tabindex="-1"])');
			if (!focusable.length) return;

			const first = focusable[0];
			const last = focusable[focusable.length - 1];

			if (event.shiftKey && document.activeElement === first) {
				event.preventDefault();
				last.focus();
			} else if (!event.shiftKey && document.activeElement === last) {
				event.preventDefault();
				first.focus();
			}
		}
	});
});

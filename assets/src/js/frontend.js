/* eslint-disable @wordpress/no-global-event-listener */
/**
 * SASS
 */
import '../sass/frontend.scss';

document.addEventListener('DOMContentLoaded', () => {
	/**
	 * JavaScript
	 */
	import('./menu').then(({ default: menuActions }) => {
		menuActions();
	});
});

/* eslint-disable no-console */
// import { elementIsAtTopOfViewport } from './utils';

const observeElement = (el, callback) => {
	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				callback(entry);
			});
		},
		{ threshold: 0 }
	);
	if (Array.isArray(el)) {
		el.forEach((element) => {
			observer.observe(element);
		});
	} else {
		observer.observe(el);
	}
};

export default function menuActions() {
	const header = document.querySelector('.nsp_header');
	const menuWrapper = header.querySelector('#nsp_nav_wrapper');
	const menuButton = menuWrapper.querySelector('.nav_title_wrapper');
	const navBar = header.querySelector('nav.wp-block-navigation');
	const navBrand = header.querySelector('#nsp_nav-brand');

	const handleIntersection = (entry) => {
		if (entry.isIntersecting) {
			header.classList.remove('nsp_fixed');
			navBrand.style.marginTop = '0px';
			navBrand.style.marginBottom = '0px';
		} else {
			const navTitle = navBrand.querySelector('.wp-block-site-title');
			const navTitleHeight = navTitle.scrollHeight;
			const menuWrapperHeight = menuWrapper.scrollHeight;
			navBrand.style.marginTop = `${navTitleHeight}px`;
			navBrand.style.marginBottom = `${menuWrapperHeight}px`;
			header.classList.add('nsp_fixed');
		}
	};

	observeElement(navBrand, handleIntersection);

	menuButton.addEventListener('click', () => {
		const navBarHeight = navBar.scrollHeight;
		menuButton.classList.toggle('open');
		navBar.classList.toggle('open');
		if (navBar.classList.contains('open')) {
			navBar.style.height = `${navBarHeight}px`;
		} else {
			navBar.style.height = '0px';
		}
	});
}

module.exports = {
	content: [
		'../*/*.php',
		'../**/*.php',
		'../assets/src/scss/*.scss',
		'../assets/src/js/*.js',
		'./safelist.txt',
	],
	darkMode: false, // or 'media' or 'class'
	theme: {
		colors: {
			primary: '#000000',
			foreground: '#7b7b7b',
			background: '#f6f5f0',
			black: '#000000',
		},
		extend: {
			container: {
				center: true,
			},
			maxWidth: {
				'8xl': '90rem',
			},
			width: {
				15: '3.75rem',
				26: '6.5rem',
			},
			margin: {
				7.5: '1.875rem',
				13: '3.25rem',
				15: '3.75rem',
			},
			padding: {
				7.5: '1.875rem',
				13: '3.25rem',
				15: '3.75rem',
			},
			spacing: {
				7.5: '1.875rem',
				13: '3.25rem',
				15: '3.75rem',
			},
			fontFamily: {
				sans: [
					'Raleway',
					'ui-sans-serif',
					'system-ui',
					'-apple-system',
					'BlinkMacSystemFont',
					'Segoe UI',
					'Roboto',
					'Helvetica Neue',
					'Arial',
					'Noto Sans',
					'sans-serif',
					'Apple Color Emoji',
					'Segoe UI Emoji',
					'Segoe UI Symbol',
					'Noto Color Emoji',
				],
				mono: [
					'ui-monospace',
					'SFMono-Regular',
					'Menlo',
					'Monaco',
					'Consolas',
					'Liberation Mono',
					'Courier New',
					'monospace',
				],
			},
			fontSize: {
				'wp-sm': 'var(--wp--preset--font-size--sm)',
				'wp-md': 'var(--wp--preset--font-size--medium)',
				'wp-lg': 'var(--wp--preset--font-size--large)',
				'wp-xl': 'var(--wp--preset--font-size--x-large)',
			},
			transitionDuration: {
				250: '250ms',
			},
		},
	},
	variants: {
		extend: {},
	},
	plugins: [],
	safelist: [
		'hidden',
		'lg:block',
		'lg:hidden',
		'text-justify',
		'font-mono',
		'fixed',
	],
};

<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WP_Tailtheme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wp_tailtheme_body_classes($classes)
{
	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (!is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter('body_class', 'wp_tailtheme_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wp_tailtheme_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'wp_tailtheme_pingback_header');

/**
 * Get the ID of a page template
 *
 * @param string $template_name
 * @return int
 */
function get_page_template_id($template_file)
{
	$args = array(
		'post_type'  => 'page',
		'meta_query' => array(
			array(
				'key'   => '_wp_page_template',
				'value' => $template_file
			)
		)
	);
	$pages = get_posts($args);
	if ($pages) {
		return $pages[0]->ID;
	}
	return null;
}

/**
 * Determine whether the current request should render the custom filmography page.
 *
 * @return bool
 */
function nsp_is_filmography_page()
{
	if (!is_page()) {
		return false;
	}

	$post = get_queried_object();
	if (!$post instanceof WP_Post) {
		return false;
	}

	$allowed_slugs = array(
		'filmografia',
		'filmography',
	);

	$normalized_title = sanitize_title(remove_accents($post->post_title));

	return in_array($post->post_name, $allowed_slugs, true) || in_array($normalized_title, $allowed_slugs, true);
}

/**
 * Provide the projects shown on the filmography page.
 *
 * @return array<int, array<string, mixed>>
 */
function nsp_get_filmography_projects()
{
	return array(
		array(
			'year' => '2025',
			'title' => 'A Paso de Vencedores',
			'subtitle' => 'La Ruta del BICIntenario',
			'format' => 'Documental',
			'description' => 'Recorrido audiovisual por la ruta del bicentenario. La presentación anunciada por Natalia Sobrevilla será el 8 de agosto a las 5:30 pm en el Centro Cultural de la Católica, dentro del Festival de Cine de Lima, fuera de competencia.',
			'url' => 'https://youtu.be/IpssHAjLK3Q',
			'image' => 'https://i.ytimg.com/vi/IpssHAjLK3Q/hqdefault.jpg',
			'brief_url' => '/wp-content/uploads/2026/08/A-paso-de-vencedores-2.pdf',
			'featured' => true,
			'meta' => array(
				array(
					'label' => 'Evento',
					'value' => 'Festival de Cine de Lima',
				),
				array(
					'label' => 'Lugar',
					'value' => 'Centro Cultural de la Católica',
				),
				array(
					'label' => 'Función',
					'value' => '8 de agosto, 5:30 pm',
				),
			),
		),
		array(
			'year' => '2016',
			'title' => 'El Desembarco',
			'format' => 'Cortometraje',
			'description' => 'Este corto imagina lo que fue la llegada de Flora Tristán al Puerto de Islay en Arequipa en 1833. Producido por Carpe Diem Films, fue filmado en Islay con un equipo arequipeño.',
			'url' => 'https://youtu.be/Z9SfTr54V80?si=kqN8Y7boLDj0ojgu',
			'image' => 'https://i.ytimg.com/vi/Z9SfTr54V80/hqdefault.jpg',
			'featured' => false,
			'meta' => array(
				array(
					'label' => 'Producción',
					'value' => 'Carpe Diem Films',
				),
				array(
					'label' => 'Guión y Dirección',
					'value' => 'Natalia Sobrevilla',
				),
			),
		),
	);
}

/**
 * Render the custom filmography page markup.
 *
 * @return string
 */
function nsp_render_filmography_content()
{
	$projects = nsp_get_filmography_projects();
	$featured_project = null;

	foreach ($projects as $project) {
		if (!empty($project['featured'])) {
			$featured_project = $project;
			break;
		}
	}

	if (!$featured_project) {
		$featured_project = reset($projects);
	}

	ob_start();
?>
	<div class="nsp-filmography">
		<?php if ($featured_project) : ?>
			<section class="nsp-filmography__feature">
				<a class="nsp-filmography__poster" href="<?php echo esc_url($featured_project['url']); ?>" target="_blank" rel="noreferrer noopener" aria-label="<?php echo esc_attr(sprintf('Ver %s en YouTube', $featured_project['title'])); ?>">
					<img src="<?php echo esc_url($featured_project['image']); ?>" alt="<?php echo esc_attr($featured_project['title']); ?>" loading="lazy" />
				</a>
				<div class="nsp-filmography__feature-copy">
					<p class="nsp-filmography__year"><?php echo esc_html($featured_project['year']); ?></p>
					<h2 class="nsp-filmography__title"><?php echo esc_html($featured_project['title']); ?></h2>
					<?php if (!empty($featured_project['subtitle'])) : ?>
						<h3 class="nsp-filmography__subtitle"><?php echo esc_html($featured_project['subtitle']); ?></h3>
					<?php endif; ?>
					<p class="nsp-filmography__format"><?php echo esc_html($featured_project['format']); ?></p>
					<p class="nsp-filmography__description"><?php echo esc_html($featured_project['description']); ?></p>

					<?php if (!empty($featured_project['meta'])) : ?>
						<div class="nsp-filmography__meta-grid">
							<?php foreach ($featured_project['meta'] as $meta_item) : ?>
								<div class="nsp-filmography__meta-item">
									<p class="nsp-filmography__meta-label"><?php echo esc_html($meta_item['label']); ?></p>
									<p class="nsp-filmography__meta-value"><?php echo esc_html($meta_item['value']); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<a class="nsp-filmography__cta" href="<?php echo esc_url($featured_project['brief_url']); ?>" target="_blank" rel="noreferrer noopener">
						Ver ficha
						<span aria-hidden="true">→</span>
					</a>
				</div>
			</section>
		<?php endif; ?>

		<div class="nsp-filmography__list">
			<?php foreach ($projects as $project) : ?>
				<?php if (!empty($project['featured'])) : ?>
					<?php continue; ?>
				<?php endif; ?>
				<article class="nsp-filmography__entry<?php echo !empty($project['featured']) ? ' is-featured' : ''; ?>">
					<p class="nsp-filmography__entry-year"><?php echo esc_html($project['year']); ?></p>
					<div class="nsp-filmography__entry-main">
						<h3 class="nsp-filmography__entry-title"><?php echo esc_html($project['title']); ?></h3>
						<p class="nsp-filmography__entry-format"><?php echo esc_html($project['format']); ?></p>
					</div>
					<p class="nsp-filmography__entry-description"><?php echo esc_html($project['description']); ?></p>
					<div class="nsp-filmography__entry-side">
						<?php if (!empty($project['meta'])) : ?>
							<?php foreach ($project['meta'] as $meta_item) : ?>
								<div class="nsp-filmography__entry-item">
									<p class="nsp-filmography__entry-label"><?php echo esc_html($meta_item['label']); ?></p>
									<p class="nsp-filmography__entry-value"><?php echo esc_html($meta_item['value']); ?></p>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<a class="nsp-filmography__entry-link" href="<?php echo esc_url($project['url']); ?>" target="_blank" rel="noreferrer noopener">
						Ver Video
						<span aria-hidden="true">→</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
<?php

	return trim(ob_get_clean());
}

/**
 * Replace the content of the filmography page with the custom layout.
 *
 * @param string $content
 * @return string
 */
function nsp_filter_filmography_content($content)
{
	if (is_admin() || !is_main_query() || !in_the_loop() || !nsp_is_filmography_page()) {
		return $content;
	}

	return nsp_render_filmography_content();
}
add_filter('the_content', 'nsp_filter_filmography_content');

/**
 * Add a page-specific body class for filmography styling hooks.
 *
 * @param array $classes
 * @return array
 */
function nsp_add_filmography_body_class($classes)
{
	if (nsp_is_filmography_page()) {
		$classes[] = 'nsp-filmography-page';
	}

	return $classes;
}
add_filter('body_class', 'nsp_add_filmography_body_class');

/**
 * Ensure the Filmografía page appears in the block navigation.
 *
 * @param string $block_content
 * @param array  $block
 * @return string
 */
function nsp_append_filmography_navigation_link($block_content, $block)
{
	if (is_admin() || !is_string($block_content) || empty($block['blockName']) || $block['blockName'] !== 'core/navigation') {
		return $block_content;
	}

	$page = get_page_by_path('filmografia', OBJECT, 'page');
	if (!$page instanceof WP_Post || $page->post_status !== 'publish') {
		return $block_content;
	}

	$label = 'Filmografía';
	if (stripos($block_content, $label) !== false) {
		return $block_content;
	}

	$link_classes = 'wp-block-navigation-item wp-block-navigation-link';
	if (nsp_is_filmography_page()) {
		$link_classes .= ' current-menu-item current_page_item';
	}

	$link_markup = sprintf(
		'<li class="%1$s"><a class="wp-block-navigation-item__content" href="%2$s"><span class="wp-block-navigation-item__label">%3$s</span></a></li>',
		esc_attr($link_classes),
		esc_url(get_permalink($page)),
		esc_html($label)
	);

	$closing_tag = '</ul>';
	$closing_pos = strripos($block_content, $closing_tag);

	if ($closing_pos === false) {
		return $block_content . $link_markup;
	}

	return substr($block_content, 0, $closing_pos) . $link_markup . substr($block_content, $closing_pos);
}
add_filter('render_block', 'nsp_append_filmography_navigation_link', 10, 2);

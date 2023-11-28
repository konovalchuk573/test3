<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Simple_List_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'simple_list_widget';
	}

	public function get_title() {
		return esc_html__( 'Simple List', 'simple-list-elementor' );
	}

	public function get_icon() {
		return 'eicon-bullet-list';
	}

	public function get_keywords() {
		return [ 'simple list', 'simple', 'list' ];
	}

	public function get_categories() {
		return [ 'simple-list-category' ];
	}

	public function get_style_depends() {
		return [ 'list-style' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'marker_section',
			[
				'label' => esc_html__( 'Type', 'simple-list-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'marker_type',
			[
				'label' => esc_html__( 'Marker Type', 'simple-list-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'ordered' => [
						'title' => esc_html__( 'Ordered List', 'elementor-list-widget' ),
						'icon' => 'eicon-editor-list-ol',
					],
					'unordered' => [
						'title' => esc_html__( 'Unordered List', 'elementor-list-widget' ),
						'icon' => 'eicon-editor-list-ul',
					],
				],
				'default' => 'ordered',
				'toggle' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_section',
			[
				'label' => esc_html__( 'Title', 'elementor-list-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'widget_title',
			[
				'label' => esc_html__( 'Title', 'elementor-list-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'elementor-list-widget' ),
				'placeholder' => esc_html__( 'Type your title here', 'elementor-list-widget' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( 'Image', 'elementor-list-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'elementor-list-widget' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'retina-image',
			[
				'label' => esc_html__( 'Choose Retina Image', 'elementor-list-widget' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'List', 'simple-list-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/* Start repeater */

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'simple-list-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Simple List Item', 'simple-list-elementor' ),
				'default' => esc_html__( 'Simple List Item', 'simple-list-elementor' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'simple-list-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://google.com', 'simple-list-elementor' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		/* End repeater */

		$this->add_control(
			'list_items',
			[
				'label' => esc_html__( 'List Items', 'simple-list-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_html__( 'List Item #1', 'simple-list-elementor' ),
						'link' => '',
					],
					[
						'text' => esc_html__( 'List Item #2', 'simple-list-elementor' ),
						'link' => '',
					],
					[
						'text' => esc_html__( 'List Item #3', 'simple-list-elementor' ),
						'link' => '',
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$html_tag = [
			'ordered' => 'ol',
			'unordered' => 'ul',
		];
		?>
		<div id="widget_<?php echo esc_html__(uniqID()); ?>" class="simple_list">
			<h2><?php echo $settings['widget_title']; ?></h2>
			<img src="<?php echo $settings['image']['url']; ?>" srcset="<?php echo $settings['retina-image']['url']; ?> 2x" />
			<<?php echo $html_tag[ $settings['marker_type'] ]; ?>>
				<?php foreach ( $settings['list_items'] as $index => $item ) : ?>
					<li>
						<?php
						if ( ! $item['link']['url'] ) {
							echo $item['text'];
						} else {
							?><a href="<?php echo esc_url( $item['link']['url'] ); ?>"><?php echo $item['text']; ?></a><?php
						}
						?>
					</li>
				<?php endforeach; ?>
			</<?php echo $html_tag[ $settings['marker_type'] ]; ?>>
		</div>
	<?php
	}

}
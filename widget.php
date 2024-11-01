<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class sdvpi_Custom_Widget_Final extends \Elementor\Widget_Base {

	// Your widget's name, title, icon and category
    public function get_name() {
        return 'sdvpi_video_player_image';
    }

    public function get_title() {
        return __( 'Video play On Image', 'sdvpi_video_player_image' );
    }

    public function get_icon() {
        return 'eicon-video-playlist';
    }

    public function get_categories() {
        return [ 'basic' ];
    }




	// Your widget's sidebar settings
    protected function _register_controls() {
	  $this->start_controls_section(
		'section_image',
		[
		  'label' => __( 'Settings', 'sdvpi' ),
		]
	  );

	  $this->add_control(
		'image',
		[
		  'label' => __( 'Choose image:', 'sdvpi' ),
		  'type' => \Elementor\Controls_Manager::MEDIA,
		  'default' => [
			'url' => \Elementor\Utils::get_placeholder_image_src(),
		  ],
		]
	  );

	  $this->add_control(
		'video',
		[
		  'label' => __( 'Choose video:', 'sdvpi' ),
		  'type' => \Elementor\Controls_Manager::MEDIA,
		  'media_type' => 'video',
		  'default' => [
			'url' => \Elementor\Utils::get_placeholder_image_src(),
		  ],
		]
	  );

	  
		$this->add_control(
			'color',
			[
				'label' => __( 'Play Button Color', 'sdvpi' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#0000ff', // default color is blue (#0000ff)
				'selectors' => [
					'{{WRAPPER}} .sdvpi_video-play-button span' => 'border-left-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'audio_switcher',
			[
				'label' => __( 'Mute video sound', 'sdvpi' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'sdvpi' ),
				'label_off' => __( 'Off', 'sdvpi' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'loop_video',
			[
				'label' => __( 'loop video', 'sdvpi' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'sdvpi' ),
				'label_off' => __( 'Off', 'sdvpi' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

	  

	  $this->end_controls_section();


	  $this->start_controls_section(
		'section_size',
		[
		  'label' => __( 'Size & Shape', 'sdvpi' ),
		]
	  );

	  $this->add_control(
		'width',
		[
			'label' => __( 'Width (%)', 'sdvpi' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'range' => [
				'percent' => [
					'min' => 1,
					'max' => 100,
				],
			],
			'default' => [
				'size' => 100,
			],
		]
	  );

	  $this->add_control(
		'height',
		[
			'label' => __( 'Height (px)', 'sdvpi' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => 20,
					'max' => 1500,
				],
			],
			'default' => [
				'size' => 360,
			],
		]
	  );

	  $this->add_control(
		'radius',
		[
			'label' => __( 'Radius (px)', 'sdvpi' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 750,
				],
			],
			'default' => [
				'size' => 25,
			],
		]
	  );

	  $this->end_controls_section();

    }

	





	// What your widget displays on the front-end
    protected function render() {
		$settings = $this->get_settings_for_display();

		$image_url = $settings['image']['url'];
		$video_url = $settings['video']['url'];
		
		$width = $settings['width']['size'] . '%';
		$height = $settings['height']['size'] . 'px';
		$radius = $settings['radius']['size'] . 'px';

		$muted = ( 'yes' === $settings['audio_switcher'] );
		$muted_attr = $muted ? 'muted' : '';

		$loop = ( 'yes' === $settings['loop_video'] );
		$loop_attr = $loop ? 'loop' : '';

		$widget = $this->get_data();
		$unique_id = $widget['id'];

        ?>
		<div id="sdvpiDiv<?php echo esc_attr($unique_id); ?>">
		  
		  <div id="sdvpiOverlay<?php echo esc_attr($unique_id); ?>">
		  	<button id="sdvpiplaybtn<?php echo esc_attr($unique_id); ?>" class="sdvpi_video-play-button"> <span></span> </button>
		  </div>
		  <video id="sdvpiVideo<?php echo esc_attr($unique_id); ?>" src="<?php echo esc_url($video_url); ?>" style="display: none;" <?php echo esc_attr($muted_attr); ?> <?php echo esc_attr($loop_attr); ?> playsinline></video>
		  <img id="sdvpiImage<?php echo esc_attr($unique_id); ?>" src="<?php echo esc_url($image_url); ?>">
		</div>

		<style>
			#sdvpiDiv<?php echo esc_attr($unique_id); ?> {
			  height: <?php echo esc_attr($height); ?>;
			  width: <?php echo esc_attr($width); ?>;
			  position: relative;
			  border-radius: <?php echo esc_attr($radius); ?>;
			  overflow: hidden;
			}

			#sdvpiImage<?php echo esc_attr($unique_id); ?> {
			  width: 100%;
			  height: 100%;
			  object-fit: cover;
			}

			#sdvpiVideo<?php echo esc_attr($unique_id); ?> {
			  width: 100%;
			  height: 100%;
			  object-fit: cover;
			}

			
			#sdvpiOverlay<?php echo esc_attr($unique_id); ?> {
			   position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
			  
			}
			.sdvpi_video-play-button span {
				border-left: 15px solid;
			}
			
			
		</style>

		<script>
			document.getElementById("sdvpiplaybtn<?php echo esc_attr($unique_id); ?>").addEventListener("click", showVideo);
			document.getElementById("sdvpiVideo<?php echo esc_attr($unique_id); ?>").addEventListener("click", hideVideo);

			function showVideo() {
			  // Get the video element
			  var video = document.getElementById("sdvpiVideo<?php echo esc_attr($unique_id); ?>");

			  // Get the image element
			  var image = document.getElementById("sdvpiplaybtn<?php echo esc_attr($unique_id); ?>");

			  // Get the overlay element
			  var overlay = document.getElementById("sdvpiOverlay<?php echo esc_attr($unique_id); ?>");

			  // Hide the image and show the video and overlay
			  image.style.display = "none";
			  video.style.display = "block";
			  overlay.style.display = "none";

			  // Play the video
			  video.play();
			}

			function hideVideo() {
			  // Get the video element
			  var video = document.getElementById("sdvpiVideo<?php echo esc_attr($unique_id); ?>");

			  // Get the image element
			  var image = document.getElementById("sdvpiplaybtn<?php echo esc_attr($unique_id); ?>");

			  // Get the overlay element
			  var overlay = document.getElementById("sdvpiOverlay<?php echo esc_attr($unique_id); ?>");

			  // Hide the video, and show the image and overlay play button
			  video.style.display = "none";
			  overlay.style.display = "block";
			  image.style.display = "block";

			  // Pause the video on click, and set its current play time back to the start
			  video.pause();
			  video.currentTime = 0;
			}
		</script>
		<?php
    }

}

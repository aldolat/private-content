<?php
/**
 * The plugin core class.
 *
 * @since 5.1
 * @package PrivateContent
 */

/*
 * Shortcode to display a portion of a post content only to users of a specific or multiple roles,
 * or to a single or multiple users.
 *
 * @example
 * [private role="administrator"]Text for administrators[/private]
 * [private role="author"]Text for authors[/private]
 * [private role="subscriber-only"]Text for subscribers only[/private]
 * [private role="visitor-only"]Text for visitors only[/private]
 *
 * For more information, see the official wiki at <https://github.com/aldolat/private-content/wiki>.
 */

/**
 * UBN Private class.
 *
 * @since 5.1
 */
class UBN_Private {
	/**
	 * Plugin version.
	 *
	 * @var string $plugin_version
	 * @access private
	 * @since 5.1
	 */
	private $plugin_version;

	/**
	 * Fires the initial steps for the plugin.
	 *
	 * @access public
	 * @since 5.1
	 */
	public function __construct() {
		// Define the plugin version.
		$this->plugin_version = '6.5.0';
	}

	/**
	 * Return the plugin version.
	 *
	 * @access public
	 * @return string $plugin_version The version of the plugin.
	 * @since 5.1
	 */
	public function get_plugin_version() {
		return $this->plugin_version;
	}

	/**
	 * Run the plugin.
	 *
	 * @access public
	 * @since 5.1
	 */
	public function run() {
		/**
		 * Add the capabilities on plugin activation.
		 *
		 * @since 4.2
		 */
		register_activation_hook( __FILE__, array( $this, 'ubn_private_add_cap' ) );

		/**
		 * Make sure we have the right capabilities during plugin lifetime.
		 *
		 * @since 2.0.0
		 */
		add_action( 'init', array( $this, 'ubn_private_check_capability_exists' ) );

		/**
		 * Launch Private Content.
		 *
		 * @since 4.2
		 */
		add_action( 'plugins_loaded', array( $this, 'ubn_private_translation' ) );

		/**
		 * Create the shortcode `private`.
		 *
		 * @since 1.0
		 */
		if ( ! shortcode_exists( 'private' ) ) {
			add_shortcode( 'private', array( $this, 'ubn_private_content' ) );
		}
		/**
		 * Add an extra shortcode, in case the old is used elsewhere.
		 *
		 * @since 4.3
		 */
		if ( ! shortcode_exists( 'ubn_private' ) ) {
			add_shortcode( 'ubn_private', array( $this, 'ubn_private_content' ) );
		}
	}

	/**
	 * Add the new capabilities to WordPress standard roles.
	 * Note that the Administrator role doesn't need any custom capabilities.
	 *
	 * @global object $wp_roles The WordPress roles.
	 * @access protected
	 * @since 2.2
	 */
	protected function ubn_private_add_cap() {
		global $wp_roles;
		$wp_roles->add_cap( 'editor', 'read_ubn_editor_notes' );
		$wp_roles->add_cap( 'author', 'read_ubn_author_notes' );
		$wp_roles->add_cap( 'contributor', 'read_ubn_contributor_notes' );
		$wp_roles->add_cap( 'subscriber', 'read_ubn_subscriber_notes' );
	}

	/**
	 * Check if Editor role has 'read_ubn_editor_notes' capabilities.
	 * This check is useful only when upgrading this plugin from version below 2.0.
	 * This function will be removed in the future.
	 *
	 * @access public
	 * @since 2.0
	 */
	public function ubn_private_check_capability_exists() {
		$editor_role = get_role( 'editor' );

		if ( ! isset( $editor_role->capabilities['read_ubn_editor_notes'] ) ) {
			$this->ubn_private_add_cap();
		}
	}

	/**
	 * Translate Private Content.
	 *
	 * @access public
	 * @since 4.2
	 */
	public function ubn_private_translation() {
		/*
		 * Make plugin available for i18n.
		 * Translations must be archived in the /languages/ directory.
		 * The name of each translation file must be, for example:
		 *
		 * ITALIAN:
		 * private-content-it_IT.po
		 * private-content-it_IT.mo
		 *
		 * GERMAN:
		 * private-content-de_DE.po
		 * private-content-de_DE.po
		 *
		 * and so on.
		 */
		load_plugin_textdomain( 'private-content', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Create the shortcode 'private'.
	 *
	 * @param array $atts {
	 *    The array containing the user defined parameters.
	 *
	 *    @type string $role        The intended role to view the note.
	 *                              It can be:
	 *                                  "administrator",
	 *                                  "editor",
	 *                                  "editor-only",
	 *                                  "author",
	 *                                  "author-only",
	 *                                  "contributor",
	 *                                  "contributor-only",
	 *                                  "subscriber",
	 *                                  "subscriber-only",
	 *                                  "visitor-only",
	 *                                  "none" (when used, you must specify a recipients list in $recipient),
	 *                                  "custom" (when used, you must specify a recipients list in $custom_role),
	 *                                  "custom-only" (when used, you must specify a recipients list in $custom_role),
	 *                                  "post-author",
	 *                                  "post-author-only",
	 *                                  "post-author-custom" (when used, you must specify a recipients list in $custom_role).
	 *    @type string $recipient   The target role to view the note.
	 *                              It is used when $role = "none".
	 *    @type string $custom_role The custom roles, comma separated.
	 *                              It is used when $role = "custom".
	 *                              It accepts both usernames and user IDs, even mixing them.
	 *    @type bool   $reverse     Reverse the logic of recipient.
	 *                              If activated, users added in $recipient or in $custom_role
	 *                              will not read the private note.
	 *    @type string $align       The alignment of text.
	 *                              It can be:
	 *                              "left"
	 *                              "center"
	 *                              "right"
	 *                              "justify"
	 *    @type string $alt         The alternate text to be displayed when the viewer is not the target user.
	 *    @type string $container   The container for the note.
	 *                              It can be:
	 *                              "p"
	 *                              "div"
	 *                              "span"
	 *    @type string $id          The ID selectors, comma separated.
	 *                              If composed by more words, the words must be separated by a dash or by an underscore,
	 *                              otherwise the words will be considered as separated ID names.
	 *    @type string $class       The class selectors, comma separated.
	 *                              If composed by more words, the words must be separated by a dash or by an underscore,
	 *                              otherwise the words will be considered as separated class names.
	 * }
	 *
	 * @access public
	 * @param null  $content The content is defined inside the two square brackets.
	 * @since 1.0
	 * @example [private role="editor" align="center" alt="Please, login to view this note." container="div"]All Editors - Meeting on Slack every day at 9am![/private]
	 */
	public function ubn_private_content( $atts, $content = null ) {
		$defaults = array(
			'role'        => 'administrator',   // The default role if none has been provided.
			'custom_role' => '',
			'recipient'   => '',
			'reverse'     => false,
			'align'       => '',
			'alt'         => '',
			'container'   => 'p',
			'id'          => '',
			'class'       => '',
		);

		$atts = shortcode_atts( $defaults, $atts );

		// Sanitize the user input.
		$atts = $this->sanitize( $atts );

		// Get the align for the text of the paragraph.
		$align_style = $this->get_align( $atts['align'] );

		// Get the container for the text.
		$containers      = $this->get_container( $atts['container'] );
		$container_open  = $containers['open'];
		$container_close = $containers['close'];

		// Get the text for the shortcode.
		$args = array(
			'role'            => $atts['role'],
			'custom_role'     => $atts['custom_role'],
			'recipient'       => $atts['recipient'],
			'reverse'         => $atts['reverse'],
			'align_style'     => $align_style,
			'alt'             => $atts['alt'],
			'container_open'  => $container_open,
			'container_close' => $container_close,
			'id'              => $atts['id'],
			'class'           => $atts['class'],
			'content'         => $content,
		);
		$text = $this->get_text( $args );

		// Return the shortcode.
		if ( isset( $text ) && ! empty( $text ) && ! is_feed() ) {
			// The do_shortcode function is necessary to let WordPress execute another nested shortcode.
			return do_shortcode( $text );
		}
	}

	/**
	 * Sanitize user input before processing.
	 *
	 * @param array $atts The user input array.
	 * @return array $atts The sanitized array.
	 * @access protected
	 * @since 4.3.0 As standalone function.
	 * @since 5.1 As method in class.
	 */
	protected function sanitize( $atts ) {
		$atts['role']        = wp_strip_all_tags( $atts['role'] );
		$atts['custom_role'] = wp_strip_all_tags( $atts['custom_role'] );
		$atts['recipient']   = wp_strip_all_tags( $atts['recipient'] );
		$atts['align']       = wp_strip_all_tags( $atts['align'] );
		$atts['id']          = wp_strip_all_tags( $atts['id'] );
		$atts['class']       = wp_strip_all_tags( $atts['class'] );
		$atts['container']   = wp_strip_all_tags( $atts['container'] );

		/*
		 * Allow the usage of some HTML tags in the shortcode "alt" parameter.
		 *
		 * By itself, WordPress allows the usage of some basic HTML tags,
		 * such as <b>, <em>, <strong>, but not <a>.
		 * @see https://codex.wordpress.org/Shortcode_API#HTML
		 *
		 * @since 4.1
		 */
		// Decode any HTML entity into its applicable character, so that `wp_kses` can operate.
		// The encoding is performed by the WordPress visual editor.
		$atts['alt'] = html_entity_decode( $atts['alt'] );
		// Define the allowed HTML tags for `wp_kses`.
		$allowed_html = array(
			'em'     => array(),
			'i'      => array(),
			'strong' => array(),
			'b'      => array(),
			'a'      => array(
				'href'  => array(),
				'title' => array(),
			),
		);
		// Remove all HTML tags, except `em`, `i`, `strong, `b`, `a`.
		$atts['alt'] = wp_kses( $atts['alt'], $allowed_html );

		return $atts;
	}

	/**
	 * Return the CSS style for aligning the paragraph.
	 *
	 * @param string $align The user input for align.
	 * @return string $align_style The CSS style for aligning the paragraph.
	 * @access protected
	 * @since 5.1
	 */
	protected function get_align( $align ) {
		$align_style = '';

		if ( empty( $align ) ) {
			return $align_style;
		}

		switch ( $align ) {
			case 'left':
				$align_style = ' style="text-align: left;"';
				break;

			case 'center':
				$align_style = ' style="text-align: center;"';
				break;

			case 'right':
				$align_style = ' style="text-align: right;"';
				break;

			case 'justify':
				$align_style = ' style="text-align: justify;"';
				break;

			default:
				$align_style = '';
		}

		return apply_filters( 'ubn_private_align_style', $align_style );
	}

	/**
	 * Return the container for the paragraph.
	 *
	 * @param string $container The user input for the container.
	 * @return array $containers The array for opening and closing the container.
	 * @access protected
	 * @since 5.1
	 */
	protected function get_container( $container ) {
		switch ( $container ) {
			case 'p':
				$containers = array(
					'open'  => '<p',
					'close' => '</p>',
				);
				break;

			case 'div':
				$containers = array(
					'open'  => '<div',
					'close' => '</div>',
				);
				break;

			case 'span':
				$containers = array(
					'open'  => '<span',
					'close' => '</span>',
				);
				break;

			default:
				$containers = array(
					'open'  => '<p',
					'close' => '</p>',
				);
		}

		return apply_filters( 'ubn_private_containers', $containers );
	}

	/**
	 * Return the processed text for the shortcode.
	 *
	 * @param array $args The array containing the input values.
	 * @return string $text The processed text for the shortcode.
	 * @access protected
	 * @since 5.1
	 * @since 6.4.0 Added post-author and post-author-only cases.
	 * @since 6.5.0 Added post-author-custom case.
	 */
	protected function get_text( $args ) {
		$defaults = array(
			'role'            => 'administrator',   // The default role if none has been provided.
			'custom_role'     => '',
			'recipient'       => '',
			'reverse'         => false,
			'align_style'     => '',
			'alt'             => '',
			'container_open'  => '<p',
			'container_close' => '</p>',
			'id'              => '',
			'class'           => '',
			'content'         => null,
		);

		$args = wp_parse_args( $args, $defaults );

		$text = '';

		switch ( $args['role'] ) {

			case 'administrator':
				if ( current_user_can( 'create_users' ) ) {
					$class = $this->get_selector( 'class', 'private administrator-content', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'editor':
				if ( current_user_can( 'edit_others_posts' ) ) {
					$class = $this->get_selector( 'class', 'private editor-content', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'editor-only':
				if ( current_user_can( 'read_ubn_editor_notes' ) ) {
					$class = $this->get_selector( 'class', 'private editor-content editor-only', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'author':
				if ( current_user_can( 'publish_posts' ) ) {
					$class = $this->get_selector( 'class', 'private author-content', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'author-only':
				if ( current_user_can( 'read_ubn_author_notes' ) ) {
					$class = $this->get_selector( 'class', 'private author-content author-only', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'contributor':
				if ( current_user_can( 'edit_posts' ) ) {
					$class = $this->get_selector( 'class', 'private contributor-content', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'contributor-only':
				if ( current_user_can( 'read_ubn_contributor_notes' ) ) {
					$class = $this->get_selector( 'class', 'private contributor-content contributor-only', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'subscriber':
				if ( current_user_can( 'read' ) ) {
					$class = $this->get_selector( 'class', 'private subscriber-content', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'subscriber-only':
				if ( current_user_can( 'read_ubn_subscriber_notes' ) ) {
					$class = $this->get_selector( 'class', 'private subscriber-content subscriber-only', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			/*
			 * `visitor` and `visitor-only` are equivalent and have the same behaviour,
			 * because the check for the role is `! is_user_logged_in()` which excludes any other role.
			 */
			case 'visitor':
			case 'visitor-only':
				if ( ! is_user_logged_in() || current_user_can( 'create_users' ) ) {
					$class = $this->get_selector( 'class', 'private visitor-content visitor-only', $args['class'] );
					$text  = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'none':
				$all_recipients = array_map( 'trim', explode( ',', $args['recipient'] ) );
				$current_user   = wp_get_current_user();

				if ( $args['reverse'] ) {
					/* Reverse the logic of the function.
					 * Users added in recipient WILL NOT see the private note.
					 */
					if (
						in_array( $current_user->user_login, $all_recipients, true ) ||
						in_array( $current_user->ID, $this->arrstr_to_arrint( $all_recipients ), true )
					) {
						if ( $args['alt'] ) {
							$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
							$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
						}
					} else {
						$class = $this->get_selector( 'class', 'private user-content user-only-reverse', $args['class'] );
						$text  = apply_filters( 'ubn_private_content', $args['content'] );
					}
				} else {
					/* The standard logic of the function.
					 * Users added in recipient WILL see the private note.
					 */
					if (
						in_array( $current_user->user_login, $all_recipients, true ) ||
						in_array( $current_user->ID, $this->arrstr_to_arrint( $all_recipients ), true )
					) {
						$class = $this->get_selector(
							'class',
							'private user-content user-only ' . esc_attr( $current_user->user_login ) . '-only user-' . esc_attr( $current_user->ID ) . '-only',
							$args['class']
						);
						$text  = apply_filters( 'ubn_private_content', $args['content'] );
					} else {
						if ( $args['alt'] ) {
							$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
							$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
						}
					}
				}
				break;

			case 'custom':
				$custom_role  = $this->prepare_custom_role( $args['custom_role'] );
				$current_user = wp_get_current_user();

				if ( $args['reverse'] ) {
					/* Reverse the logic of the function.
					 * Users added in custom_role WILL NOT see the private note, unless they are Administrators.
					 */
					if (
						// Check if one of the current user roles is among excluded roles.
						array_intersect( $custom_role, (array) $current_user->roles ) && ! current_user_can( 'create_users' )
					) {
						// Current user IS in the excluded roles, so he can't read.
						if ( $args['alt'] ) {
							$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
							$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
						}
					} else {
						// Current user IS NOT in the excluded roles, so he can read.
						$custom_role_class = $this->prepare_custom_role_class( $args['custom_role'] );

						$class = $this->get_selector(
							'class',
							'private',
							$custom_role_class . '-content ' . $args['class']
						);

						$text = apply_filters( 'ubn_private_content', $args['content'] );
					}
				} else {
					/* The standard logic of the function.
					 * Users added in custom_role WILL see the private note.
					 */
					if (
						// Check if one of the current user roles is among authorized roles.
						array_intersect( $custom_role, (array) $current_user->roles ) ||
						// Current user is an administrator, so he can read.
						( $this->custom_role_exists( $custom_role ) && current_user_can( 'create_users' ) )
					) {
						$custom_role_class = $this->prepare_custom_role_class( $args['custom_role'] );

						$class = $this->get_selector(
							'class',
							'private',
							$custom_role_class . '-content ' . $args['class']
						);

						$text = apply_filters( 'ubn_private_content', $args['content'] );
					} else {
						if ( $args['alt'] ) {
							$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
							$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
						}
					}
				}
				break;

			case 'custom-only':
				$custom_role  = $this->prepare_custom_role( $args['custom_role'] );
				$current_user = wp_get_current_user();

				if ( array_intersect( $custom_role, (array) $current_user->roles ) ) {
					$custom_role_class = $this->prepare_custom_role_class( $args['custom_role'] );

					$class = $this->get_selector(
						'class',
						'private',
						$custom_role_class . '-content ' . $args['class']
					);

					$text = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'post-author':
				$post_author  = get_the_author_meta( 'ID' );
				$current_user = wp_get_current_user();

				if ( $post_author === $current_user->ID || current_user_can( 'create_users' ) ) {
					$class = $this->get_selector(
						'class',
						'private post-author-content',
						get_the_author_meta( 'user_login' ) . '-content ' . $args['class']
					);

					$text = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'post-author-only':
				$post_author  = get_the_author_meta( 'ID' );
				$current_user = wp_get_current_user();

				if ( $post_author === $current_user->ID ) {
					$class = $this->get_selector(
						'class',
						'private post-author-content post-author-content-only',
						get_the_author_meta( 'user_login' ) . '-content ' . $args['class']
					);

					$text = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			case 'post-author-custom':
				// Get the post author info object.
				$post_author_info = get_userdata( get_the_author_meta( 'ID' ) );
				// Get the post author roles as an array.
				$post_author_roles = $post_author_info->roles;

				// Get the custom role.
				$custom_role = $this->prepare_custom_role( $args['custom_role'] );

				// Check if the post author has the role defined in $custom_role.
				if ( array_intersect( $custom_role, (array) $post_author_roles ) ) {
					$custom_role_class = $this->prepare_custom_role_class( $args['custom_role'] );

					$class = $this->get_selector(
						'class',
						'private post-author-custom',
						get_the_author_meta( 'user_login' ) . '-content ' . $custom_role_class . ' ' . $args['class']
					);

					$text = apply_filters( 'ubn_private_content', $args['content'] );
				} else {
					if ( $args['alt'] ) {
						$class = $this->get_selector( 'class', 'private alt-text', $args['class'] );
						$text  = apply_filters( 'ubn_private_alt', $args['alt'] );
					}
				}
				break;

			default:
				$text = '';
		}

		if ( '' !== $text ) { // $text is not empty.
			$args['id'] ? $container_id = $this->get_selector( 'id', '', $args['id'] ) : $container_id = '';

			$text = $args['container_open'] . ' ' . $container_id . ' ' . $class . $args['align_style'] . '>' . $text . $args['container_close'];

			/**
			 * Filter $text if not empty.
			 *
			 * @since 5.1 Initial single filter available only when $text is not empty.
			 */
			$text = apply_filters( 'ubn_private_text', $text );
		} else { // $text is empty.
			/**
			 * Filter $text if empty.
			 *
			 * @since 6.1 Added filter when $text is empty.
			 */
			$text = apply_filters( 'ubn_private_text_empty', $text );
		}

		return $text;
	}

	/**
	 * Prepare custom role(s) from user input.
	 *
	 * @param  string $custom_role The custom role entered by user.
	 * @return array  The custom role(s) as an array.
	 * @access private
	 * @since 6.1
	 */
	private function prepare_custom_role( $custom_role ) {
		// Convert any space into a comma.
		$custom_role = preg_replace( '([\s]+)', ',', $custom_role );

		// Remove any leading and trailing comma.
		$custom_role = trim( $custom_role, ',' );

		// Convert all characters into lowercase.
		$custom_role = strtolower( $custom_role );

		// Make $custom roles an array.
		$custom_role = explode( ',', $custom_role );

		return $custom_role;
	}

	/**
	 * Check if role exists among defined roles.
	 *
	 * @param array $custom_role The array containing the custom roles to check.
	 * @return bool True if custom role exists, false if not.
	 * @access private
	 * @since 6.1
	 */
	private function custom_role_exists( $custom_role ) {
		if ( ! is_array( $custom_role ) ) {
			return false;
		}

		foreach ( $custom_role as $role ) {
			if ( get_role( $role ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Prepare the HTML class(es) from the custom role(s).
	 *
	 * @param string $custom_role The custom role(s).
	 * @return string The custom role(s) converted into a classname.
	 * @access private
	 * @since 6.2
	 */
	private function prepare_custom_role_class( $custom_role ) {
		// Remove any space.
		$custom_role = preg_replace( '([\s,_]+)', '-', $custom_role );

		// Remove any leading and trailing dash.
		$custom_role = rtrim( $custom_role, '-' );

		return $custom_role;
	}

	/**
	 * Sanitize classes entered by the user.
	 *
	 * @param string|array $classes The classe(s) entered by the user.
	 * @param string $sep The separator between single classes, if $classes is a string.
	 * @link https://developer.wordpress.org/reference/functions/sanitize_html_class/#comment-2084
	 * @access private
	 * @since 6.2
	 */
	private function sanitize_html_classes( $classes, $sep = ',' ) {
		$output = '';

		if ( ! is_array( $classes ) ) {
			$classes = preg_replace( '([\s,]+)', $sep, $classes );
			$classes = trim( $classes, ' ,' );
			$classes = explode( $sep, $classes );
		}

		if ( ! empty( $classes ) ) {
			foreach ( $classes as $class ) {
				$output .= sanitize_html_class( $class ) . ' ';
			}
		}

		$output = rtrim( strtolower( $output ), ' ' );

		return $output;
	}

	/**
	 * Get HTML selector.
	 *
	 * @param string $type The selector type (class or id).
	 * @param string $fixed_selector The selectors that must be unchanged.
	 * @param string $user_selector The selector name (or names comma separated) entered by user.
	 * @access private
	 * @since 6.2
	 */
	private function get_selector( $type = 'class', $fixed_selector = '', $user_selector = '' ) {
		if ( ! is_string( $user_selector ) ) {
			return;
		}

		$user_selector = $this->sanitize_html_classes( $user_selector );

		switch ( $type ) {
			case 'class':
				$output = 'class="' . rtrim( $fixed_selector . ' ' . $user_selector ) . '"';
				$output = apply_filters( 'ubn_private_class_selector', $output );
				break;

			case 'id':
				$output = 'id="' . $user_selector . '"';
				$output = apply_filters( 'ubn_private_id_selector', $output );
				break;

			default:
				$output = '';
				break;
		}

		return $output;
	}

	/**
	 * Converts an array of strings into an array of integers.
	 *
	 * @param array  $array The input array of strings.
	 * @return array $array The output array of integers.
	 * @since 6.3
	 */
	private function arrstr_to_arrint( $array ) {
		if ( ! is_array( $array ) ) {
			return;
		}

		foreach ( $array as &$value ) {
			if ( is_numeric( $value ) ) {
				// is_numeric finds whether a variable is a number or a numeric string.
				$value = intval( $value );
			}
		}

		return $array;
	}
}

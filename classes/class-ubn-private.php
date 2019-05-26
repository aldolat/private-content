<?php
/**
 * The plugin core class.
 *
 * @since 6.0.0
 * @package PrivateContent
 */

/*
 * Shortcode to display private post content only to users of a specific role.
 *
 * @example
 * [private role="administrator"]Text for administrators[/private]
 * [private role="editor" align="center"]Text for editors[/private]
 * [private role="author"]Text for authors[/private]
 * [private role="author-only"]Text for authors only[/private]
 * [private role="contributor" align="right"]Text for contributors[/private]
 * [private role="subscriber" align="justify"]Text for subscribers[/private]
 * [private role="subscriber-only" align="justify"]Text for subscribers only[/private]
 * [private role="visitor-only"]Text for visitors only[/private]
 *
 * Please, note that an administrator can read an editor private content or a subscriber private content, and so on.
 * Same thing for editor, author, contributor, and subscriber: a higher role can read a lower role content.
 *
 * If you want to show a note only to a certain role, you have to use a <role>-only option.
 * For example:
 * [private role="author-only"]Text for authors only[/private]
 * In this way, Administrators and Editors (roles higher than Editors) can't read this note.
 *
 * If you want to show an alternate text in case the user can't read, you can use `alt` option:
 * [private role="author" alt="You have not rights to read this."]Text for authors only[/private]
 * Please, take note that the alternate text, if defined, is always publicly displayed.
 *
 * WordPress Roles in descending order:
 * Administrator,
 * Editor,
 * Author,
 * Contributor,
 * Subscriber.
 */

/**
 * UBN Private class.
 *
 * @since 6.0.0
 */
class UBN_Private {
	/**
	 * Plugin version
	 *
	 * @var string $plugin_version
	 * @since 6.0.0
	 */
	public $plugin_version;

	/**
	 * Fires the initial actions for the plugin.
	 *
	 * @since 6.0.0
	 */
	public function __construct() {
		/**
		 * Define the plugin version.
		 *
		 * @since 4.2
		 */
		$this->plugin_version = '6.0.0';
	}

	/**
	 * Run the plugin.
	 *
	 * @since 6.0.0
	 */
	public function run() {
		/**
		 * Add the capabilities on plugin activation.
		 *
		 * @since 4.2
		 */
		register_activation_hook( __FILE__, array( $this, 'ubn_private_add_cap' ) );

		/**
		 * Make sure we have the right capabilities during plugin's lifetime.
		 *
		 * @since ??? (TODO)
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
	 * @since ??? (TODO)
	 */
	private function ubn_private_add_cap() {
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
	 * @since 2.0.0
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
	 *    @type string $role      The intended role to view the note.
	 *                            It can be:
	 *                            "administrator",
	 *                            "editor",
	 *                            "editor-only",
	 *                            "author",
	 *                            "author-only",
	 *                            "contributor",
	 *                            "contributor-only",
	 *                            "subscriber",
	 *                            "subscriber-only",
	 *                            "visitor-only",
	 *                            "none". When using "none", you must specify a recipients list in $recipient.
	 *    @type string $recipient The target role to view the note.
	 *                            It is used when $role = "none".
	 *    @type bool   $reverse   Reverse the logic of recipient.
	 *                            If activated, users added in $recipient will not read the private note.
	 *    @type string $align     The alignment of text.
	 *                            It can be:
	 *                            "left"
	 *                            "center"
	 *                            "right"
	 *                            "justify"
	 *    @type string $alt       The alternate text to be displayed when the viewer is not the target user.
	 *    @type string $container The container for the note.
	 *                            It can be:
	 *                            "p"
	 *                            "div"
	 *                            "span"
	 * }
	 * @param null  $content The content is defined inside the two square brackets.
	 * @example [private role="editor" align="center" alt="Please, login to view this note." container="div"]All Editors - Meeting on Slack every day at 9am![/private]
	 */
	public function ubn_private_content( $atts, $content = null ) {
		$defaults = array(
			'role'      => 'administrator', // The default role if none has been provided.
			'recipient' => '',
			'reverse'   => false,
			'align'     => '',
			'alt'       => '',
			'container' => 'p',
		);

		$atts = shortcode_atts( $defaults, $atts );

		$role      = $atts['role'];
		$recipient = $atts['recipient'];
		$reverse   = $atts['reverse'];
		$align     = $atts['align'];
		$alt       = $atts['alt'];
		$container = $atts['container'];

		/*
		 * Input sanitization.
		 * @since 4.3
		 */
		$role      = wp_strip_all_tags( $role );
		$recipient = wp_strip_all_tags( $recipient );
		$align     = wp_strip_all_tags( $align );
		// $alt is processed below.
		$container = wp_strip_all_tags( $container );

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
		$alt = html_entity_decode( $alt );
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
		$alt = wp_kses( $alt, $allowed_html );

		// The 'align' option.
		if ( ! empty( $align ) ) {
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
		} else {
			$align_style = '';
		}

		// The 'container' option.
		switch ( $container ) {
			case 'p':
				$container_open  = '<p';
				$container_close = '</p>';
				break;

			case 'div':
				$container_open  = '<div';
				$container_close = '</div>';
				break;

			case 'span':
				$container_open  = '<span';
				$container_close = '</span>';
				break;

			default:
				$container_open  = '<p';
				$container_close = '</p>';
		}

		// The 'role' option.
		switch ( $role ) {

			case 'administrator':
				if ( current_user_can( 'create_users' ) ) {
					$text = $container_open . ' class="private administrator-content"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'editor':
				if ( current_user_can( 'edit_others_posts' ) ) {
					$text = $container_open . ' class="private editor-content"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'editor-only':
				if ( current_user_can( 'read_ubn_editor_notes' ) ) {
					$text = $container_open . ' class="private editor-content editor-only"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'author':
				if ( current_user_can( 'publish_posts' ) ) {
					$text = $container_open . ' class="private author-content"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'author-only':
				if ( current_user_can( 'read_ubn_author_notes' ) ) {
					$text = $container_open . ' class="private author-content author-only"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'contributor':
				if ( current_user_can( 'edit_posts' ) ) {
					$text = $container_open . ' class="private contributor-content"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'contributor-only':
				if ( current_user_can( 'read_ubn_contributor_notes' ) ) {
					$text = $container_open . ' class="private contributor-content contributor-only"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'subscriber':
				if ( current_user_can( 'read' ) ) {
					$text = $container_open . ' class="private subscriber-content"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'subscriber-only':
				if ( current_user_can( 'read_ubn_subscriber_notes' ) ) {
					$text = $container_open . ' class="private subscriber-content subscriber-only"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'visitor-only':
				if ( ! is_user_logged_in() ) {
					$text = $container_open . ' class="private visitor-content visitor-only"' . $align_style . '>' . $content . $container_close;
				} else {
					$text = '';
					if ( $alt ) {
						$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
					}
				}
				break;

			case 'none':
				$all_recipients = array_map( 'trim', explode( ',', $recipient ) );
				$current_user   = wp_get_current_user();
				if ( $reverse ) {
					// Reverse the logic of the function. Users added in recipient WILL NOT see the private note.
					if ( in_array( $current_user->user_login, $all_recipients, true ) ) {
						$text = '';
						if ( $alt ) {
							$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
						}
					} else {
						$text = $container_open . ' class="private user-content user-only-reverse"' . $align_style . '>' . $content . $container_close;
					}
				} else {
					// The standard logic of the function. Users added in recipient WILL see the private note.
					if ( in_array( $current_user->user_login, $all_recipients, true ) ) {
						$text = $container_open . ' class="private user-content user-only ' . esc_attr( $current_user->user_login ) . '-only"' . $align_style . '>' . $content . $container_close;
					} else {
						$text = '';
						if ( $alt ) {
							$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
						}
					}
				}
				break;

			default:
				$text = '';
		}

		if ( isset( $text ) && ! empty( $text ) && ! is_feed() ) {
			// The do_shortcode function is necessary to let WordPress execute another nested shortcode.
			return do_shortcode( $text );
		}
	}

}

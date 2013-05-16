<?php
/**
 * Main Hello Dolly 2.0 Logic
 * @subpackage Hello_Dolly2
 * @author Benjamin J. Balter <ben@balter.com>
 * @package Plugin_Boilerplate
 */

class Hello_Dolly2_Sample_Lyrics {

	private $parent;
	public $lyrics;

	/**
	 * Init Default Lyrics and register with WordPress API
	 * @param class $parent (reference) the Parent Class
	 */
	function __construct( &$parent ) {

		$this->parent = &$parent;

		$this->lyrics = array (
			__( "Hello, Dolly" ),
			__( "Well, hello, Dolly" ),
			__( "It's so nice to have you back where you belong" ),
			__( "You're lookin' swell, Dolly" ),
			__( "I can tell, Dolly" ),
			__( "You're still glowin', you're still crowin'" ),
			__( "You're still goin' strong" ),
			__( "We feel the room swayin'" ),
			__( "While the band's playin'" ),
			__( "One of your old favourite songs from way back when" ),
			__( "So, take her wrap, fellas" ),
			__( "Find her an empty lap, fellas" ),
			__( "Dolly'll never go away again" ),
			__( "Hello, Dolly" ),
			__( "Well, hello, Dolly" ),
			__( "It's so nice to have you back where you belong" ),
			__( "You're lookin' swell, Dolly" ),
			__( "I can tell, Dolly" ),
			__( "You're still glowin', you're still crowin'" ),
			__( "You're still goin' strong" ),
			__( "We feel the room swayin'" ),
			__( "While the band's playin'" ),
			__( "One of your old favourite songs from way back when" ),
			__( "Golly, gee, fellas" ),
			__( "Find her a vacant knee, fellas" ),
			__( "Dolly'll never go away" ),
			__( "Dolly'll never go away" ),
			__( "Dolly'll never go away again" ),
		);

		add_action( 'hd2_options_init', array( &$this, 'options_init' ) );
		add_filter( $this->parent->prefix . 'lyric', array( &$this, 'add_p_tag' ) );
		add_action( 'admin_notices', array( &$this, 'lyric' ) );
		add_action( 'admin_head', array( &$this, 'css' ) );
		add_action( 'admin_init', array( &$this, 'js_lyrics' ) );
		add_action( 'admin_init', array( &$this, 'reset_lyrics' ) );
	}


	/**
	 * Init Options
	 */
	function options_init() {

		$this->parent->options->defaults = array( 'lyrics' => &$this->lyrics );

	}


	/**
	 * Restore lyrics to defaults
	 */
	function reset_lyrics() {

		if ( !isset( $_GET[ 'hd2_reset' ] ) || !$_GET[ 'hd2_reset' ] )
			return;

		$this->parent->options->lyrics = $this->lyrics;
		wp_redirect( admin_url( 'options-general.php?page=hd2_options&settings-updated=true' ) );
		exit();

	}


	/**
	 * Returns texturized array of all lyrics
	 * @return array the lyrics
	 */
	function get_lyrics() {
		$lyrics = $this->parent->options->lyrics;
		array_walk( $lyrics, 'wptexturize' );
		return $lyrics;
	}


	/**
	 * Returns a single lyric
	 * @uses hd2_lyric filter
	 * @return string random lyric
	 */
	function get_lyric() {

		$lyrics = $this->get_lyrics();
		$lyric = $lyrics[ array_rand( $lyrics ) ];
		return $this->parent->api->apply_filters( 'lyric', $lyric );

	}


	/**
	 * Enqueue lyrics via localize script
	 */
	function js_lyrics() {
		$this->parent->enqueue->admin_data['lyrics'] = $this->get_lyrics();
	}


	/**
	 * Echos a lyric
	 */
	function lyric() {
		echo $this->get_lyric();
	}


	/**
	 * Filter to wrap lyric in <p> tags
	 * @param string $lyric the lyrics
	 * @return string the lytics wrapped in <p> tags
	 */
	function add_p_tag( $lyric ) {
		return $this->parent->template->get( 'sample-header', compact( 'lyric' ) );
	}


	/**
	 * Inject CSS into admin header
	 */
	function css() {
		$this->parent->template->load( 'sample-css' );
	}


}
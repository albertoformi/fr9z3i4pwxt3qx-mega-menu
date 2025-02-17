<?php
if ( ! defined( 'ABSPATH' ) ) exit;

    class DE_DMM_CodeAutoUpdate
         {
             # URL to check for updates, this is where the index.php script goes
             public $api_url;

             private $slug;
             public $plugin;


             public function __construct($api_url, $slug, $plugin)
                 {
                     $this->api_url = $api_url;

                     $this->slug    = $slug;
                     $this->plugin  = $plugin;

                 }


                 public function check_for_plugin_update($checked_data) {
					 
                    if ( !is_object( $checked_data ) ||  ! isset ( $checked_data->response ) ) {
                       return $checked_data;
                    }
                    
                    $request_string = $this->protect_prepare_request('plugin_update');
                    if($request_string === FALSE) {
                       return $checked_data;
                    }
                       
                    global $wp_version;
                                  
                    // Start checking for an update
                    $request_uri = $this->api_url . '?' . http_build_query( $request_string , '', '&');
                    
                    //check if cached
                    $data  =   get_site_transient( DE_DMM_PRODUCT_ID.'-check_for_plugin_update_' . md5( $request_uri ) );
                    
   
                    
                    if ( isset ( $_GET['force-check'] ) && $_GET['force-check']    ==  '1' ) {
                       $data   =   FALSE;
                    }
                    
                    if  ( $data    === FALSE ) {
                        $data = wp_safe_remote_get( $request_uri, array(
                            'timeout'     => 20,
                            ) );
                            
                        if(is_wp_error( $data ) || $data['response']['code'] != 200) {
                            return $checked_data;
                        }
                               
                        set_site_transient( DE_DMM_PRODUCT_ID.'-check_for_plugin_update_' . md5( $request_uri ), $data, 60 * 60 * 4 );
                    }   
                    
                    $response_block = json_decode($data['body']);
                     
                    if(!is_array($response_block) || count($response_block) < 1) {
                       return $checked_data;
                    }
                    
                    //retrieve the last message within the $response_block
                    $response_block = $response_block[count($response_block) - 1];
                    $response = isset($response_block->message) ? $response_block->message : '';
                    
                    // Feed the update data into WP updater
                    if (is_object($response) && !empty($response)) {
                        $response  =   $this->postprocess_response( $response );
                                                         
                        $checked_data->response[$this->plugin] = $response;
                    }
                    
                    return $checked_data;
                }
       
                private function postprocess_response( $response ) {
                    //include slug and plugin data
                    $response->slug    =   $this->slug;
                    $response->plugin  =   $this->plugin;
                    
                    //if sections are being set
                    if ( isset ( $response->sections ) )
                       $response->sections = (array)$response->sections;
                    
                    //if banners are being set
                    if ( isset ( $response->banners ) )
                       $response->banners = (array)$response->banners;
                      
                    //if icons being set, convert to array
                    if ( isset ( $response->icons ) )
                       $response->icons    =   (array)$response->icons;
                    
                    return $response;  
                }


             public function plugins_api_call($def, $action, $args)
                 {
                     if (!is_object($args) || !isset($args->slug) || $args->slug != $this->slug)
                        return $def;


                     //$args->package_type = $this->package_type;

                     $request_string = $this->protect_prepare_request($action, $args);
                     if($request_string === FALSE)
                        return new WP_Error('plugins_api_failed', __('An error occour when try to identify the pluguin.' , 'divi-mega-menu-license') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'divi-mega-menu-license' ) .'&lt;/a>');;

                     $request_uri = $this->api_url . '?' . http_build_query( $request_string , '', '&');
                     $data = wp_remote_get( $request_uri );

                     if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        return new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.' , 'divi-mega-menu-license') . '&lt;/p> &lt;p>&lt;a href=&quot;?&quot; onclick=&quot;document.location.reload(); return false;&quot;>'. __( 'Try again', 'divi-mega-menu-license' ) .'&lt;/a>', $data->get_error_message());

                     $response_block = json_decode($data['body']);
                     //retrieve the last message within the $response_block
                     $response_block = $response_block[count($response_block) - 1];
                     $response = $response_block->message;

                     if (is_object($response) && !empty($response)) // Feed the update data into WP updater
                         {
                             //include slug and plugin data
                             $response->slug = $this->slug;
                             $response->plugin = $this->plugin;

                             $response->sections = (array)$response->sections;
                             $response->banners = (array)$response->banners;

                             return $response;
                         }
                 }

             public function protect_prepare_request($action, $args = array())
                 {
                     global $wp_version;

                     $license_data = DE_DMM_LICENSE::get_licence_data();

                     return array(
                                     'woo_sl_action'        => $action,
                                     'version'              => DE_DMM_VERSION,
                                     'product_unique_id'    => DE_DMM_PRODUCT_ID,
                                     'licence_key'          => !empty($license_data['key'])?$license_data['key']:'',
                                     'domain'               => DE_DMM_INSTANCE,

                                     'wp-version'           => $wp_version,

                     );
                 }
         }


    function DE_DMM_run_updater()
         {

             $wp_plugin_auto_update = new DE_DMM_CodeAutoUpdate(DE_DMM_APP_API_URL, 'divi-mega-menu', 'divi-mega-menu/divi-mega-menu.php');

             // Take over the update check
             add_filter('pre_set_site_transient_update_plugins', array($wp_plugin_auto_update, 'check_for_plugin_update'));

             // Take over the Plugin info screen
             add_filter('plugins_api', array($wp_plugin_auto_update, 'plugins_api_call'), 10, 3);

         }
    add_action( 'after_setup_theme', 'DE_DMM_run_updater' );



?>

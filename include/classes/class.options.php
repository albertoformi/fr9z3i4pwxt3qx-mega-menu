<?php
if ( ! defined( 'ABSPATH' ) ) exit;

    class DE_DMM_options_interface
        {

            var $licence;

            function __construct()
            {

                $this->licence          =   new DE_DMM_LICENSE();

                if (isset($_GET['page']) && ($_GET['page'] == 'woo-ms-options'  ||  $_GET['page'] == 'divi-mega-menu')) // phpcs:ignore
                    {
                      $this->options_update();
                      $this->admin_notices();
                    }

                if(!$this->licence->licence_key_verify())
                    {
                        add_action('admin_notices', array($this, 'admin_no_key_notices'));
                        add_action('network_admin_notices', array($this, 'admin_no_key_notices'));
                    }
            }

            function __destruct()
                {

                }

            function network_admin_menu()
                {
                    if(!$this->licence->licence_key_verify()) {
                        return $this->licence_form_mega_menu();
                    } else {
                        return $this->licence_deactivate_form();
                    }
                    add_action('load-' . $hookID , array($this, 'load_dependencies'));
                    add_action('load-' . $hookID , array($this, 'admin_notices'));

                    add_action('admin_print_styles-' . $hookID , array($this, 'admin_print_styles'));
                    add_action('admin_print_scripts-' . $hookID , array($this, 'admin_print_scripts'));
                }

            function admin_menu() {
        if (!$this->licence->licence_key_verify()) {
            return $this->licence_form_mega_menu();
        } else {
            return $this->licence_deactivate_form();
        }
        add_action('admin_print_styles-' . $hookID, array($this, 'admin_print_styles'));
        add_action('admin_print_scripts-' . $hookID, array($this, 'admin_print_scripts'));
    }


            function options_interface()
                {

                    if(!$this->licence->licence_key_verify() && !is_multisite())
                        {
                            $this->licence_form_mega_menu();
                            return;
                        }

                    if(!$this->licence->licence_key_verify() && is_multisite())
                        {
                            $this->licence_multisite_require_nottice();
                            return;
                        }
                }

            function options_update()
                {

                    if (isset($_POST['slt_licence_form_submit'])) // phpcs:ignore
                        {
                            $this->licence_form_submit();
                            return;
                        }

                }

            function load_dependencies()
                {




                }

            function admin_notices()
                {
                    global $slt_form_submit_messages;

                    if($slt_form_submit_messages == '')
                        return;

                    $messages = $slt_form_submit_messages;


                    if(count($messages) > 0)
                        {
                          $messages_implode = implode("</p><p>", $messages);
                          ?> <div id='notice' class='updated error'><p><?php echo esc_html( $messages_implode ) ?></p></div> <?php
                        }

                }

            function admin_print_styles()
                {

                }

            function admin_print_scripts()
                {

                }


            function admin_no_key_notices()
                {
                    if ( !current_user_can('manage_options'))
                        return;

                    $screen = get_current_screen();

                    if( ! is_network_admin()   )
                        {
                            if(isset($screen->id) && $screen->id == 'divi-mega-menu-license')
                                return;

                            ?><div class="updated error"><p><?php esc_html_e( "Divi Mega Menu is inactive, please enter your", 'divi-mega-menu-license' ) ?> <a href="admin.php?page=divi-mega-menu&tab=mega-menu-license"><?php esc_html_e( "License Key", 'divi-mega-menu-license' ) ?></a> to get updates</p></div><?php
                        }

                }

            function licence_form_submit()
                {
                    global $slt_form_submit_messages;

                    //check for de-activation
                    if (isset($_POST['slt_licence_form_submit']) && isset($_POST['slt_licence_deactivate']) && wp_verify_nonce($_POST['dmm_license_nonce'],'dmm_license')) // phpcs:ignore
                        {
                            global $slt_form_submit_messages;

                            $license_data = DE_DMM_LICENSE::get_licence_data();
                            $license_key = $license_data['key'];

                            //build the request query
                            $args = array(
                                                'woo_sl_action'         => 'deactivate',
                                                'licence_key'           => $license_key,
                                                'product_unique_id'     => DE_DMM_PRODUCT_ID,
                                                'domain'                => DE_DMM_INSTANCE
                                            );
                            $request_uri    = DE_DMM_APP_API_URL . '?' . http_build_query( $args , '', '&');
                            $data           = wp_remote_get( $request_uri );

                            //log if debug
                            If (defined('WP_DEBUG') &&  WP_DEBUG    === TRUE)
                                {
                                    DE_DMM::log_data("------\nArguments:");
                                    DE_DMM::log_data($args);

                                    DE_DMM::log_data("\nResponse Body:");
                                    DE_DMM::log_data($data['body']);
                                    DE_DMM::log_data("\nResponse Server Response:");
                                    DE_DMM::log_data($data['response']);
                                }

                            if(is_wp_error( $data ) || $data['response']['code'] != 200)
                                {
                                    $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'divi-mega-menu-license') . DE_DMM_APP_API_URL;
                                    return;
                                }

                                print_r($data['body']);

                                $response_block = json_decode($data['body'], true);

                                // check if the response is not empty
                            if (is_array($response_block) && count($response_block) > 0) {
                
                                    //retrieve the last message within the $response_block (changing $response_block[0]['message'] to $response_block['message' for example)
                                    $response_block = $response_block[count($response_block) - 1];
                                    $response = $response_block['message'];
                
                                    if(isset($response_block['status'])) {
                                        if($response_block['status'] == 'success' && $response_block['status_code'] == 's201') {
                                            //the license is active and the software is active
                                            $slt_form_submit_messages[] = $response_block['message'];

                                            $license_data = DE_DMM_LICENSE::get_licence_data();

                                            //save the license
                                            $license_data['key']          = '';
                                            $license_data['last_check']   = time();

                                            DE_DMM_LICENSE::update_licence_data ( $license_data );
                                        } else if ($response_block['status_code'] == 'e002' || $response_block['status_code'] == 'e104' || $response_block['status_code'] == 'e110') {
                                                    $license_data = DE_DMM_LICENSE::get_licence_data();

                                                    //save the license
                                                    $license_data['key']          = '';
                                                    $license_data['last_check']   = time();

                                                    DE_DMM_LICENSE::update_licence_data ( $license_data );
                                                }
                                        else
                                        {
                                            $slt_form_submit_messages[] = __('There was a problem deactivating the licence: ', 'divi-mega-menu-license') . $response_block['message'];

                                            return;
                                        }
                                }
                                else
                                {
                                    $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . DE_DMM_APP_API_URL, 'divi-mega-menu-license');
                                    return;
                                }
                            }

                            //redirect
                            $current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // phpcs:ignore

                            wp_redirect($current_url);
                            die();

                        }



                    if (isset($_POST['slt_licence_form_submit']) && wp_verify_nonce($_POST['dmm_license_nonce'],'dmm_license')) // phpcs:ignore
                        {

                            $license_key = isset($_POST['license_key'])? sanitize_key(trim($_POST['license_key'])) : ''; // phpcs:ignore

                            if($license_key == '')
                                {
                                    $slt_form_submit_messages[] = __("License Key can't be empty", 'divi-mega-menu-license');
                                    return;
                                }

                            //build the request query
                            $args = array(
                                                'woo_sl_action'         => 'activate',
                                                'licence_key'       => $license_key,
                                                'product_unique_id'        => DE_DMM_PRODUCT_ID,
                                                'domain'          => DE_DMM_INSTANCE
                                            );
                            $request_uri    = DE_DMM_APP_API_URL . '?' . http_build_query( $args , '', '&');
                            $data           = wp_remote_get( $request_uri );

                            //log if debug
                            If (defined('WP_DEBUG') &&  WP_DEBUG    === TRUE)
                                {
                                    DE_DMM::log_data("------\nArguments:");
                                    DE_DMM::log_data($args);

                                    DE_DMM::log_data("\nResponse Body:");
                                    DE_DMM::log_data($data['body']);
                                    DE_DMM::log_data("\nResponse Server Response:");
                                    DE_DMM::log_data($data['response']);
                                }

                            if(is_wp_error( $data ) || $data['response']['code'] != 200)
                                {
                                    error_log( print_r($data['response'], true) );
                                    if ( $data['response']['code'] == 403 ) {
                                        $header_data = $data['headers']->getAll();
                                        $cf_ray = $header_data['cf-ray'];
                                        $slt_form_submit_messages[] .= __('There was a problem connecting to diviengine.com. It seems our firewall blocked you from accessing our server. Please contact support with this Ray ID: ', 'divi-mega-menu') . $cf_ray;
                                    } else {
                                        $slt_form_submit_messages[] .= __('There was a problem connecting to ', 'divi-mega-menu') . DE_DMACH_APP_API_URL;    
                                    }

                                    $result = array(
                                        'result'    => 'error',
                                        'message'   => $slt_form_submit_messages
                                    );
                            
                                    return $result;
                                }

                                $response_block = json_decode($data['body'], true);
                
                                // check if the response is not empty
                            if (is_array($response_block) && count($response_block) > 0) {
                
                                    //retrieve the last message within the $response_block
                                    //changing $response_block[0]['message'] to $response_block['message'] for example
                                    $response_block = $response_block[count($response_block) - 1];
                                    $response = $response_block['message'];
                
                                    if(isset($response_block['status'])) {
                                        if($response_block['status'] == 'success' && ( $response_block['status_code'] == 's100' || $response_block['status_code'] == 's101' ) ) {
                                            //the license is active and the software is active
                                            $slt_form_submit_messages[] = $response_block['message'];

                                            $license_data = DE_DMM_LICENSE::get_licence_data();

                                            //save the license
                                            $license_data['key']          = $license_key;
                                            $license_data['last_check']   = time();

                                            DE_DMM_LICENSE::update_licence_data ( $license_data );

                                        }
                                        else
                                        {
                                            $slt_form_submit_messages[] = __('There was a problem activating the licence: ', 'divi-mega-menu-license') . $response_block['message'];
                                            return;
                                        }
                                }
                                else
                                {
                                    $slt_form_submit_messages[] = __('There was a problem with the data block received from ' . DE_DMM_APP_API_URL, 'divi-mega-menu-license');
                                    return;
                                }
                            }

                            //redirect
                            $current_url    =   'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; // phpcs:ignore

                            wp_redirect($current_url);
                            die();
                        }

                }

            function licence_form_mega_menu()
                {
                ob_start();
                    ?>
                      <div class="wrap">
                              <form id="form_data" name="form" method="post">
                                    <div class="postbox" style="padding: 24px 40px 40px 40px;"><?php wp_nonce_field('dmm_license', 'dmm_license_nonce') ?>
                                            <input type="hidden" name="slt_licence_form_submit" value="true" />

                                             <div class="section section-text ">
                                                <h4 class="heading"><?php  echo esc_html__("License Key", 'divi-mega-menu-license' ) ?></h4>
                                                <div class="option">
                                                    <div class="controls">
                                                        <input type="text" value="" name="license_key" class="text-input" style="width: 100%;max-width: 600px;margin-bottom: 20px;">
                                                    </div>
                                                    <div class="explain"><?php echo esc_html__("Please enter your personal license key from your Divi Engine account. You can find it at: ", 'divi-mega-menu-license'  ) ?> '<a href="https://diviengine.com/my-account/" target="_blank"><?php echo esc_html__("My Account", 'divi-mega-menu-license'  ) ?> </a><br />
                                                  <?php echo esc_html__("More keys can be generate from ", 'divi-mega-menu-license' ) ?> <a href="https://diviengine.com/my-account/" target="_blank"><?php echo esc_html__("My Account", 'divi-mega-menu-license'  ) ?></a>
                                                    </div>
                                                </div>
                                            </div>


                                    </div>

                                    <p class="submit">
                                        <input type="submit" name="Submit" class="button button-primary" value="<?php echo esc_html__('Save', 'divi-mega-menu-license'  ) ?>">
                                    </p>
                                </form>
                            </div>
                    <?php
                    return ob_get_clean();

                }

            function licence_deactivate_form()
                {
                    $license_data = DE_DMM_LICENSE::get_licence_data();

                        ob_start();
                    if(is_multisite())
                        {
                          ?>
                            <div class="wrap">
                            <div id="icon-settings" class="icon32"></div>
                            <h2><?php echo esc_html__("General Settings", 'divi-mega-menu-license') ?></h2>
                            <?php
                        }
                          ?>
                            <div id="form_data">
                                    <h2 class="subtitle"><?php echo esc_html__("Divi Mega Menu Software License", 'wooslt')?></h2>
                                    <div class="postbox" style="padding: 24px 40px 40px 40px;">
                                        <form id="form_data" name="form" method="post"><?php wp_nonce_field('dmm_license', 'dmm_license_nonce') ?>
                                            <input type="hidden" name="slt_licence_form_submit" value="true" />
                                            <input type="hidden" name="slt_licence_deactivate" value="true" />

                                            <div class="section section-text ">
                                                <h4 class="heading"><?php echo esc_html__("License Key", 'wooslt')?></h4>
                                                <div class="option">
                                                    <div class="controls">
                                                      <?php
                                                        if ($this->licence->is_local_instance()) {
                                                          ?>
                                                            <p>Local instance, no key applied.</p>
                                                            <?php
                                                        } else {
                                                          ?>
                                                             <p><b><?php echo esc_html( substr($license_data['key'], 0, 20) )?>-xxxxxxxx-xxxxxxxx</b> &nbsp;&nbsp;&nbsp;<a class="button-primary" title="Deactivate" href="javascript: void(0)" onclick="jQuery(this).closest('form').submit();">Deactivate</a></p>
                                                             <?php
                                                        }
                                                        ?>
                                                     </div>
                                                    <div class="explain"><?php echo esc_html__("You can generate more keys from ", 'wooslt') ?><a href="https://diviengine.com/my-account/" target="_blank">My Account</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php


                    if(is_multisite())
                        {
                          ?>
            </div>
            <?php
                        }

                        return ob_get_clean();
                }

            function licence_multisite_require_nottice()
                {
                    ?>
                        <div class="wrap">
                            <div id="icon-settings" class="icon32"></div>
                            <h2><?php esc_html_e( "General Settings", 'divi-mega-menu-license' ) ?></h2>

                            <h2 class="subtitle"><?php esc_html_e( "Divi Mega Menu Software License", 'divi-mega-menu-license' ) ?></h2>
                            <div id="form_data">
                                <div class="postbox" style="padding: 24px 40px 40px 40px;">
                                    <div class="section section-text ">
                                        <h4 class="heading"><?php esc_html_e( "License Key Required", 'divi-mega-menu-license' ) ?>!</h4>
                                        <div class="option">
                                            <div class="explain"><?php esc_html_e( "Please enter your personal license key from your Divi Engine account. You can find it at:", 'divi-mega-menu-license' ) ?> <a href="http://diviengine.com/my-account/" target="_blank"><?php esc_html_e( "My Account", 'divi-mega-menu-license' ) ?></a><br />
                                            <?php esc_html_e( "More keys can be generate from", 'divi-mega-menu-license' ) ?> <a href="http://diviengine.com/my-account/" target="_blank"><?php esc_html_e( "My Account", 'divi-mega-menu-license' ) ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php

                }


        }



?>

<?php
if ( ! defined( 'ABSPATH' ) ) exit;

    class DE_DMM_LICENSE
        {

            function __construct()
                {
                    $this->licence_deactivation_check();
                }

            function __destruct()
                {

                }



            public static function get_licence_data()
                {

                    $license_data = get_option('dmm_license');

                    return $license_data;

                }


            public static function update_licence_data( $license_data )
                {

                    update_option('dmm_license', $license_data);

                }

            public function licence_key_verify()
                {

                    $license_data = self::get_licence_data();

                    if($this->is_local_instance())
                        return TRUE;

                    if(!isset($license_data['key']) || $license_data['key'] == '')
                        return FALSE;

                    return TRUE;
                }

            function is_local_instance()
                {
                    return FALSE;
                    $instance   =   trailingslashit(DE_DMM_INSTANCE);
                    if(
                            strpos($instance, base64_decode('bG9jYWxob3N0Lw==')) !== FALSE
                        ||  strpos($instance, base64_decode('MTI3LjAuMC4xLw==')) !== FALSE
                        ||  strpos($instance, base64_decode('c3RhZ2luZy53cGVuZ2luZS5jb20=')) !== FALSE
                        )
                        {
                            return TRUE;
                        }

                    return FALSE;

                }


            function licence_deactivation_check()
                {
                    if(!$this->licence_key_verify() ||  $this->is_local_instance()  === TRUE)
                        return;

                    $license_data = self::get_licence_data();

                    if(isset($license_data['last_check']))
                        {
                            if(time() < ($license_data['last_check'] + 86400))
                                {
                                    return;
                                }
                        }

                    $license_key = $license_data['key'];
                    $args = array(
                                                'woo_sl_action'         => 'status-check',
                                                'licence_key'           => $license_key,
                                                'product_unique_id'     => DE_DMM_PRODUCT_ID,
                                                'domain'                => DE_DMM_INSTANCE
                                            );
                    $request_uri    = DE_DMM_APP_API_URL . '?' . http_build_query( $args , '', '&');
                    $data           = wp_remote_get( $request_uri );

                    if(is_wp_error( $data ) || $data['response']['code'] != 200)
                        return;

                        $response_block = json_decode($data['body'],true);
            
                        // check if the response is not empty
                        if (is_array($response_block) && count($response_block) > 0) {
                            //retrieve the last message within the $response_block
                            $response_block = $response_block[count($response_block) - 1];
            
                            $response = $response_block['message'];
            
                            if(isset($response_block['status'])) {
                                if($response_block['status'] == 'success')
                                    {
                                        if($response_block['status_code'] == 's203' || $response_block['status_code'] == 's204')
                                            {
                                                $license_data['key']          = '';
                                            }
                                    }
            
                                if($response_block['status'] == 'error')
                                    {
                                        $license_data['key']          = '';
                                    }
                            }
            
                        }

                    $license_data['last_check']   = time();
                    self::update_licence_data ( $license_data );

                }


        }




?>

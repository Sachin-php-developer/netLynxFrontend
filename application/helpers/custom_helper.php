<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once FCPATH.'/vendor/autoload.php';
use Twilio\Rest\Client;

if (!function_exists('image_upload')) 
{
    function image_upload($FILES,$folder,$allowed_type)
    {
        $ci =& get_instance();
        $config = array(
            'upload_path' => $folder,
            'allowed_types' => $allowed_type,
            'overwrite' => FALSE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'encrypt_name' => TRUE,
            'remove_spaces' => TRUE,
            );
        $ci->load->library('upload', $config);
        if($ci->upload->do_upload('file'))
        {
            // $source_path = $folder . $FILES['file']['name'];
            // $target_path = $folder;
            // $config_manip = array(
            //     'image_library' => 'gd2',
            //     'source_image' => $source_path,
            //     'new_image' => $target_path,
            //     'maintain_ratio' => TRUE,
            //     'create_thumb' => TRUE,
            //     'thumb_marker' => '_thumb',
            //     'width' => 150,
            //     'height' => 150
            // );
      
      
            // $ci->load->library('image_lib', $config_manip);
            // if (!$ci->image_lib->resize()) {
            //     echo $ci->image_lib->display_errors();
            // }
      
      
            // $ci->image_lib->clear();
            $data = array('upload_data' => $ci->upload->data(),'status'=>true);
            return $data;
            
        }
        else
        {
            $error = array('error' => $ci->upload->display_errors(),'status'=>false);
            return $error;
            
        }
    }

}

if (!function_exists('image_upload_with_resize')) 
{
    function image_upload_with_resize($FILES,$folder,$allowed_type)
    {
        $ci =& get_instance();
        $source_path = $folder . $FILES['file']['name'];
        $target_path = $folder;
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'create_thumb' => TRUE,
            'thumb_marker' => '_thumb',
            'width' => 150,
            'height' => 150
        );
  
  
        $ci->load->library('image_lib', $config_manip);
        if (!$ci->image_lib->resize()) {
            echo $ci->image_lib->display_errors();
        }
  
  
        $ci->image_lib->clear();
    }

}

if (!function_exists('get_tiny_url')) 
{
    function get_tiny_url($url)
    {
        $ch = curl_init();  
        $timeout = 5;  
        curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
        $data = curl_exec($ch);  
        curl_close($ch);  
        return $data;
    }
}


if (!function_exists('send_sms')) 
{
    function send_sms($customer_phone,$message,$company_id,$logo_status)
    {
        $sms_reciever = str_replace(' ', '', $customer_phone);
		$sms_reciever = str_replace('-', '', $sms_reciever);
		$sms_reciever = str_replace('+', '', $sms_reciever);
		$sms_reciever = str_replace('(', '', $sms_reciever);
		$sms_reciever = str_replace(')', '', $sms_reciever);
		if(substr($sms_reciever,0,1) != 1 )
		{
		    $sms_reciever = '+1'.$sms_reciever;
		}
        $sid = "AC966b578bfe1b8fbd291585f87eb28d16";
        $token = "59b8cf56c409356425c0fbe19377102b";
        $twilio = new Client($sid, $token);
        if($logo_status == true)
        {
            $ci =& get_instance();
            $ci->load->model('Company_model');
            if(!empty($company_id))
            {
    	        $companydata = $ci->Company_model->get_company_logo($company_id);
    	        $logo = base_url()."assets/company_logo/".$companydata->logo;
            }
            else
            {
                $logo = base_url()."assets/digital_card/logo-blue-white.png";
            }
    	    
    	    try
            {
                    $message = $twilio->messages
                      ->create("+".$sms_reciever, // to
                               [
                                   "body" => $message,
                                   "from" => "+16473709188",
                                   "mediaUrl" => [$logo]
                               ]
                      );
                
                    return true;
            }
            catch(Exception $e)
            {
                
                // echo $e->getMessage();
                return false;;
            }
        }
        else
        {
            try
            {
                    $message = $twilio->messages
                              ->create("+".$sms_reciever, // to
                                       [
                                           "body" => $message,
                                           "from" => "+16473709188"
                                       ]
                              );
                    // print_r($message);
                    return true;
            }
            catch(Exception $e)
            {
                return false;
            }
        }
	        

        
    }
}

// if (!function_exists('send_sms')) 
// {
//     function send_sms($customer_phone,$message)
//     {		
//         $ci =& get_instance();
// 		if ($customer_phone!= NULL) 
//         {
// 			if (isset($customer_phone)) 
//             {
// 				$sms_sender = '+18126386077';
// 				$sms_reciever = str_replace(' ', '', $customer_phone);
// 				$sms_reciever = str_replace('-', '', $sms_reciever);
// 				$sms_reciever = str_replace('+', '', $sms_reciever);
// 				$sms_reciever = str_replace('(', '', $sms_reciever);
// 				$sms_reciever = str_replace(')', '', $sms_reciever);
// 				$sms_message = $message;
// 				$from = '+' . $sms_sender; //trial account twilio number
// 				$to = $sms_reciever; //sms recipient number
// 				$response = $ci->twilio->sms($from, $to, $sms_message);
// 				if ($response->IsError) 
//                 {
// 					return FALSE;
// 				} 
//                 else 
//                 {
// 					return TRUE;
// 				}
// 			} 
//             else 
//             {
// 				return FALSE;
// 			}
// 		} 
//         else 
//         {
// 			return FALSE;
// 		}
//     }
// }

if (!function_exists('send_email')) 
{
    function send_email($email_to,$subject,$message)
    {
        $ci =& get_instance();
		if ($email_to == null || $subject == null || $message == null) 
        {
			return false;
		} 
        else 
        {
			$config = array(
				'protocol' => 'smtp',
				// 'smtp_host' => 'ssl://smtp.gmail.com',
				'smtp_host' => 'ssl://mail.netlynxs.com',
				'smtp_port' => 465,
				// 'smtp_port' => 465,
				'smtp_user' => 'mail@netlynxs.com',
				// 'smtp_user' => 'elitebraidsinfo@gmail.com',
				'smtp_pass' => 'netlynxs@123',
				// 'smtp_pass' => 'yigyjhgwbbnpctot',
				'smtp_timeout' => 20,
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'wordwrap' => TRUE
			);
			
			$ci->email->initialize($config);
			$ci->email->set_newline("\r\n");
			$ci->email->from('mail@netlynxs.com', 'NETLYNXS');
			$ci->email->to($email_to);
			$ci->email->subject($subject);
			$ci->email->message($message);
			if ($ci->email->send()) 
            {
				return true;
			} 
            else 
            {
				 //echo $ci->email->print_debugger();
				return false;
			}
        }
    }
}



if(!function_exists('check_auth_key')) 
{
    function check_auth_key($auth_key,$user_id,$table)
    {
        $ci =& get_instance();
        $ci->load->model('Commonmodel');
        $where = array(
            'id'=>$user_id,
            'auth_key'=>$auth_key,
            'status'=>1,
            'is_deleted'=>0
        );
        $carddata = $ci->Commonmodel->selectAllDataWhere($table,$where);
        if(count($carddata) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}


if(!function_exists('get_single_data_by_id')) 
{
    function get_single_data_by_id($id,$table,$column)
    {
        $ci =& get_instance();
        $ci->load->model('Commonmodel');
        $carddata = $ci->Commonmodel->singleDataColumn($table,$column,$id);
        return $carddata;
    }
}
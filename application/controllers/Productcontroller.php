<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productcontroller extends CI_Controller 
{
    function __construct() 
    {
        parent::__construct();
        $this->load->model('Commonmodel');
        $this->load->model('Bookingmodel');
        $this->load->library('phpqrcode/qrlib');
        $this->load->library('twilio');
    }
    public function index()
    {
        $setting_view = $this->Commonmodel->singleAllData('b_settings',array());
        if($setting_view->enable_location == 1)
        {
            $where = array('status'=>0);
            $data['location_list'] = $this->Commonmodel->selectDataArray('b_location',$where);
            $this->load->view('product',$data);
        }
        elseif($setting_view->enable_cart == 1)
        {
            $this->load->view('cart');
        }
        elseif($setting_view->enable_finish == 1)
        {
            $this->load->view('finish');
        }
    }
    public function get_product_list()
    {
        $product_list = $this->Bookingmodel->product_with_category();
        $res = array(
            'status'=>true,
            'data'=>$product_list
        );
        echo json_encode($res);
    }
    public function save_product_booking()
    {
        $this->form_validation->set_rules('location_id','Location','trim|required|xss_clean');
        $this->form_validation->set_rules('product_id','Product','trim|required|xss_clean');
        $this->form_validation->set_rules('category_id','Category','trim|required|xss_clean');
        $this->form_validation->set_rules('first_name','First Name','trim|required|xss_clean');
        $this->form_validation->set_rules('last_name','Last Name','trim|required|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|xss_clean');
        $this->form_validation->set_rules('phone','Phone','trim|required|xss_clean');
        if($this->form_validation->run() == false)
        {
            $res = array(
                'status'=>false,
                'message'=>validation_errors()
            );
            
        }
        else
        {
            if (empty($_FILES['file']['name']))
            {
                $image_url = '';
            }
            else
            {
                $folder = 'assets/customer_image/';
                $allowed_type = "gif|jpg|png|jpeg";
                $image_data = image_upload($_FILES,$folder,$allowed_type);
                if($image_data['status'] == true)
                {
                    $image_name  = $image_data['upload_data']['file_name'];
                    $image_url = base_url()."assets/customer_image/".$image_name;
                }
                else
                {
                    $image_url = '';
                }
            }
            $product_detail = $this->Commonmodel->singleAllData('b_products',array('id'=>$this->input->post('product_id')));
            $post_array = array(
                'location_id'=>$this->input->post('location_id'),
                'customer_name'=>$this->input->post('first_name')." ".$this->input->post('last_name'),
                'customer_email'=>$this->input->post('email'),
                'customer_phone'=>$this->input->post('phone'),
                'customer_image'=>$image_url,
                'product_price'=>$product_detail->price,
                'product_name'=>$product_detail->product_name,
                'qty'=>1,
                'description'=>$product_detail->description,
                'product_part_number'=>$product_detail->part_number,
                'color'=>$product_detail->color,
                'product_image'=>$product_detail->image,
                'status'=>0
            );
            $insert = $this->Commonmodel->insertData('b_product_booking',$post_array,true);
            if($insert != false)
            {
                $res = array(
                    'status'=>true,
                    'booking_id'=>$insert,
                    'message'=>'Thank you for booking your product.'
                );
            }
            else
            {
                $res = array(
                    'status'=>false,
                    'message'=>'Error'
                );
            }
        }
        echo json_encode($res);
    }
}
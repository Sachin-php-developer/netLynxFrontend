<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookingcontroller extends CI_Controller {

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
        $this->load->view('index');
	}
    public function get_setting_data()
    {
        $setting_view = $this->Commonmodel->singleAllData('b_settings',array());
        $res = array(
            'status'=>true,
            'data'=>$setting_view
        );
        echo json_encode($res);
    }
    public function get_location_list()
    {
        $where = array('status'=>0);
        $location_list = $this->Commonmodel->selectDataArray('b_location',$where);
        $res = array(
            'status'=>true,
            'data'=>$location_list
        );
        echo json_encode($res);
    }
    public function get_staff_list()
    {
        $location_id = $this->input->post('location_id');
        if(empty($location_id))
        {
            $where = array('status'=>0);
        }
        else
        {
            $where = array('status'=>0,'location_id'=>$location_id);
        }
        $staff_list = $this->Commonmodel->selectDataArray('b_staffs',$where);
        $res = array(
            'status'=>true,
            'data'=>$staff_list
        );
        echo json_encode($res);
    }
    public function get_staff_service_list()
    {
        $staff_id = $this->input->post('staff_id');
        $staff_list = $this->Bookingmodel->service_by_staff($staff_id);
        $res = array(
            'status'=>true,
            'data'=>$staff_list
        );
        echo json_encode($res);
    }
    public function get_slot()
    {
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');

        if($this->form_validation->run() == false)
        {
            $res = array(
                'status'=>false,
                'message'=>validation_errors()
            );
            
        }
        else
        {
            $date = date("Y-m-d", strtotime($this->input->post('date')));
            $staff_id = $this->input->post('staff_id');
            $day_no = date('N', strtotime($date));
            if(!empty($staff_id))
            {
                $where = array('day_no'=>$day_no,'open'=>1,'staff_id'=>$staff_id);
            }
            else
            {
                $where = array('day_no'=>$day_no,'open'=>1);
            }
            $staff_working = $this->Commonmodel->selectOneData('b_staff_working_hours',$where);
            if($staff_working)
            {
                $start_time = $staff_working->start_time;
                $end_time = $staff_working->end_time;
                $break_start_time = $staff_working->break_start_time;
                $break_end_time = $staff_working->break_end_time;

                $working_hour_begin = new DateTime($start_time);
                $working_hour_end   = new DateTime($end_time);
                $slot_array = [];
                $removable_slot_array = [];
                for($i = $working_hour_begin; $i <= $working_hour_end; $i->modify('+30 minute'))
                {
                    array_push($slot_array,$i->format("h:i A"));
                }
                $bread_time_begin = new DateTime($break_start_time);
                $break_time_end   = new DateTime($break_end_time);
                for($j = $bread_time_begin; $j <= $break_time_end; $j->modify('+30 minute'))
                {
                    array_push($removable_slot_array,$j->format("h:i A"));
                }
                if(!empty($staff_id))
                {
                    $where1 = array('staff_id'=>$staff_id,'appointment_date'=>$date);
                }
                else
                {
                    $where1 = array('appointment_date'=>$date);
                }
                $staff_appointment = $this->Commonmodel->selectDataArray('b_appointments',$where1);
                if(count($staff_appointment) > 0)
                {
                    foreach($staff_appointment as $sa)
                    {
                        $appointment_start_time = new DateTime($sa['appointment_start_time']);
                        $appointment_end_time = new DateTime($sa['appointment_end_time']);
                        for($k = $appointment_start_time; $k <= $appointment_end_time; $k->modify('+30 minute'))
                        {
                            array_push($removable_slot_array,$k->format("h:i A"));
                        }
                    }
                }
                $final_slot_array = array_diff($slot_array,$removable_slot_array);
                $main_slot = array();
                foreach($final_slot_array as $fs)
                {

                    $sarr = array(
                        'slot_start'=>$fs,
                        'slot_end'=>date("h:i A", strtotime('+30 minutes', strtotime($fs)))
                    );
                    array_push($main_slot,$sarr);
                }
                $res = array(
                    'status'=>true,
                    'slot'=>$main_slot
                );
            }
            else
            {
                $res = array(
                    'status'=>false,
                    'message'=>'Selected staff not working today'
                );
            }
        }
        echo json_encode($res);
    }
    public function save_appointment()
    {
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
            $appointment_id = rand(10000,99999);
            $service_detail = $this->Commonmodel->singleAllData('b_services',array('id'=>$this->input->post('service_id')));
            $post_array = array(
                'appointment_id'=>$appointment_id,
                'location_id'=>$this->input->post('location_id')??0,
                'customer_name'=>$this->input->post('first_name')." ".$this->input->post('last_name'),
                'customer_email'=>$this->input->post('email'),
                'customer_phone'=>$this->input->post('phone'),
                'customer_image'=>$image_url,
                'appointment_date'=>$this->input->post('date')??'',
                'appointment_start_time'=>$this->input->post('slot_start')??'',
                'appointment_end_time'=>$this->input->post('slot_end')??'',
                'amount'=>$service_detail->price??0,
                'staff_id'=>$this->input->post('staff_id')??0,
                'service_name'=>$service_detail->service_name??'',
                'service_price'=>$service_detail->price??0,
                'service_duration'=>$service_detail->duration??0,
                'service_image'=>$service_detail->image??'',
                'status'=>0
            );
            $insert = $this->Commonmodel->insertData('b_appointments',$post_array,true);
            if($insert != false)
            {
                $staff_detail = $this->Commonmodel->singleAllData('b_staffs',array('id'=>$this->input->post('staff_id')));
                $location_detail = $this->Commonmodel->singleAllData('b_location',array('id'=>$this->input->post('location_id')));
                if($location_detail)
                {
                    $location_name = $location_detail->location_name;
                }
                else
                {
                    $location_name = 'NA';
                }
                if($staff_detail)
                {
                    $staff_name = $staff_detail->staff_name;
                }else
                {
                    $staff_name = 'NA';
                }
                if($service_detail)
                {
                    $service_name = $service_detail->service_name;
                }
                else
                {
                    $service_name = 'NA';
                }
                $message = 'Thank you for booking your appointment with '.$staff_name.' at '.$location_name.' on '.$this->input->post('date').' at '.$this->input->post('slot_start').' for '.$service_name.'.';
                send_sms('4168001107',$message,$insert,false);

                $message2 = 'Thank you for booking your appointment with '.$staff_name.' at '.$location_name.' on '.$this->input->post('date').' at '.$this->input->post('slot_start').' for '.$service_name.'.';
                $subject = 'Appointment Booked';
                send_email($this->input->post('email'),$subject,$message2);

                $res = array(
                    'status'=>true,
                    'appointment_id'=>$appointment_id,
                    'message'=>'Thank you for booking your appointment with '.$staff_name.' at '.$location_name.' on '.$this->input->post('date').' at '.$this->input->post('slot_start').' for '.$service_name.'.'
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
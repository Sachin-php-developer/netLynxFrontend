
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Bookingmodel extends CI_Model
{
    public function service_by_staff($staff_id)
    { 
        $this->db->select('c.id,c.category_name,(select COUNT(id) from b_services s where s.category_id=c.id) as total_services');
        $this->db->from('b_category c');
        $this->db->where('c.status',0);
        $this->db->having('total_services >',  0);
        $query = $this->db->get();
        $category = $query->result();
        foreach($category as $key => $cat)
        {
            $this->db->select('s.id,s.service_name,s.duration,s.price,s.image');
            $this->db->from('b_assigned_service_staff ass');
            $this->db->join('b_services s','s.id=ass.service_id','inner');
            if(!empty($staff_id))
            {
                $this->db->where('ass.staff_id',$staff_id);
            }
            $this->db->where('s.category_id',$cat->id);
            $this->db->where('s.status',0);
            $this->db->group_by('s.id');
            $query = $this->db->get();
            $query = $query->result();
            $category[$key]->services = $query;
        }
        return $category;
    }
    public function product_with_category()
    {
        $this->db->select('c.id,c.category_name,(select COUNT(id) from b_products s where s.category_id=c.id) as total_product');
        $this->db->from('b_product_category c');
        $this->db->where('c.status',0);
        $this->db->having('total_product >',  0);
        $query = $this->db->get();
        $category = $query->result();
        foreach($category as $key => $cat)
        {
            $this->db->select('p.id,p.product_name,p.price,p.image,p.hide_price');
            $this->db->from('b_products p');
            $this->db->where('p.category_id',$cat->id);
            $this->db->where('p.status',0);
            $query = $this->db->get();
            $query = $query->result();
            $category[$key]->product = $query;
        }
        return $category;
    }
}
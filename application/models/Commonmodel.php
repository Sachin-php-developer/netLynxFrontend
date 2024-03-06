<?php 

  defined('BASEPATH') OR exit('No direct script access allowed');

  

  class Commonmodel extends CI_Model{



  	public function singleData($table,$field,$id){ 

  		$q=$this->db->select($field)

  					->where("id",$id)

  					->get($table);

  		return $q->row();			

  	}

    public function singleAllData($table,$where){ 

  		$q=$this->db->select('*')

  					->where($where)

  					->get($table);

  		return $q->row();			

  	}



    public function deleteData($table,$id){

      return $q=$this->db->where("id",$id)

                         ->delete($table);

    }
    public function deleteDataWhere($table,$where){

      return $q=$this->db->where($where)
                         ->delete($table);

    }


    public function counting($table){

        $query=$this->db->get($table);

        return $query->num_rows();

    }

	

	public function countingWhere($table,$where){

        $query=$this->db->where($where)

						->get($table);

        return $query->num_rows();



    }

	

	public function cartCount($table,$where){

        $query=$this->db->where($where)

						->get($table);

        return $query->num_rows();



    }



  	public function updateData($table , array $data , $id){

  		$q=$this->db->where("id",$id)

  					->update($table,$data);

  		return $q;

  	}

	

	public function updateWhere($table , array $data , $where){

  		$q=$this->db->where($where)

  					->update($table,$data);

  		return $q;

  	}



    public function updateAllData($table , array $data){

      $q=$this->db->update($table,$data);

      return $q;

    }

	

	public function selectAllDataDistinct($table,$field,$where){

      $q=$this->db->select($field)

				  ->distinct($field)

				  ->where($where)

                  ->order_by("id","desc")

                  ->get($table);

      return $q->result();            

    }



    public function insertData($table,array $data,$return_insert_id){
        
        if($return_insert_id)
        {
            $q=$this->db->insert($table, $data);
            if($q)
            {
                return $this->db->insert_id();
            }
            else
            {
                return false;
            }

        }
        else
        {
            $q=$this->db->insert($table, $data);
            if($q)
            {
                return true;
            }
            else
            {
                return false;
            }
        }



    }



    public function selectAllData($table){

      $q=$this->db->select("*")

                  ->order_by("id","desc")

                  ->get($table);

      return $q->result();            

    }

	

	public function selectAllDataPosition($table,$order="asc"){

      $q=$this->db->select("*")

                  ->order_by("position",$order)

                  ->get($table);

      return $q->result();            

    }

	

	public function selectAllDataWhere($table,$where,$order='asc'){

      $q=$this->db->select("*")

                  ->where($where)

				  ->order_by("id",$order)

                  ->get($table);

      return $q->result();            

    }

	



    public function getSingleValue($table,$field,$id){

      $res=$this->db->select($field)

              ->where("id",$id)

              ->get($table);

      if($res){

        foreach ($res->result() as $row){

          return $val = stripslashes($row->$field);

        }

      }

      else{

        return false;

      }

    }

	

	public function getSingleValueWhere($table,$field,$where){

      $res=$this->db->select($field)

              ->where($where)

              ->get($table);

      if($res){

        foreach ($res->result() as $row){

          return $val = stripslashes($row->$field);

        }

      }

      else{

        return false;

      }

    }

 

    public function selectWhereData($table,$where,$order="ASC"){

      $q=$this->db->select("*")

                  ->where($where)

				  ->order_by("id",$order)

                  ->get($table);

      return $q->result();            

    }

	

	public function selectDataArray($table,$where,$order="ASC"){

      $q=$this->db->select("*")

                  ->where($where)

				  ->order_by("id",$order)

                  ->get($table);
      return $q->result_array();            

    }

	

	public function selectWhereOrder($table,$where,$field,$order="ASC"){

      $q=$this->db->select("*")

                  ->where($where)

				  ->order_by($field,$order)

                  ->get($table);

      return $q->result();            

    }

	

	public function selectWhereDataPosition($table,$where,$order="ASC"){

      $q=$this->db->select("*")

                  ->where($where)

				  ->order_by("position",$order)

                  ->get($table);

      return $q->result();            

    }

	

	

	public function selectOneDataDiscount($table,$where){

      $q=$this->db->select("*")

                  ->where($where)

				  ->order_by("discount","desc")

                  ->get($table);

      return $q->row();            

    }

	

	public function selectWhereDataLimit($table,$where,$limit){

      $q=$this->db->select("*")

                  ->where_in($where)

				  ->limit($limit)

				  ->order_by("id","desc")

                  ->get($table);

      return $q->result();            

    }

	

	public function selectWhereDataLimit1($table,$where,$limit){

      $q=$this->db->select("*")

                  ->where($where)

				  ->limit($limit)

				  ->order_by("id","asc")

                  ->get($table);

      return $q->result();            

    }



    public function selectOneData($table,$where){

      $q=$this->db->select("*")

                  ->where($where)

                  ->get($table);

				  

      return $q->row();            

    }

    // Subcategory 

    public function selectRecordWhere($table,$where){

      $q=$this->db->select('*') 

				  ->from($table)

				  ->where($where)

				  ->get();

      return $q->result_array();

    }



    // Add Data And get Last inserted Id

    function addRow($table,array $data)  

    {

      $this->db->insert($table, $data); 

      return $this->db->insert_id();

    }

	

	// Duduct used 

	

	public function updateCoupon($table,$couponid){

		return $this->db->set("used","used-1",false)

				        ->where("id",$couponid)

				        ->update("coupon");

	}



  public function result_getall($table,$from,$to,$join,$where,$jointype){



    $query=$this->db->select($table)

			  ->distinct()

              ->from($from)

              ->join($to, $join,$jointype)

              ->where($where)

              ->get();

			  // echo $this->db->last_query();

			  // die();

    return $query->result();



 }

public function insert_batch($table,$data)
{
    $query = $this->db->insert_batch($table,$data);
    if($query)
    {
      return true;
    }
    else
    {
      return false;
    }
}

public function singleDataColumn($table,$column,$id){ 

  $q=$this->db->select($column)

        ->where("id",$id)

        ->get($table);

  $rowd = $q->row();
  return $rowd->$column;		

}

    

  }

 ?>
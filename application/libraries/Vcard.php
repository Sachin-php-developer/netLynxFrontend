<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
/*
 * ---------------------------------------------------------------------------------------------------------------------------
 *  vCard library for Code Igniter applications extended from class_vcard from Troy Wolf [troy@troywolf.com]
 *  <carlos@online.com.bo> 
 * ---------------------------------------------------------------------------------------------------------------------------
 */
 
/**
* Codeigniter vCard  library
*/
class Vcard
{
    /**
     * vcard variables
     **/
    protected $ci;

    protected $log;
    protected $data;              //array of this vcard's contact data
    private $filename;             //filename for download file naming
    private $class;             //PUBLIC, PRIVATE, CONFIDENTIAL
    private $revision_date;     //vCard Date
    private $card;                //vCard String

    /**
     * __construct
     **/
    public function __construct()
    {
        $this->ci =& get_instance();
        //$ci->load->library('session');
        $this->ci->load->library('zip');
    }

    /**
     *The Vcards class constructor. You can set some defaults here if desired.
     *
     */    
  function Vcard($data = false) {
    $this->log = "New vcard() called<br />";

    $this->data = array(
      "display_name"=>null
      ,"first_name"=>null
      ,"last_name"=>null
      ,"additional_name"=>null
      ,"name_prefix"=>null
      ,"name_suffix"=>null
      ,"nickname"=>null
      ,"title"=>null
      ,"role"=>null
      ,"department"=>null
      ,"company"=>null
      ,"work_po_box"=>null
      ,"work_extended_address"=>null
      ,"work_address"=>null
      ,"work_city"=>null
      ,"work_state"=>null
      ,"work_postal_code"=>null
      ,"work_country"=>null
      ,"home_po_box"=>null
      ,"home_extended_address"=>null
      ,"home_address"=>null
      ,"home_city"=>null
      ,"home_state"=>null
      ,"home_postal_code"=>null
      ,"home_country"=>null
      ,"office_tel"=>null
      ,"home_tel"=>null
      ,"cell_tel"=>null
      ,"fax_tel"=>null
      ,"pager_tel"=>null
      ,"email1"=>null
      ,"email2"=>null
      ,"url"=>null
      ,"Facebook"=>null
      ,"Twitter"=>null
      ,"Digital_Card"=>null
      ,"Company_Website"=>null
      ,"DigitalCard"=>null
      ,"Facebook_Andriod"=>null
      ,"Twitter_Andriod"=>null
      ,"photo"=>null
      ,"birthday"=>null
      ,"timezone"=>null
      ,"sort_string"=>null
      ,"note"=>null
      );
    if(is_array($data))
    {
        foreach($data as $item => $value)
        {
            $this->data[$item] = $value;
        }
    }
    return true;
  }


    /**
     *The Reload method. This metod update the DATA array content.
     *
     */    
  function reload($data = false) {
    $this->log = "reload() called<br />";

    $this->data = array(
      "display_name"=>null
      ,"first_name"=>null
      ,"last_name"=>null
      ,"additional_name"=>null
      ,"name_prefix"=>null
      ,"name_suffix"=>null
      ,"nickname"=>null
      ,"title"=>null
      ,"role"=>null
      ,"department"=>null
      ,"company"=>null
      ,"work_po_box"=>null
      ,"work_extended_address"=>null
      ,"work_address"=>null
      ,"work_city"=>null
      ,"work_state"=>null
      ,"work_postal_code"=>null
      ,"work_country"=>null
      ,"home_po_box"=>null
      ,"home_extended_address"=>null
      ,"home_address"=>null
      ,"home_city"=>null
      ,"home_state"=>null
      ,"home_postal_code"=>null
      ,"home_country"=>null
      ,"office_tel"=>null
      ,"home_tel"=>null
      ,"cell_tel"=>null
      ,"fax_tel"=>null
      ,"pager_tel"=>null
      ,"email1"=>null
      ,"email2"=>null
      ,"url"=>null
      ,"Facebook"=>null
      ,"Twitter"=>null
      ,"Digital_Card"=>null
      ,"Company_Website"=>null
      ,"DigitalCard"=>null
      ,"Facebook_Andriod"=>null
      ,"Twitter_Andriod"=>null
      ,"Marketing_Video_Andriod"=>null
      ,"Marketing_Video"=>null
      ,"photo"=>null
      ,"birthday"=>null
      ,"timezone"=>null
      ,"sort_string"=>null
      ,"note"=>null
      );
    if(is_array($data))
    {
        foreach($data as $item => $value)
        {
            $this->data[$item] = $value;
        }
    }
    $this->build();
    
    return $this->card;
  }
  
  
  
    /**
     * Build  method checks all the values, builds appropriate defaults for
     * missing values, generates the vcard data string
     *
     * @param 
     * @return VCF file
     */   
  function build() {
    $this->log .= "vcard build() called<br />";
    /*
    For many of the values, if they are not passed in, we set defaults or
    build them based on other values.
    */
    if (!$this->class) { $this->class = "PUBLIC"; }
    if (!$this->data['display_name']) {
      $this->data['display_name'] = trim($this->data['first_name']." ".$this->data['last_name']);
    }
    if (!$this->data['sort_string']) { $this->data['sort_string'] = $this->data['last_name']; }
    if (!$this->data['sort_string']) { $this->data['sort_string'] = $this->data['company']; }
    if (!$this->data['timezone']) { $this->data['timezone'] = date("O"); }
    if (!$this->revision_date) { $this->revision_date = date('Y-m-d H:i:s'); }
    
      $this->card = "BEGIN:VCARD\r\n";
    $this->card .= "VERSION:3.0\r\n";
    $this->card .= "CLASS:".$this->class."\r\n";
    $this->card .= "PRODID:-//Vcard Extended Class from carlos.alcala@upandrunningsoftware.com//NONSGML Version 1//EN\r\n";
    $this->card .= "REV:".$this->revision_date."\r\n";
      $this->card .= "FN:".$this->data['display_name']."\r\n";
    $this->card .= "N:"
      .$this->data['last_name'].";"
      .$this->data['first_name'].";"
      .$this->data['additional_name'].";"
      .$this->data['name_prefix'].";"
      .$this->data['name_suffix']."\r\n";
    if ($this->data['nickname']) { $this->card .= "NICKNAME:".$this->data['nickname']."\r\n"; }
      if ($this->data['title']) { $this->card .= "TITLE:".$this->data['title']."\r\n"; }
      if ($this->data['company']) { $this->card .= "ORG:".$this->data['company']; }
      if ($this->data['department']) { $this->card .= ";".$this->data['department']; }
      $this->card .= "\r\n";
      
      if ($this->data['work_po_box']
    || $this->data['work_extended_address']
    || $this->data['work_address']
    || $this->data['work_city']
    || $this->data['work_state']
    || $this->data['work_postal_code']
    || $this->data['work_country']) {
      $this->card .= "ADR;TYPE=work:"
        .$this->data['work_po_box'].";"
        .$this->data['work_extended_address'].";"
        .$this->data['work_address'].";"
        .$this->data['work_city'].";"
        .$this->data['work_state'].";"
        .$this->data['work_postal_code'].";"
        .$this->data['work_country']."\r\n";
    }
      if ($this->data['home_po_box']
    || $this->data['home_extended_address']
    || $this->data['home_address']
    || $this->data['home_city']
    || $this->data['home_state']
    || $this->data['home_postal_code']
    || $this->data['home_country']) {
      $this->card .= "ADR;TYPE=home:"
        .$this->data['home_po_box'].";"
        .$this->data['home_extended_address'].";"
        .$this->data['home_address'].";"
        .$this->data['home_city'].";"
        .$this->data['home_state'].";"
        .$this->data['home_postal_code'].";"
        .$this->data['home_country']."\r\n";
    }
    if ($this->data['email1']) { $this->card .= "EMAIL;TYPE=internet,pref:".$this->data['email1']."\r\n"; }
    if ($this->data['email2']) { $this->card .= "EMAIL;TYPE=internet:".$this->data['email2']."\r\n"; }
    if ($this->data['office_tel']) { $this->card .= "TEL;TYPE=work,voice:".$this->data['office_tel']."\r\n"; }
    if ($this->data['home_tel']) { $this->card .= "TEL;TYPE=home,voice:".$this->data['home_tel']."\r\n"; }
    if ($this->data['cell_tel']) { $this->card .= "TEL;TYPE=cell,voice:".$this->data['cell_tel']."\r\n"; }
    if ($this->data['fax_tel']) { $this->card .= "TEL;TYPE=work,fax:".$this->data['fax_tel']."\r\n"; }
    if ($this->data['pager_tel']) { $this->card .= "TEL;TYPE=work,pager:".$this->data['pager_tel']."\r\n"; }
    if ($this->data['url']) { $this->card .= "URL;TYPE=work:".$this->data['url']."\r\n"; }
    if ($this->data['Facebook']) { $this->card .= "X-SOCIALPROFILE;type=Facebook:".$this->data['Facebook']."\r\n"; }
    if ($this->data['Twitter']) { $this->card .= "X-SOCIALPROFILE;type=Twitter:".$this->data['Twitter']."\r\n"; }
    if ($this->data['Digital_Card']) { $this->card .= "X-SOCIALPROFILE;type=Digital_Card:".$this->data['Digital_Card']."\r\n"; }
    if ($this->data['Marketing_Video']) { $this->card .= "X-SOCIALPROFILE;type=Marketing_Video:".$this->data['Marketing_Video']."\r\n"; }
    if ($this->data['Company_Website']) { $this->card .= "URL;TYPE=Company_Website:".$this->data['Company_Website']."\r\n"; }
    if ($this->data['DigitalCard']) { $this->card .= "URL;type=DigitalCard:".$this->data['DigitalCard']."\r\n"; }
    if ($this->data['Facebook_Andriod']) { $this->card .= "URL;type=Facebook_Andriod:".$this->data['Facebook_Andriod']."\r\n"; }
    if ($this->data['Twitter_Andriod']) { $this->card .= "URL;type=Twitter_Andriod:".$this->data['Twitter_Andriod']."\r\n"; }
    if ($this->data['Marketing_Video_Andriod']) { $this->card .= "URL;type=Marketing_Video_Andriod:".$this->data['Marketing_Video_Andriod']."\r\n"; }
      if ($this->data['birthday']) { $this->card .= "BDAY:".$this->data['birthday']."\r\n"; }
      if ($this->data['role']) { $this->card .= "ROLE:".$this->data['role']."\r\n"; }
      if ($this->data['note']) { $this->card .= "NOTE:".$this->data['note']."\r\n"; }
      $this->card .= "TZ:".$this->data['timezone']."\r\n";
    $this->card .= "END:VCARD\r\n";
  }

    /**
     * Download method streams the vcard to the browser client.
     *
     * @param 
     * @return VCF file
     */  
    function download() {
        echo $this->getvcard();
        return true;
    }

    /**
     * Zipdownload method. Streams the vcard zipped to the browser client.
     *
     * @param 
     * @return VCF file ZIPPED
     */  
    function zipdownload() {
        
        $this->log .= "vcard download() called<br />";
        if (!$this->card) { $this->build(); }
        if (!$this->filename) { $this->filename = trim($this->data['display_name']); }
        $this->filename = str_replace(" ", "_", $this->filename);
        $datavcard = $this->getvcard();

        $name = $this->filename.".vcf";

        $this->ci->zip->add_data($name, $datavcard);

        // Write the zip file to a folder on your server.
        $this->ci->zip->archive('./vcards/'.$this->filename.'.zip');

        // Download the file to your desktop.
        $this->ci->zip->download($this->filename.'.zip');
        return true;
    }
    /**
     * Get Vcard for Download.
     *
     * @param 
     * @return VCF file
     */  
    function getvcard() {
        $this->log .= "vcard download() called<br />";
        if (!$this->card) { $this->build(); }
        if (!$this->filename) { $this->filename = trim($this->data['display_name']); }
        $this->filename = str_replace(" ", "_", $this->filename);
        header("Content-type: text/directory");
        header("Content-Disposition: attachment; filename=".$this->filename.".vcf");
        header("Pragma: public");
        return $this->card;
        //return true;
    }
    /**
     * Get Vcard for Download.
     *
     * @param 
     * @return VCF file
     */  
    function returnvcard() {
        $this->log .= "vcard download() called<br />";
        if (!$this->card) { $this->build(); }
        if (!$this->filename) { $this->filename = trim($this->data['display_name']); }
        $this->filename = str_replace(" ", "_", $this->filename);
        return $this->card;
        //return true;
    }

    /**
     * Zip Download method. Streams the vcard ARRAY zipped to the browser client.
     *
     * @param 
     * @return VCF file ZIPPED
     */  
    function zipdownloads($filename = false, $vcards = false) {
        
        
        foreach($vcards as $item => $value)
        {
            foreach($value as $key => $val)
            {
                $this->ci->zip->add_data($key, $val);
            }
        }
        // Write the zip file to a folder on your server.
        $this->ci->zip->archive('./vcards/'.$filename.'.zip');
        // Download the file to your desktop.
        $this->ci->zip->download($filename.'.zip');
        return true;
    }        
    
}
?>
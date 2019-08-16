 <?php defined('BASEPATH') OR exit('No direct script access allowed');  

 class Email extends CI_Controller {  
  public function send()  
  {  
   $config = Array(  
      'protocol' => 'smtp',  
      'smtp_host' => 'ssl://smtp.gmail.com',  
      'smtp_port' => 465,  
      'smtp_user' => 'asephendragunawan@gmail.com',   
      'smtp_pass' => 'nyaiyani',   
      'mailtype' => 'html',   
      'charset' => 'iso-8859-1'  
   );  
   
   $this->load->library('email', $config);  
   $this->email->set_newline("\r\n");  
   $this->email->from('asephendragunawan@gmail.com', 'Asep Hendra Gunawan');   
   $this->email->to('asephendra2018@gmail.com');   
   $this->email->subject('Percobaan email');   
   $this->email->message('Ini adalah email percobaan dari Aplikasi sendiri');  
   $this->email->attach('file/rokok.jpg');
   $this->email->attach('file/indo.jpg');

   if (!$this->email->send()) {  
    show_error($this->email->print_debugger());   
   }else{  
    echo 'Success to send email';   
   }  
  }  
 }  
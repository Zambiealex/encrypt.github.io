<?php
class mailer
{
	private $_to,
			$_from,
			$_subject,
			$_message,
			$_headers;
	
	public function __construct()
    {
				//
	}
	
    public function create($to = false, $from = false, $content, $subject = '', $headers = '')
    {
       	if( $to !== false && $from !== false)
		{
			$this->_to = $to;
			$this->_from = $from;
			$this->_subject = $subject;
			$this->_message = $content;
			if( $headers != '')
			{
					$this->_headers = $headers;	
			}
			else 
			{
					$this->_headers  = "From: {$this->_from}\r\n"; 
					$this->_headers .= "Content-type: text/html\r\n"; 
			}
		}
    }

   public function send()
   {
	   			if( !mail($this->_to, $this->_subject, $this->_message, $this->_headers) ) 
				{
						throw new Exception("Email Failed!");
				}
   }
}
?>
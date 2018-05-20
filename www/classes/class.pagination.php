<?php
class pagination {      
        public 	$perPage,
        		$range,
        		$currentPage,
        		$total,
       			$textNav,
        		$itemSelect;
        private $_navigation,     
        		$_link,
       			$_pageNumHtml,
        		$_itemHtml;
        /**
         * Constructor
         */
        public function __construct()
        {
            //set default values
            $this->perPage = 10;
            $this->range        = 5;
            $this->currentPage  = 1;       
            $this->total        = 0;
            $this->textNav      = true;
            $this->itemSelect   = array( 5, 25, 50, 100, 'All');        
                 
            //$this->_link         = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
            $this->_pageNumHtml  = '';
            $this->_itemHtml     = '';
        }
         
        /**
         * paginate main function
         *
         * @author              The-Di-Lab <thedilab@gmail.com>
         * @access              public
         * @return              type
         */
        public function paginate($page, $current)
        {
            //
			$this->_link = $page;  
			
			 //private values
            $this->_navigation  = array(
                    'next'=> lang::output('pagination_next', 1) ,
                    'pre' => lang::output('pagination_prev', 1),
                    'ipp' => lang::output('pagination_itemperpage', 1)
            );   
			
			//
			$this->currentPage  = $current;   
			
            //
            $this->_pageNumHtml = $this->_getPageNumbers();   
			  
			$this->_itemHtml  = $this->_getItemSelect();
			//
			return $this->_pageNumHtml;
        }
                 
        /**
         * return pagination numbers in a format of UL list
         *
         * @author              The-Di-Lab <thedilab@gmail.com>
         * @access              public
         * @param               type $parameter
         * @return              string
         */
        public function pageNumbers()
        {
            if(empty($this->_pageNumHtml)){
                exit('Please call function paginate() first.');
            }
            return $this->_pageNumHtml;
        }
         
        /**
         * return jump menu in a format of select box
         *
         * @author              The-Di-Lab <thedilab@gmail.com>
         * @access              public
         * @return              string
         */
        public function perPage ()
        {         
            if(empty($this->_itemHtml)){
                exit('Please call function paginate() first.');
            }
            return $this->_itemHtml;   
        }
         
        /**
         * return page numbers html formats
         *
         * @author              The-Di-Lab <thedilab@gmail.com>
         * @access              public
         * @return              string
         */
        private function  _getPageNumbers()
        {
			$lastpage = ceil($this->total/$this->perPage);
            $html  = '<ul class="pagination">';
            //previous link button
            if($this->textNav&&($this->currentPage>1)){
                $html .= '<li><a class="prev" href="'.$this->_link .($this->currentPage-1).'"';
                $html .= '>'.$this->_navigation['pre'].'</a></li>';
            }          
            //do ranged pagination only when total pages is greater than the range
            if($this->total > $this->range){               
                $start = ($this->currentPage <= $this->range)?1:($this->currentPage - $this->range);
                $end   = ($lastpage - $this->currentPage <= $this->range) ? $lastpage : ($this->currentPage+$this->range) ;
            }else{
                $start = 1;
                $end   = $lastpage;
            }   
            //loop through page numbers
            for($i = $start; $i <= $end; $i++){
                   
				  	$html .= '<li><a href="'.$this->_link . $i.'"';
                    if($i==$this->currentPage)
							$html .= "class='current'"; 
                    $html .= '>'.$i.'</a></li>'; 
            }          
            //next link button
            if($this->textNav&&($this->currentPage<$lastpage)){
                 $html .= '<li><a class="next" href="'.$this->_link .($this->currentPage+1).'"';
                 $html .= '>'.$this->_navigation['next'].'</a></li>';
            }
            $html .= '</ul>';
            return $html;
        }
         
        /**
         * return item select box
         *
         * @author              The-Di-Lab <thedilab@gmail.com>
         * @access              public
         * @return              string
         */
        private function  _getItemSelect()
        {
            $items = '';
            $ippArray = $this->itemSelect;             
            foreach($ippArray as $ippOpt){  
                $items .= ($ippOpt == $this->perPage ) ? "<option selected value=\"$ippOpt\">$ippOpt</option>\n":"<option value=\"$ippOpt\">$ippOpt</option>\n";
            }              
            return "<span class=\"paginate\">".$this->_navigation['ipp']."</span>
            <select class=\"paginate\" onchange=\"window.location='$this->_link?current=1&item='+this[this.selectedIndex].value;return false\">$items</select>\n";     
        }
}
?>
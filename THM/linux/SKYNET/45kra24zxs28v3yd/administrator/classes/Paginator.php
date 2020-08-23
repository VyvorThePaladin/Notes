<?php
	/**
	* @package		Cuppa CMS
	* @copyright	Copyright (C) 2011 Open Source Matters, T-Golden Group :: tufik2@hotmail.com
	* @Version 		b.0..1 (GPL)
	*/
	
	class Paginator{
		public function Paginator(){ }
		// Create a personal paginator
			public function GetPaginator($current_page = 1, $total_pages = 2){
				if(!$current_page) $current_page = 1;
				$this->current_page = $current_page;
				$this->total_pages = $total_pages;
				return $this->GetField($current_page, $total_pages);
			}
		// Create a paginator passing: table_name of data_base, current_page and, list_limit
			public function GetAutoPaginator($table_name, $token = "", $current_page = 1, $list_limit = 25){
				if(!$current_page) $current_page = 1;
				$db = DataBase::getInstance();
				$total_rows = $db->GetTotalRows($table_name, $token);
				$total_pages = ceil($total_rows/$list_limit);
				if($total_pages == 1) return NULL;
				return $this->GetField($current_page, $total_pages);
			}
			private function GetField($current_page = 1, $total_pages = 2){
				if(!$total_pages) return;
				$field = "<div class='paginator'>";
					$field .= "<ul>";
						if($current_page > 1) $field .= "<li><a onclick='ChangePage(1)'><div title='First page' class='paging_far_left'></div></a></li>";
						if($current_page > 1) $field .= "<li><a onclick='ChangePage(".($current_page-1).")'><div title='Prev page' class='paging_left'></div></a></li>";
						$field .= "<li><div title=''  class='current_page'>Page <b>$current_page</b> / $total_pages</div></li>";
						if($current_page < $total_pages) $field .= "<li><a onclick='ChangePage(".($current_page+1).")'><div title='Next page' class='paging_right'></div></a></li>";
						if($current_page < $total_pages) $field .= "<li><a onclick='ChangePage($total_pages)'><div title='Last page' class='paging_far_right'></div></a></li>";
						$field .= "<li><div class='select_page_div'>".$this->GetPagesList($current_page, $total_pages)."</div></li>";
					$field .= "</ul>";
					$field .= "<form id='form_paginator' name='form_paginator' method='post'><input type='hidden' value='1' id='page' name='page' /><input type='hidden' id='task' name='task' /></form>";
				$field .= "</div>";
				return $field;
			}
			private function GetPagesList($current_page, $totalPages){
				$field = "<select onchange='ChangePage(this.value)' class='select_page' id='select_page' name='select_page'>";
					$field .= "<option value='$current_page' >Select page</option>";
					for($i = 1; $i <= $totalPages; $i++ ){
						if($i != $current_page) $field .= "<option value='$i'>$i</option>";
					}
				$field .= "</select>";
				return $field;
			}
	}
?>
<script>
	function ChangePage(page){
		jQuery("#page").val(page);
		document.forms["form_paginator"].submit();
	}
</script>

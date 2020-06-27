<a  href="<?php echo site_url('admin/store/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Store'); ?></h5>
<!--Data display of store with id--> 
<?php
	$c = $store;
?> 
<table class="table table-striped table-bordered">         
		<tr><td>Country</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('Country_model');
									   $dataArr = $this->CI->Country_model->get_country($c['country_id']);
									   echo $dataArr['sortname'];?>
									</td></tr>

<tr><td>State</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('State_model');
									   $dataArr = $this->CI->State_model->get_state($c['state_id']);
									   echo $dataArr['name'];?>
									</td></tr>

<tr><td>City</td><td><?php
									   $this->CI =& get_instance();
									   $this->CI->load->database();	
									   $this->CI->load->model('City_model');
									   $dataArr = $this->CI->City_model->get_city($c['city_id']);
									   echo $dataArr['name'];?>
									</td></tr>


</table>
<!--End of Data display of store with id//--> 
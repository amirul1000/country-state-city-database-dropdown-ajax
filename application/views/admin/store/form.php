<script language="javascript">
function fillUpState(country_id)
{
    objselect = document.getElementById("state_id");
    objselect.options.length = 0;
    //$("#spinner2").html('<img src="../images/indicator.gif" alt="Wait" />');
    $.ajax({  
      url: '<?php echo site_url('admin/store/state/'); ?>'+country_id,
      success: function(data) {
              var obj = eval(data); 
              
              objselect.add(new Option('--select--',''), null);
              for(var i=0;i<obj.length;i++)
              {
                 text = obj[i].name;
                 objselect.add(new Option(text,obj[i].id), null);
              }
           // $("#spinner2").html('');
          }
        });
}
function fillUpCity(state_id)
{
    objselect = document.getElementById("city_id");
    objselect.options.length = 0;
    //$("#spinner2").html('<img src="../images/indicator.gif" alt="Wait" />');
    $.ajax({  
      url: '<?php echo site_url('admin/store/city/'); ?>'+state_id,
      success: function(data) {
              var obj = eval(data);    
              
              objselect.add(new Option('--select--',''), null);
              for(var i=0;i<obj.length;i++)
              {
                 text = obj[i].name;
                 objselect.add(new Option(text,obj[i].id), null);
              }
           // $("#spinner2").html('');
          }
        });
}
</script>


<a  href="<?php echo site_url('admin/store/index'); ?>" class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Store'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/store/save/'.$store['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
   <div class="card-body">    
        <div class="form-group"> 
                                    <label for="Country" class="col-md-4 control-label">Country</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('Country_model'); 
             $dataArr = $this->CI->Country_model->get_all_country(); 
          ?> 
          <select name="country_id"  id="country_id" onChange="fillUpState(this.value);"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($store['country_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['country']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="State" class="col-md-4 control-label">State</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('State_model'); 
             $dataArr = $this->CI->State_model->get_all_state(); 
          ?> 
          <select name="state_id"  id="state_id"  onChange="fillUpCity(this.value);" class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($store['state_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>
<div class="form-group"> 
                                    <label for="City" class="col-md-4 control-label">City</label> 
         <div class="col-md-8"> 
          <?php 
             $this->CI =& get_instance(); 
             $this->CI->load->database();  
             $this->CI->load->model('City_model'); 
             $dataArr = $this->CI->City_model->get_all_city(); 
          ?> 
          <select name="city_id"  id="city_id"  class="form-control"/> 
            <option value="">--Select--</option> 
            <?php 
             for($i=0;$i<count($dataArr);$i++) 
             {  
            ?> 
            <option value="<?=$dataArr[$i]['id']?>" <?php if($store['city_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['name']?></option> 
            <?php 
             } 
            ?> 
          </select> 
         </div> 
           </div>

   </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" class="btn btn-success"><?php if(empty($store['id'])){?>Save<?php }else{?>Update<?php } ?></button>
    </div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->	
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>  			
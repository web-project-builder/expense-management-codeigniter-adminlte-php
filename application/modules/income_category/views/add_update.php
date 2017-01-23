<form action="<?php echo base_url()."income_category/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 30px">
 <?php if(isset($data->income_category_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->income_category_id) ?$data->income_category_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group">
			 		<label for="category_name">Category Name <span class="text-red">*</span></label>
<input type="text" placeholder=" Category Name" class="form-control" id="category_name" name="category_name" required value="<?php echo isset($data->category_name)?$data->category_name:"";?>"  >
</div>
</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="Save" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
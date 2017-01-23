<form action="<?php echo base_url()."expenses/add_edit"; ?>" method="post" role="form" id="form" enctype="multipart/form-data" style="padding: 0px 30px">
 <?php if(isset($data->expenses_id)){?><input type="hidden"  name="id" value="<?php echo isset($data->expenses_id) ?$data->expenses_id : "";?>"> <?php } ?>
 <div class="box-body"><div class="form-group">
			 		<label for="date">Date <span class="text-red">*</span></label>
<input type="date" placeholder=" Date" class="form-control" id="date" name="date" required value="<?php echo isset($data->date)?date("Y-m-d",strtotime($data->date)):date("Y-m-d",strtotime("now"));?>"  >
</div>
<div class="form-group">
			 		<label for="description">Description <span class="text-red">*</span></label>
<input type="text" placeholder=" Description" class="form-control" id="description" name="description" required value="<?php echo isset($data->description)?$data->description:"";?>"  >
</div>
<div class="form-group">
			 		<label for="amount">Amount <span class="text-red">*</span></label>
<input type="number" step="any" placeholder=" Amount" class="form-control" id="amount" name="amount" required value="<?php echo isset($data->amount)?$data->amount:"";?>"  >
</div>
<div class="form-group">
			 		<label for="category">Category </label>
<?php echo selectBoxDynamic("category","expense_category","category_name",isset($data->category) ?$data->category : "");?>
</div>
<div class="form-group">
			 		<label for="upload_receipt">Upload Receipt </label>
<?php  if( isset($data->upload_receipt) && !empty($data->upload_receipt)){ $req ="";}else{$req ="";}
						if(isset($data->upload_receipt))
						{ 
							?>
							<input type="hidden"  name="fileOld" value="<?php echo isset($data->upload_receipt) ?$data->upload_receipt : "";?>">
							<a href="<?php echo base_url().'assets/images/'.$data->upload_receipt ?>" download> <?php echo $data->upload_receipt; ?> </a>
						<?php 
						} 
						?>
						<input type="file" placeholder=" Upload Receipt" class="file-upload" id="upload_receipt" name="upload_receipt" <?php echo $req; ?> value="" onchange='validate_fileType(this.value,&quot;upload_receipt&quot;,&quot;pdf,jpg,png,jpeg,docx,doc,xlsx,xls&quot;);'><p id="error_upload_receipt"></p>
</div>
</div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                  	 <input type="submit" value="Save" name="save" class="btn btn-primary btn-color">
                  </div>
               </form>
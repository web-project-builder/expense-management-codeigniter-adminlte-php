<!-- start: PAGE CONTENT -->
	<div class="content-wrapper">
		<!-- Main content -->
          <section class="content">
            <?php if($this->session->flashdata("message")){?><div class="alert alert-info" id="successMessage"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $this->session->flashdata("message")?></div><?php }?>
                <div class="row">
                   <div class="col-xs-12">
                     <div class="box box-success">
						<div class="box-header with-border">
                           <h3 class="box-title">Income category</h3>
                              <div class="box-tools pull-right">
                                 <?php if(CheckPermission("income_category", "own_create")){ ?>
                                 <button type="button" class="btn-sm  btn btn-success amDisable modalButton" data-toggle="modal" data-src="" data-width="555" data-target="#nameModal_income_category"><i class="glyphicon glyphicon-plus"></i> Add Income category</button>
                              <?php }?>
                              </div>
                            </div>
                 	 <!-- /.box-header -->
                     <div class="box-body">
<table id="example_income_category" class="cell-border example_income_category table table-striped table1 table-bordered table-hover dataTable">
								  <thead>
								 	<tr>
										<th><input type="checkbox" class="selAll"></th>
<th>Category Name</th>
<th>Action</th>
</tr>
														</thead>
														<tbody>
<?php $this->load->view('tableData'); ?></tbody> 
														</table>
                           </div>
                           <!-- /.box-body -->
                        </div>
                     <!-- /.box -->
                   </div>
                <!-- /.col -->
              </div>
            <!-- /.row -->
          </section>
        <!-- /.Main-content -->
      </div>
<!-- /.content-wrapper -->

<div class="modal fade" id="nameModal_income_category"  role="dialog"><!-- Modal Crud Start-->
	<div class="modal-dialog">
		<div class="box box-primary popup" >
			<div class="box-header with-border formsize">
				  <h3 class="box-title">Income category</h3>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body" style="padding: 0px 0px 0px 0px;">
			</div>
		</div>
	</div>
</div><!--End Modal Crud -->

<script type="text/javascript">
jQuery(document).ready(function($) { 
	var url = "<?php echo base_url();?>";
var table = $("#example_income_category").DataTable({
  			
        "processing": true,
        "serverSide": false,
				"sPaginationType": "full_numbers",
				"language": {
					"search": "_INPUT_", 
					"searchPlaceholder": "Search",
					"paginate": {
					    	"next": '<i class="fa fa-angle-right"></i>',
					      "previous": '<i class="fa fa-angle-left"></i>',
					      "first": '<i class="fa fa-angle-double-left"></i>',
					      "last": '<i class="fa fa-angle-double-right"></i>'
					    }
				}, 
				"iDisplayLength": 10,
				"aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]],
				"columnDefs" : [
					{
						"orderable": false, 
						"targets": [0]
					}<?php if(!CheckPermission("income_category", "all_delete") && !CheckPermission("income_category", "own_delete")){ ?>
					,{
            "targets": [0],
            "visible": false,
            "searchable": false
          }
          <?php } ?>
				],
				"order": [[1, 'asc']],
    });
		$(".daterange-filter").on("change", function() {
		  var dateRange = $(this).val();
		  var colName = "";
		  $.ajax({
		    url: '<?php echo base_url().'income_category/getFilterdata'; ?>',
		    method: 'post',
		    data:{
		      dateRange: dateRange,
		      colName : colName
		    }
		  }).done(function(data) {
		    table.destroy();
		    $('tbody').html(data);
		    table = $("#example_income_category").DataTable({
		    	
	        "processing": true,
	        "serverSide": false,
					"sPaginationType": "full_numbers",
					"language": {
						"search": "_INPUT_", 
						"searchPlaceholder": "Search",
						"paginate": {
						    	"next": '<i class="fa fa-angle-right"></i>',
						      "previous": '<i class="fa fa-angle-left"></i>',
						      "first": '<i class="fa fa-angle-double-left"></i>',
						      "last": '<i class="fa fa-angle-double-right"></i>'
						    }
					}, 
					"iDisplayLength": 10,
					"aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]],
					"columnDefs" : [
						{
							"orderable": false, 
							"targets": [0]
						}<?php if(!CheckPermission("income_category", "all_delete") && !CheckPermission("income_category", "own_delete")){ ?>
					,{
            "targets": [0],
            "visible": false,
            "searchable": false
          }
          <?php } ?>
					],
					"order": [[1, 'asc']],
	    	});
		  });

		});

    $(".daterange-picker").daterangepicker(
    {
        locale: {
          format: "DD-MM-YYYY"
        },
        startDate: "<?php echo $sDate = "01-".date("m-Y"); ?>",
        endDate: "<?php echo date("d-m-Y", strtotime($sDate. " + 60 day")); ?>"
    });

} );

( function($) {
$(document).ready(function(){
	var  cjhk = 0;
	<?php if(CheckPermission("income_category", "all_delete") || CheckPermission("income_category", "own_delete")){ ?>
		cjhk = 1;
	<?php } ?>
	setTimeout(function() {
		var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
		$('.table-date-range').css('right',add_width+'px');

		if(cjhk == 1) {
			$('.dataTables_info').before('<button data-del-url="<?php echo base_url() ?>income_category/delete/" class="btn btn-default btn-sm btn-blk-del pull-left"> <i class="fa fa-trash"></i> </button><br><br>');	
		}
	}, 300);

	$('.box-body').on('click','.btn-blk-del', function() {
		$obj = $(this);
		$ids = '';
		$('[name="selData"]').each(function(){
			if($(this).is(':checked')){
				$ids += $(this).val() + '-';
			}
		})
		if($ids != ''){
			$ids = $ids.slice(0, -1);
			$('#cnfrm_delete').find('.yes-btn').attr('href', $obj.attr('data-del-url') + $ids)
			$('#cnfrm_delete').modal('show');
		} else {
			alert('Nothig is seleted to delete...');
		}
	});

	$(".content-wrapper").on("click",".modalButton", function(e) {  
		$.ajax({
			url : "<?php echo base_url()."income_category/get_modal";?>",
			method: "post", 
			data : {
			id: $(this).attr("data-src")
			}
			}).done(function(data) {
			$("#nameModal_income_category").find(".modal-body").html(data);
			$("#nameModal_income_category").modal("show"); 
		})
	});
});
} ) ( jQuery );
</script>

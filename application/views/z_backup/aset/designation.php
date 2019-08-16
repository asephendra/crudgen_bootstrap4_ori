

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Aset</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Aset</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Penempatan Aset</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('aset/designation') ?>" method="post" class="form-horizontal">
              <div class="box-body">
                <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-12 control-label">Date: <?php echo date('Y-m-d') ?> ~ <?php echo date('h:i a') ?></label>
                </div>
                <div class="col-md-4 col-xs-12 pull pull-left">
                  <div class="form-group">
                    <label for="cabang" class="col-sm-5 control-label" style="text-align:left;">Cabang</label>
                    <div class="col-sm-7">
                      <select name="cabang" id="cabang" class="form-control" onchange="get_lokasi()" required>
                        <option value="">Pilih cabang..</option>
                        <option value="1">Cabang 1</option>
                        <option value="2">Cabang 2</option>
                        <option value="3">Cabang 3</option>
                        <option value="4">Cabang 4</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="lokasi" class="col-sm-5 control-label" style="text-align:left;">Lokasi</label>
                    <div class="col-sm-7">
                      <select name="lokasi" id="lokasi" class="form-control" required>
                        <option value=""></option>
                                                 
                      </select>
                    </div>
                  </div>

                 </div>
                <br /> <br/>
                <table class="table table-bordered" id="product_info_table">
                  <thead>
                    <tr>
                      <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                      <th style="width:30%">Barcode</th>
                      <th style="width:40%">Nama Barang</th>
                      <th style="width:20%">Rate</th>
                    </tr>
                  </thead>
                 <tbody>
                     <tr id="row_1">
                      <td></td>
                       <td>
                        <select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product[]" style="width:100%;" onchange="getAsetData(1)" required>
                            <option value=""></option>
                            <?php foreach ($aset as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>"><?php echo $v['barcode'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </td>
                        <td>
                          <input type="text" name="rate[]" id="rate_1" class="form-control" required onkeyup="getTotal(1)" autocomplete="off" disabled>
                          <input type="hidden" name="rate_value[]" id="rate_value_1" class="form-control" autocomplete="off">
                        </td>
                        <td>
                          <input type="text" name="qty[]" id="qty_1" class="form-control" disabled required onkeyup="getTotal(1)">
                        </td>
                     </tr>

                   </tbody>
                </table>

                <br /> <br/>

                <div class="col-md-6 col-xs-12 pull pull-right">

                  <div class="form-group">
                    <label for="gross_amount"  class="col-sm-7 control-label">Total</label>
                    <div class="col-sm-5">
                      <input type="text" class="form-control" id="gross_amount" name="gross_amount" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="gross_amount_value" name="gross_amount_value" autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
                
                <a href="<?php echo base_url('aset/penempatan') ?>" class="btn btn-warning pull-right">Back</a><button type="submit" class="btn btn-primary pull-right">Simpan</button>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $("#mainAsetNav").addClass('active');
    $("#addAsetNav").addClass('active');
    $(".select_group").select2();
  
  var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
  
    // Add new row in the table 
    $("#add_row").unbind('click').bind('click', function() {
      var table = $("#product_info_table");
      var count_table_tbody_tr = $("#product_info_table tbody tr").length;
      var row_id = count_table_tbody_tr + 1;
      $.ajax({
          url: base_url + '/aset/getTableAsetRow/',
          type: 'post',
          dataType: 'json',
          success:function(response) {
            
              // console.log(reponse.x);
               var html = '<tr id="row_'+row_id+'">'+
               '<td><button type="button" class="btn btn-default" onclick="removeRow(\''+row_id+'\')"><i class="fa fa-close"></i></button></td>'+
                   '<td>'+ 
                    '<select class="form-control select_group product" data-row-id="'+row_id+'" id="product_'+row_id+'" name="product[]" style="width:100%;" onchange="getAsetData('+row_id+')">'+
                        '<option value=""></option>';
                        $.each(response, function(index, value) {
                          html += '<option value="'+value.id+'">'+value.barcode+'</option>';             
                        });
                        
                      html += '</select>'+
                    '</td>'+ 
                    '<td><input type="text" name="rate[]" id="rate_'+row_id+'" class="form-control" readonly onkeyup="getTotal('+row_id+')"><input type="hidden" name="rate_value[]" id="rate_value_'+row_id+'" class="form-control"></td>'+
                    '<td><input type="text" name="qty[]" id="qty_'+row_id+'" class="form-control" readonly onkeyup="getTotal('+row_id+')"></td>'+
                    
                    '</tr>';

                if(count_table_tbody_tr >= 1) {
                $("#product_info_table tbody tr:last").after(html);  
              }
              else {
                $("#product_info_table tbody").html(html);
              }

              $(".product").select2();

          }
        });

      return false;
    });

  }); // /document

  function get_lokasi() {
      var cabang = $("#cabang").val(); 
      $.ajax({
            url: base_url + 'aset/get_lokasi',
            type: 'post',
            data: {cabang : cabang},
            success: function(response)
            {
              $('#lokasi').html(response);
            }
        });
    }


  function getTotal(row = null) {
    if(row) {
      var total = Number($("#rate_"+row).val()) * Number($("#qty_"+row).val());
      total = total.toFixed(2);
      $("#amount_"+row).val(total);
      $("#amount_value_"+row).val(total);
      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }

  function getAsetData(row_id)
  {
    var product_id = $("#product_"+row_id).val();    
    if(product_id == "") {

    } else {
      $.ajax({
        url: base_url + 'aset/getAsetValueById',
        type: 'post',
        data: {product_id : product_id},
        dataType: 'json',
        success:function(response) {
          $("#rate_"+row_id).attr("disabled",false);
          $("#qty_"+row_id).attr("disabled",false);
          $("#rate_"+row_id).attr("readonly",true);
          $("#qty_"+row_id).attr("readonly",true);
          $("#rate_"+row_id).val(response.name);
          $("#qty_"+row_id).val(response.rate);
        subAmount();
        } 
      }); 
    }
  }
  


  // calculate the total amount of the order
  function subAmount() {
    var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;
    for(x = 0; x < tableProductLength; x++) {
      var tr = $("#product_info_table tbody tr")[x];
      var count = $(tr).attr('id');
      count = count.substring(4);
      totalSubAmount = Number(totalSubAmount) + Number($("#qty_"+count).val());
    } // /for

    totalSubAmount = totalSubAmount.toFixed(0);
    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);
  } // /sub total amount
  function removeRow(tr_id)
  {
    $("#product_info_table tbody tr#row_"+tr_id).remove();
    subAmount();
  }
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div id="messages"></div>

        {php_open} if($this->session->flashdata('success')): {php_close}
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {php_open} echo $this->session->flashdata('success'); {php_close}
          </div>
        {php_open} elseif($this->session->flashdata('error')): {php_close}
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {php_open} echo $this->session->flashdata('error'); {php_close}
          </div>
        {php_open} endif; {php_close}

        {php_open} if(in_array('createTabel', $user_permission)): {php_close}
          <button class="btn btn-primary" data-toggle="modal" data-target="#addTabelModal">Add Tabel</button>
          <br /> <br />
        {php_open} endif; {php_close}

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Manage {title_name}</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <!-- *************** -->
              <tr>
                {list_fields}<th>{label}</th>{/list_fileds}
                
                {php_open} if(in_array('update_{table_name}', $user_permission) || in_array('delete_{table_name}', $user_permission)): {php_close}
                  <th>#</th>
                {php_open} endif; {php_close}
              </tr>
              <!-- ******************* -->
              </thead>

            </table>
          </div>
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




{php_open} if(in_array('create_{table_name}', $user_permission)): {php_close}
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addTabelModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add {table_name}</h4>
      </div>

      <form role="form" action="{php_open} echo base_url('{table_name}/create') {php_close}" method="post" id="createTabelForm">

        <div class="modal-body">
          <!-- **************************** -->
          <div class="form-group">
            <label for="post1">Brand Name</label>
            <input type="text" class="form-control" id="post1" name="post1" placeholder="" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control" id="active" name="active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
          </div>
          <!-- ******************************** -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{php_open} endif; {php_close}




{php_open} if(in_array('updateTabel', $user_permission)): {php_close}
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editTabelModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Tabel</h4>
      </div>

      <form role="form" action="{php_open} echo base_url('tabel/update') {php_close}" method="post" id="updateTabelForm">
        <div class="modal-body">
          <div id="messages"></div>

          <!-- *********************** form ****************** -->
          <div class="form-group">
            <label for="edit_brand_name">Tabel Name</label>
            <input type="text" class="form-control" id="edit_brand_name" name="edit_brand_name" placeholder="Enter brand name" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit_active">Status</label>
            <select class="form-control" id="edit_active" name="edit_active">
              <option value="1">Active</option>
              <option value="2">Inactive</option>
            </select>
          </div>


        </div> <!-- ******* modal body ************ -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{php_open} endif; {php_close}




{php_open} if(in_array('deleteTabel', $user_permission)): {php_close}
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeTabelModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Tabel</h4>
      </div>

      <form role="form" action="{php_open} echo base_url('tabel/remove') {php_close}" method="post" id="removeTabelForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{php_open} endif; {php_close}







<script type="text/javascript">
var manageTable;
$(document).ready(function() {
  $("#tabelNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'fetchTabelData',
    'order': []
  });

  // submit the create from 
  $("#createTabelForm").unbind('submit').on('submit', function() {
    var form = $(this);
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {
        manageTable.ajax.reload(null, false); 
        if(response.success === true) {
          $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');

          // hide the modal
          $("#addTabelModal").modal('hide');
          // reset the form
          $("#createTabelForm")[0].reset();
          $("#createTabelForm .form-group").removeClass('has-error').removeClass('has-success');

        } else {
          if(response.messages instanceof Object) {
            $.each(response.messages, function(index, value) {
              var id = $("#"+index);
              id.closest('.form-group')
              .removeClass('has-error')
              .removeClass('has-success')
              .addClass(value.length > 0 ? 'has-error' : 'has-success');
              id.after(value);
            });
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    }); 

    return false;
  });


});

function editTabel(id)
{ 
  $.ajax({
    url: 'fetchTabelById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {


      // *************************** edit *******************************
      $("#edit_kolom1").val(response.edit_kolom1);
      $("#edit_kolom2").val(response.edit_kolom2);

      // submit the edit from 
      $("#updateTabelForm").unbind('submit').bind('submit', function() {
        var form = $(this);
        $(".text-danger").remove();
        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {
            manageTable.ajax.reload(null, false); 
            if(response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');

              $("#editTabelModal").modal('hide');
              // reset the form 
              $("#updateTabelForm .form-group").removeClass('has-error').removeClass('has-success');
            } else {
              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);
                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  id.after(value);
                });
              } else {
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 
        return false;
      });
    }
  });
}

function removeTabel(id)
{
  if(id) {
    $("#removeTabelForm").on('submit', function() {
      var form = $(this);
      $(".text-danger").remove();
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),

        // ******************************* edit *****************
        data: { kolom_id:id }, 
        dataType: 'json',
        success:function(response) {
          manageTable.ajax.reload(null, false); 
          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');
            $("#removeTabelModal").modal('hide');
          } else {
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 
      return false;
    });
  }
}
</script>

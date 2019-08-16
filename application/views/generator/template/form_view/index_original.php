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

        {php_open} if(in_array('create_{table_name}', $user_permission)): {php_close}
          <button class="btn btn-primary" data-toggle="modal" data-target="#add_{table_name}Modal">Add {title_name}</button>
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
                {list_fields}<th>{label}</th>{/list_fields}
                
                {php_open} ///x if(in_array('update_{table_name}', $user_permission) || in_array('delete_{table_name}', $user_permission)): {php_close}
                  <th>#</th>
                {php_open} ///x endif; {php_close}
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




{php_open} //if(in_array('create_{table_name}', $user_permission)): {php_close}
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="add_{table_name}Modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add {table_name}</h4>
      </div>

      <form role="form" action="{php_open} echo base_url('{table_name}/create') {php_close}" method="post" id="create_{table_name}Form">
        <div class="modal-body">
        {list_fields}
          <div class="form-group">
            <label for="post1">{label}</label>
            <input type="text" class="form-control" id="{name}" name="{name}" placeholder="" autocomplete="off">
          </div>
        {/list_fields}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{php_open} // endif; {php_close}




{php_open} // if(in_array('update_{table_name}', $user_permission)): {php_close}
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit_{table_name}Modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit {title_name}</h4>
      </div>

      <form role="form" action="{php_open} echo base_url('{table_name}/update') {php_close}" method="post" id="update_{table_name}Form">
        <div class="modal-body">
          <div id="messages"></div>
          {list_fields}
          <div class="form-group">
            <label for="{name}">{label}</label>
            <input type="text" class="form-control" id="edit_{name}" name="{name}" placeholder="" autocomplete="off">
          </div>
          {/list_fields}

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
{php_open} // endif; {php_close}




{php_open} //if(in_array('delete_{table_name', $user_permission)): {php_close}
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="remove_{table_name}Modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove {table_name}</h4>
      </div>

      <form role="form" action="{php_open} echo base_url('{table_name}/remove') {php_close}" method="post" id="remove_{table_name}Form">
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
{php_open} //endif; {php_close}







<script type="text/javascript">
var manageTable;
$(document).ready(function() {
  $("#{table_name}Nav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'fetch_{table_name}Data',
    'order': []
  });

  // submit the create from 
  $("#create_{table_name}Form").unbind('submit').on('submit', function() {
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
          $("#add_{table_name}Modal").modal('hide');
          // reset the form
          $("#create_{table_name}Form")[0].reset();
          $("#create_{table_name}Form .form-group").removeClass('has-error').removeClass('has-success');

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

function edit_{table_name}(id)
{ 
  $.ajax({
    url: 'fetch_{table_name}ById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

      {list_fields}
      $("#edit_{name}").val(response.{name});{/list_fields}

      $("#update_{table_name}Form").unbind('submit').bind('submit', function() {
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

              $("#edit_{table_name}Modal").modal('hide');
              // reset the form 
              $("#update_{table_name}Form .form-group").removeClass('has-error').removeClass('has-success');
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

function remove_{table_name}(id)
{
  if(id) {
    $("#remove_{table_name}Form").on('submit', function() {
      var form = $(this);
      $(".text-danger").remove();
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),

        // ******************************* edit *****************
        data: { id:id }, 
        dataType: 'json',
        success:function(response) {
          manageTable.ajax.reload(null, false); 
          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');
            $("#remove_{table_name}Modal").modal('hide');
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

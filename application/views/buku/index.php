<div class="card ">
  <h5 class="card-header text-white bg-info mb-3">Judul Table
  <?php if(in_array('create_buku', $user_permission)): ?>
    <button class="btn btn-sm btn-outline-warning right" data-toggle="modal" data-target="#add_bukuModal">Tambah Buku</button></h5>
  <?php endif; ?>
  <div class="card-body">

<table id="manageTable" class="display compact" width="100%">
  <thead>
  <tr>
    <th>Name</th><th>Judul</th>
    
    <?php ///x if(in_array('update_buku', $user_permission) || in_array('delete_buku', $user_permission)): ?>
      <th>#</th>
    <?php ///x endif; ?>
  </tr>
  </thead>
</table>
</div>
</div>





<?php //if(in_array('create_buku', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="add_bukuModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah buku</h4>
      </div>

      <form role="form" action="<?php echo base_url('buku/create') ?>" method="post" id="create_bukuForm">
        <div class="modal-body">
        
          <div class="form-group">
            <label for="post1">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="" autocomplete="off">
          </div>
        
          <div class="form-group">
            <label for="post1">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="" autocomplete="off">
          </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php // endif; ?>




<?php // if(in_array('update_buku', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit_bukuModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Buku</h4>
      </div>

      <form role="form" action="<?php echo base_url('buku/update') ?>" method="post" id="update_bukuForm">
        <div class="modal-body">
          <div id="messages"></div>
          
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="edit_name" name="name" placeholder="" autocomplete="off">
          </div>
          
          <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="edit_judul" name="judul" placeholder="" autocomplete="off">
          </div>
          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php // endif; ?>




<?php //if(in_array('delete_{table_name', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="remove_bukuModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove buku</h4>
      </div>

      <form role="form" action="<?php echo base_url('buku/remove') ?>" method="post" id="remove_bukuForm">
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
<?php //endif; ?>







<script type="text/javascript">
var manageTable;
$(document).ready(function() {
  $("#bukuNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'buku/fetch_bukuData',
    'order': []
  });

  // submit the create from 
  $("#create_bukuForm").unbind('submit').on('submit', function() {
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
          $("#add_bukuModal").modal('hide');
          // reset the form
          $("#create_bukuForm")[0].reset();
          $("#create_bukuForm .form-group").removeClass('has-error').removeClass('has-success');

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

function edit_buku(id)
{ 
  $.ajax({
    url: 'buku/fetch_bukuById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

      
      $("#edit_name").val(response.name);
      $("#edit_judul").val(response.judul);

      $("#update_bukuForm").unbind('submit').bind('submit', function() {
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

              $("#edit_bukuModal").modal('hide');
              // reset the form 
              $("#update_bukuForm .form-group").removeClass('has-error').removeClass('has-success');
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

function remove_buku(id)
{
  if(id) {
    $("#remove_bukuForm").on('submit', function() {
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
            $("#remove_bukuModal").modal('hide');
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

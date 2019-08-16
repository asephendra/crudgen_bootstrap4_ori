
<div class="card">
  <h5 class="card-header text-white bg-info mb-3">Judul Table
  <?php// if(in_array('create_contoh', $user_permission)): ?>
    <button class="btn btn-sm btn-outline-warning right" data-toggle="modal" data-target="#add_contohModal">Tambah Contoh</button></h5>
  <?php// endif; ?>
  <div class="card-body">
  <table id="manageTable" class="display compact" width="100%">
    <thead>
    <tr>
      <th>Name</th><th>Keterangan</th>
      
      <?php ///x if(in_array('update_contoh', $user_permission) || in_array('delete_contoh', $user_permission)): ?>
        <th>#</th>
      <?php ///x endif; ?>
    </tr>
    </thead>
  </table>
</div>
</div>


<?php //if(in_array('create_contoh', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="add_contohModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah contoh</h4>
      </div>

      <form role="form" action="<?php echo base_url('contoh/create') ?>" method="post" id="create_contohForm">
        <div class="modal-body">
        
          <div class="form-group">
            <label for="post1">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="" autocomplete="off">
          </div>
        
          <div class="form-group">
            <label for="post1">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="" autocomplete="off">
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




<?php // if(in_array('update_contoh', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit_contohModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Contoh</h4>
      </div>

      <form role="form" action="<?php echo base_url('contoh/update') ?>" method="post" id="update_contohForm">
        <div class="modal-body">
          <div id="messages"></div>
          
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="edit_name" name="name" placeholder="" autocomplete="off">
          </div>
          
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <input type="text" class="form-control" id="edit_keterangan" name="keterangan" placeholder="" autocomplete="off">
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
<div class="modal fade" tabindex="-1" role="dialog" id="remove_contohModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove contoh</h4>
      </div>

      <form role="form" action="<?php echo base_url('contoh/remove') ?>" method="post" id="remove_contohForm">
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
  $("#contohNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': 'contoh/fetch_contohData',
    'order': []
  });

  // submit the create from 
  $("#create_contohForm").unbind('submit').on('submit', function() {
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
          $("#add_contohModal").modal('hide');
          // reset the form
          $("#create_contohForm")[0].reset();
          $("#create_contohForm .form-group").removeClass('has-error').removeClass('has-success');

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

function edit_contoh(id)
{ 
  $.ajax({
    url: 'contoh/fetch_contohById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {

      
      $("#edit_name").val(response.name);
      $("#edit_keterangan").val(response.keterangan);

      $("#update_contohForm").unbind('submit').bind('submit', function() {
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

              $("#edit_contohModal").modal('hide');
              // reset the form 
              $("#update_contohForm .form-group").removeClass('has-error').removeClass('has-success');
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

function remove_contoh(id)
{
  if(id) {
    $("#remove_contohForm").on('submit', function() {
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
            $("#remove_contohModal").modal('hide');
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

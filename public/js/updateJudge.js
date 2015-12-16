$('#updateJudge').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var name = button.data('name')
    var web = button.data('web')
    var facebook = button.data('facebook')
    var twitter = button.data('twitter')
    var img = button.data('img')
    var modal = $(this)
	// code to be executed if condition is true
   		modal.find('.modal-title').html('<b class="col-sm-5">Editar Juez  ' + id + '</b><img width=50px height=50px  src="'+img+'">')

    modal.find('.modal-body').html('<input type="text" name="id" value='+id+' hidden> <center><div class="form-group"><label class="col-sm-2 control-label"><strong>Nombre *</strong></label><div class="col-sm-9"><input type="text" name="name" value="'+name+'" class="form-control" required></div> </div><div class="form-group"> <label  class="col-sm-2 control-label"><strong>Url *</strong></label><div class="col-sm-9"><input type="url" name="addressWeb" value='+web+' class="form-control" required></div></div>')
    if( facebook!='')
        modal.find('.modal-body').append('<div class="form-group"><label class="col-sm-2 control-label"><strong>Facebook</strong></label><div class="col-sm-9"><input type="url" name="facebook" value="'+facebook+'" class="form-control"></div> </div>')
    else
        modal.find('.modal-body').append('<div class="form-group"><label class="col-sm-2 control-label"><strong>Facebook</strong></label><div class="col-sm-9"><input type="url" name="facebook" placeholder="Facebook" class="form-control"></div> </div>')
    if( twitter!='')
        modal.find('.modal-body').append(' <div class="form-group"><label class="col-sm-2 control-label"><strong>Twitter</strong></label><div class="col-sm-9"><input type="url" name="twitter" value="'+twitter+'" class="form-control"></div></div>')
    else
        modal.find('.modal-body').append(' <div class="form-group"><label class="col-sm-2 control-label"><strong>Twitter</strong></label><div class="col-sm-9"><input type="url" name="twitter" placeholder="Twitter" class="form-control"></div></div>')
    modal.find('.modal-body').append('<div class="form-group"><label for="images" class="col-sm-2 control-label"><strong>Cambiar Imágen</strong></label><div class="col-sm-6"><input type="file"  name="images" class="btn btn-warning" id="images" multiple></div></div></center>')
})
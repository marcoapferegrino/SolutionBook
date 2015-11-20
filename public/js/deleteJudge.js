$('#eliminar').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('whatever') // Extract info from data-* attributes
    var name = button.data('name')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('Eliminar Juez ' + name)
    modal.find('.modal-footer').html('<a  class="btn btn-warning" href="/deleteJudge/'+id+'" role="button" >Aceptar</a>   <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>')

})
    <!-- Modal -->
    <div class="modal fade" id="imgExpand" tabindex="-1" role="dialog" aria-labelledby="imgExpand">
        @if($tam=='largo')
        <div class="modal-dialog" style="width: 75%" role="document">
        @elseif($tam=='ancho')

        <div class="modal-dialog" style="height: 100%" role="document">

                @endif
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               </div>
                <div class="modal-body " align="middle">
                    <img class="img-responsive" style="border-radius: 15px"  src = "{{url($notice[0]->path)}}" >

                </div>
            </div>
        </div>
        </div> </div>
$(document).ready(function(){
    var notification = new Alert('#notifications');

    function LikeForm(form,button,buttonRevert)
    {
        var solution = button.closest('.solution');
        var idSolution = solution.data('id');
        var action = form.attr('action').replace(':id',idSolution);
        var likesCount = solution.find('.numLikes');

        buttonRevert = solution.find(buttonRevert);

        button.addClass('hidden');

        this.getLikes = function (){
            return parseInt(likesCount.text().split(' ')[0]);
        };
        this.updateCount = function(likes){
            likesCount.text(likes == 1 ? '1 like' : likes + ' likes');
        };

        this.submit = function (success) {
            $.post(action,form.serialize(),function(response){
                buttonRevert.removeClass('hidden');
                success(response);

            }).fail(function(){
                button.removeClass('hidden');
                notification.error('Ocurrio un error :(');
            });
        }


    }

    $('.btn-like').click(function(e){
        e.preventDefault();
        var voteForm = new LikeForm($('#form-like'),$(this),'.btn-unlike');

        voteForm.submit(function(response){
            //console.log("response function like:"+response);
            if(response.success){
                notification.success('¡Gracias por tu like!');
                voteForm.updateCount(voteForm.getLikes()+1);
            }
            else{
                notification.warning('¡Ya habías votado :D!');
            }

        });

    });
    $('.btn-unlike').click(function(e){
        e.preventDefault();
        var voteForm = new LikeForm($('#form-unlike'),$(this),'.btn-like');

        voteForm.submit(function(response){
            console.log("response function unlike:"+response);
            if(response.success){
                notification.success('Ya no te gusta :(');
                voteForm.updateCount(voteForm.getLikes()-1);
            }
            else{
                notification.warning('¡Ya habías votado :D!');
            }
        });

    });


});
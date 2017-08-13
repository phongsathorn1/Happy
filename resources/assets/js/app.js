$(window).ready(function(){
    $("#search").keyup(function(){
        var keyword = this.value;
        if(keyword.length === 0){
            $('#search-result').hide();
        }else{
            $('#search-result').show();
            $('#search-result').html('');
            $.ajax({
                url: app_url + '/api/search/' + keyword
            }).done(function(data){
                $.each(data, function(index, result){
                    $('#search-result').append(`
                        <li>
                            <a href="${app_url}/user/${result.username}">
                                <span class="search-name">${result.name}</span>
                                <span class="search-username">@${result.username}</span>
                            </a>
                        </li>`);
                });
                if(data.length === 0){
                    $('#search-result').append('<li class="search-no-item">No results.</li>');
                }
            }).fail(function(){
                $('#search-result').append('<li class="search-no-item">No results.</li>');
            });
        }
    });

    $('.delete-menu').click(function(){
        return confirm("Are you sure you want to delete this post?\nYou cannot undo this action.");
    });

    $('.post-form').submit(function(e){
        e.preventDefault();
        var post_form = $(this);
        if(post_form.find(".like-button > .fa").hasClass("fa-heart-o"))
        {
            like_button(post_form);
            var post_action = post_form.attr('action');
            post_form.find(".like-button > .fa").addClass("fa-heart").removeClass("fa-heart-o");
            post_form.find(".like-button > .like-count").html(parseInt(post_form.find(".like-button > .like-count").text()) + 1);
            post_form.attr('action', post_action.replace('like', 'unlike'));
        }else{
            like_button(post_form);
            var post_action = post_form.attr('action');
            post_form.find(".like-button > .fa").addClass("fa-heart-o").removeClass("fa-heart");
            post_form.find(".like-button > .like-count").html(parseInt(post_form.find(".like-button > .like-count").text()) - 1);            
            post_form.attr('action', post_action.replace('unlike', 'like'));
        }
    });
});

function like_button(post_form)
{
    $.ajax({
        type: post_form.attr('method'),
        url: post_form.attr('action'),
        data: post_form.serialize(),
    }).fail(function(){
        return alert("An error occurred, please refresh the page.");
    });
}
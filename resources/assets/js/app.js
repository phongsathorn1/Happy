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
});
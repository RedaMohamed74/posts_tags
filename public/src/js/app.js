var postId = 0;
var postBodyElement = null;

$('.post').find('.interaction').find('.edit').on('click', function (event) {
    event.preventDefault();

    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});

$('#modal-save').on('click', function () {
    $.ajax({
        method: 'POST',
        url: urlEdit,
        data: {body: $('#post-body').val(), postId: postId, _token: token}
    })
        .done(function (msg) {
            $(postBodyElement).text(msg['new_body']);
            $('#edit-modal').modal('hide');
        });
});

$('.Tag').on('click', function(event) { 
    event.preventDefault();
    postId = event.target.parentNode.parentNode.dataset['postid'];
    var isTag = event.target.previousElementSibling == null;
    $.ajax({
        method: 'POST',
        url: urlTag,
        data: {isTag: isTag, postId: postId, _token: token}
    })
        .done(function() {
            event.target.innerText = isTag ? event.target.innerText == 'Tag' ? 'You Tag this post' : 'Tag' : event.target.innerText == 'DisTag' ? 'You don\'t Tag this post' : 'DisTag';
            if (isTag) {
                
            } else {
                event.target.previousElementSibling.innerText = 'Tag';
            }
        });
});
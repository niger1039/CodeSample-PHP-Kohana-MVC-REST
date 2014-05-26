function load_posts()
{
  $.ajax('/api/posts', {
    success: function(response)
    {
      if (response.status === 'success')
      {
        show_posts(response.posts);
      }
    }
  });
}

function show_posts(posts)
{
  for (var key in posts)
  {
    var data = posts[key];

    var li = get_post_li(data);

    var comments_ul = li.find('> .comments ul');
    for (var key2 in data.comments)
    {
      comments_ul.append(get_comment_li(data.comments[key2]));
    }

    $('#posts > ul').append(li);
  }

  bind_post_form();

  bind_comment_form($('#posts .add-comment'));
}

function get_post_li(data, hidden)
{
  var li = $('<li>')
      .data('post-id', data.post.id)
      .loadTemplate($('#template-post-li'), {
        title: data.post.title,
        text: data.post.text,
        post_id: data.post.id,
        username: data.post.user.username,
        tags: data.tags.length ? 'Tags: '+data.tags.join(',') : ''
      });

  if (hidden === false)
  {
    li.hide();
  }

  return li;
}

function get_comment_li(comment, hidden)
{
  var li = $('<li>')
      .loadTemplate($('#template-comment-li'), {
        username: comment.user.username,
        text: comment.text
      });

  if (hidden === false)
  {
    li.hide();
  }

  return li;
}

function bind_post_form()
{
  $('#add-post').submit(function(e)
  {
    if (!token) {
      alert('please sign in/sign up to add a post');
      return false;
    }

    var submit_btn = $(this).find('input[type=submit]');
    submit_btn
        .attr('disabled', 'disabled')
        .val('Posting...');

    var form = this;

    var data = $(this).serializeArray();
    data.push({name: 'token', value: token});

    $.ajax('/api/posts', {
      type: 'POST',
      data: data,
      success: function(response)
      {
        if (response.status === 'error')
        {
          display_form_errors(form, response.errors);
        }
        else
        {
          $('#posts > ul')
              .prepend(get_post_li(response, true));

          var li = $('#posts > ul')
              .children()
              .first()
              .fadeIn('slow');

          bind_comment_form(li.find('.add-comment'));

          $(form).find("input[type=text], textarea").val("");
        }

        submit_btn.val('Add Post')
            .removeAttr('disabled');
      }
    });
    e.preventDefault();
  });
}

function bind_comment_form(forms)
{
  $(forms).submit(function(e)
  {

    if (!token) {
      alert('please sign in/sign up to add a comment');
      return false;
    }

    var submit_btn = $(this).find('input[type=submit]');
    submit_btn
        .attr('disabled', 'disabled')
        .val('Adding comment...');

    var form = this;

    var data = $(this).serializeArray();
    data.push({name: 'token', value: token});

    $.ajax('/api/comments',
        {
          type: 'POST',
          data: data,
          success: function(response)
          {
            if (response.status === 'error')
            {
              display_form_errors(form, response.errors);
            }
            else
            {
              $(form)
                  .siblings('ul')
                  .prepend(get_comment_li(response.comment, true))
                  .children()
                  .first()
                  .fadeIn('slow');

              $(form).find("input[type=text], textarea").val("");
            }
            submit_btn.val('Add Comment')
                .removeAttr('disabled');
          }
        });
    e.preventDefault();
  });
}

function display_form_errors(form, errors)
{
  for (var field in errors)
  {
    var object = $(form).find('*[name=' + field + ']');
    $('<span>')
        .addClass('error-msg')
        .html(errors[field])
        .insertAfter(object);
  }
}

$(document).ready(function() {

  load_posts();

});
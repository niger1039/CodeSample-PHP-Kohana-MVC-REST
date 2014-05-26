var token = null;

function logout(link)
{
  var prev_text = link.html();
  link.html('Loggin you out...');
  
  $.ajax('/api/auth', {
    type: 'DELETE',
    success: function(response) {
      if (response.status === 'success') {
        show_login_form();
        link.html(prev_text);
      }
    }
  });
}

function check_logged_user()
{
  $.ajax('/api/auth', {
    success: function(response) {
      if (response.status === 'success') {
        show_logged_user(response.user);
      }
    }
  });
}

function submit_user_forms(e)
{
  $(this).find('span.error-msg').remove();

  var submit_btn = $(this).find('input[type=submit]');
  
  var prev_msg = submit_btn.val();
  
  submit_btn
      .attr('disabled', 'disabled')
      .val(submit_btn.data('loading-msg'));

  var form = this;

  $.ajax($(this).attr("action"), {
    type: 'POST',
    data: $(this).serializeArray(),
    success: function(response)
    {
      if (response.status === 'error')
      {
        display_form_errors(form, response.errors);
      }
      else
      {
        show_logged_user(response.user);
      }

      submit_btn
          .removeAttr('disabled')
          .val(prev_msg);
    }
  });
  e.preventDefault();
}

function show_logged_user(user)
{
  token = user.token;
  $('#user-logged-in').show()
      .find('> span').html(user.username);
  $('#user-form').hide();
}

function show_login_form()
{
  token = null;
  $('#user-logged-in').hide()
      .find('> span').html('');
  $('#user-form').show();
}

$(document).ready(function() {

  $('#user-form').tabs();
  
  $("#user-form form").submit(submit_user_forms);

  check_logged_user();
});
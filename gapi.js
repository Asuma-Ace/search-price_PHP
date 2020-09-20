function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'test.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
      console.log('Signed in as: ' + xhr.responseText);
  };
  xhr.send('idtoken=' + id_token);
  window.location.href = 'index2.php';
}

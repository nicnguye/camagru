(function() {

    var startbutton = null;
    var checkimg = null;
    var checkfilter = null;

    function startup(){
        startbutton = document.getElementById('startbutton');
        startbutton.style.display = 'none';
        filter = document.getElementById('img-filter');
        hidden_filter = document.getElementById('hidden_filter');
        hidden_data = document.getElementById('hidden_data');
        picture = document.getElementById('picture');

        startbutton.addEventListener('click', function(ev){
            takepicture();
            ev.preventDefault();
          }, false);
    }

    function takepicture() {
        var data = picture.src;
        hidden_data.value = data;
        var fd = new FormData(document.forms["form2"]);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'index.php?page=upload', true);
        xhr.send(fd);
    }

document.getElementById('pic').addEventListener('change', function(ev) {

    var reader = new FileReader();
    reader.onload = function ()
    {
        document.getElementById('picture').src = reader.result;
        checkimg = 1;
    }
    reader.readAsDataURL(event.target.files[0]);
}, false);

document.getElementById('img1').addEventListener('click', function(ev) {
    filter.src = document.getElementById('img1').src;
    hidden_filter.value = filter.src;
    filter.style.marginLeft = (picture.width / 2) - filter.width + 'px';
    filter.style.marginTop = (picture.height / 2) - filter.height + 'px';
    checkfilter = 1;
    if (checkimg == 1 && checkfilter == 1)
    {
        startbutton.style.display = 'block';
    }
  }, false);

  document.getElementById('img2').addEventListener('click', function(ev) {
    filter.src = document.getElementById('img2').src;
    hidden_filter.value = filter.src;
    filter.style.marginLeft = (picture.width / 2) - filter.width + 'px';
    filter.style.marginTop = (picture.height / 2) - filter.height + 'px';
    checkfilter = 1;
    if (checkimg == 1 && checkfilter == 1)
    {
        startbutton.style.display = 'block';
    }
  }, false);

  document.getElementById('img3').addEventListener('click', function(ev) {
    filter.src = document.getElementById('img3').src;
    hidden_filter.value = filter.src;
    filter.style.marginLeft = (picture.width / 2) - filter.width + 'px';
    filter.style.marginTop = (picture.height / 2) - filter.height + 'px';
    checkfilter = 1;
    if (checkimg == 1 && checkfilter == 1)
    {
        startbutton.style.display = 'block';
    }
  }, false);

  document.getElementById('img4').addEventListener('click', function(ev) {
    filter.src = document.getElementById('img4').src;
    hidden_filter.value = filter.src;
    filter.style.marginLeft = (picture.width / 2) - filter.width + 'px';
    filter.style.marginTop = (picture.height / 2) - filter.height + 'px';
    checkfilter = 1;
    if (checkimg == 1 && checkfilter == 1)
    {
        startbutton.style.display = 'block';
    }
  }, false);

    window.addEventListener('load', startup, false);

})();
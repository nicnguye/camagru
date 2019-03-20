(function() {
  var width = 400;
  var height = 300;

  var streaming = false;
  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;

  function startup() {
    video = document.getElementById("video");
    canvas = document.getElementById("canvas");
    photo = document.getElementById("photo");
    startbutton = document.getElementById("startbutton");
    startbutton.style.display = "none";
    hidden_filter = document.getElementById("hidden_filter");
    hidden_data = document.getElementById("hidden_data");
    filter = document.getElementById("img-filter");

    navigator.getMedia =
      navigator.getUserMedia ||
      navigator.webkitGetUserMedia ||
      navigator.mozGetUserMedia ||
      navigator.msGetUserMedia;

    navigator.mediaDevices
      .getUserMedia({ video: true, audio: false })
      .then(function(stream) {
        video.srcObject = stream;
        video.play();
      })
      .catch(function(err) {
        console.log("An error occurred! " + err);
      });

    video.addEventListener(
      "canplay",
      function(ev) {
        if (!streaming) {
          height = video.videoHeight / (video.videoWidth / width);
          video.setAttribute("width", width);
          video.setAttribute("height", height);
          canvas.setAttribute("width", width);
          canvas.setAttribute("height", height);
          streaming = true;
        }
      },
      false
    );

    startbutton.addEventListener(
      "click",
      function(ev) {
        takepicture();
        ev.preventDefault();
      },
      false
    );
  }

  function takepicture() {
    var context = canvas.getContext("2d");
    if (width && height) {
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
      var data = canvas.toDataURL("image/png");
      document.getElementById("hidden_data").value = data;
      var fd = new FormData(document.forms["form1"]);
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "index.php?page=montage", true);
      xhr.send(fd);
    }
  }

  document.getElementById("img1").addEventListener(
    "click",
    function(ev) {
      filter.src = document.getElementById("img1").src;
      hidden_filter.value = filter.src;
      filter.style.marginLeft = video.width / 2 - filter.width + "px";
      filter.style.marginTop = video.height / 2 - filter.height + "px";
      startbutton.style.display = "block";
    },
    false
  );

  document.getElementById("img2").addEventListener(
    "click",
    function(ev) {
      filter.src = document.getElementById("img2").src;
      hidden_filter.value = filter.src;
      filter.style.marginLeft = video.width / 2 - filter.width + "px";
      filter.style.marginTop = video.height / 2 - filter.height + "px";
      startbutton.style.display = "block";
    },
    false
  );

  document.getElementById("img3").addEventListener(
    "click",
    function(ev) {
      filter.src = document.getElementById("img3").src;
      hidden_filter.value = filter.src;
      filter.style.marginLeft = video.width / 2 - filter.width + "px";
      filter.style.marginTop = video.height / 2 - filter.height + "px";
      startbutton.style.display = "block";
    },
    false
  );

  document.getElementById("img4").addEventListener(
    "click",
    function(ev) {
      filter.src = document.getElementById("img4").src;
      hidden_filter.value = filter.src;
      filter.style.marginLeft = video.width / 2 - filter.width + "px";
      filter.style.marginTop = video.height / 2 - filter.height + "px";
      startbutton.style.display = "block";
    },
    false
  );

  window.addEventListener("load", startup, false);
})();

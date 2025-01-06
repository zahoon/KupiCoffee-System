window.addEventListener('scroll', function() {
    var header = document.querySelector('header');
    var scrolled = window.scrollY > 0;
  
    if (scrolled) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
  function showWarning() {
    // Display the warning pop-up
    alert("Please log in first!");
  }
document.getElementById("myForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
  
    // Show the popup
    document.getElementById("popup").style.display = "block";
  });
  
  document.getElementById("closePopup").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default anchor tag behavior
  
    // Hide the popup
    document.getElementById("popup").style.display = "none";
  });
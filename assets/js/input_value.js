
var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        var tabs = document.getElementsByClassName("tab");
        tabs[n].style.display = "block";
        if (n === 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n === (tabs.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        fixStepIndicator(n);
    }

    function nextPrev(n) {
        var tabs = document.getElementsByClassName("tab");
        if (n === 1 && !validateForm()) {
            return false;
        }
        tabs[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= tabs.length) {
            document.getElementById("regForm").submit();
            return false;
        }
        showTab(currentTab);
    }

    function validateForm() {
        var tabs = document.getElementsByClassName("tab");
        var currentTabInputs = tabs[currentTab].getElementsByTagName("input");
        var isValid = true;
        for (var i = 0; i < currentTabInputs.length; i++) {
            if (currentTabInputs[i].value === "") {
                currentTabInputs[i].className += " invalid";
                isValid = false;
            }
        }
        return isValid;
    }

    // function fixStepIndicator(n) {
    //     var steps = document.getElementsByClassName("step");
    //     for (var i = 0; i < steps.length; i++) {
    //         if (i <= n) {
    //             steps[i].className = "step active";
    //         } else {
    //             steps[i].className = "step";
    //         }
    //     }
    // }
    function fixStepIndicator(n) {
      // This function removes the "active" class of all steps...
      var i, x = document.getElementsByClassName("step");
      for (i = 0; i < x.length; i++) {
          x[i].className = x[i].className.replace(" active", "");
      }
      //... and adds the "active" class to the current step:
      x[n].className += " active";
  }

    // Capture values from previous tabs and update "Are you sure?" tab inputs
    function captureValues() {
        var selectedValue = document.querySelector('input[name="q1"]:checked').value;
        var input2 = document.getElementById("my-range-field").value;
        var input3 = document.getElementById("eventplace").value;
        var input4 = document.getElementById("eventguest").value;

        document.getElementById("currentInput1").value = selectedValue;
       document.getElementById("currentInput2").value = input2;
        document.getElementById("currentInput3").value = input3;
        document.getElementById("currentInput4").value = input4;
    }

    // Execute captureValues when the Next button is clicked
    document.getElementById("nextBtn").addEventListener("click", function() {
        captureValues();
    });

    document.getElementById("regForm").addEventListener("submit", function() {
      window.location.href = "service_selection.php";
  });
//DJ script end

//makeup artist
// Capture values from previous tabs and update "Are you sure?" tab inputs
function captureValues2() {
    var selectedValue = document.querySelector('input[name="make1"]:checked').value;
    var input2 = document.getElementById("my-range-field1").value;
    var input3 = document.getElementById("make3").value;
    var input4 = document.getElementById("make4").value;

    document.getElementById("makeInput1").value = selectedValue;
   document.getElementById("makeInput2").value = input2;
    document.getElementById("makeInput3").value = input3;
    document.getElementById("makeInput4").value = input4;
}

// Execute captureValues when the Next button is clicked
document.getElementById("nextBtn1").addEventListener("click", function() {
    captureValues2();
});

document.getElementById("regForm1").addEventListener("submit", function() {
  window.location.href = "service_selection.php";
});

var currentTab = 0;
    showTab1(currentTab);

    function showTab1(n) {
        var tabs = document.getElementsByClassName("tab1");
        tabs[n].style.display = "block";
        if (n === 0) {
            document.getElementById("prevBtn1").style.display = "none";
        } else {
            document.getElementById("prevBtn1").style.display = "inline";
        }
        if (n === (tabs.length - 1)) {
            document.getElementById("nextBtn1").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn1").innerHTML = "Next";
        }
        fixStepIndicator1(n);
    }

    function nextPrev1(n) {
        var tabs = document.getElementsByClassName("tab1");
        if (n === 1 && !validateForm1()) {
            return false;
        }
        tabs[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= tabs.length) {
            document.getElementById("regForm1").submit();
            return false;
        }
        showTab1(currentTab);
    }

    function validateForm1() {
        var tabs = document.getElementsByClassName("tab1");
        var currentTabInputs = tabs[currentTab].getElementsByTagName("input");
        var isValid = true;
        for (var i = 0; i < currentTabInputs.length; i++) {
            if (currentTabInputs[i].value === "") {
                currentTabInputs[i].className += " invalid";
                isValid = false;
            }
        }
        return isValid;
    }
     function fixStepIndicator1(n) {
        var steps = document.getElementsByClassName("step1");
        for (var i = 0; i < steps.length; i++) {
            if (i <= n) {
                steps[i].className = "step1 active";
            } else {
                steps[i].className = "step1";
            }
        }
    }
// chair and table
    

    var currentTab = 0;
    showTab2(currentTab);

    function showTab2(n) {
        var tabs = document.getElementsByClassName("tab2");
        tabs[n].style.display = "block";
        if (n === 0) {
            document.getElementById("prevBtn2").style.display = "none";
        } else {
            document.getElementById("prevBtn2").style.display = "inline";
        }
        if (n === (tabs.length - 1)) {
            document.getElementById("nextBtn2").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn2").innerHTML = "Next";
        }
        fixStepIndicator2(n);
    }

    function nextPrev2(n) {
        var tabs = document.getElementsByClassName("tab2");
        if (n === 1 && !validateForm2()) {
            return false;
        }
        tabs[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= tabs.length) {
            document.getElementById("regForm2").submit();
            return false;
        }
        showTab2(currentTab);
    }

    function validateForm2() {
        var tabs = document.getElementsByClassName("tab2");
        var currentTabInputs = tabs[currentTab].getElementsByTagName("input");
        var isValid = true;
        for (var i = 0; i < currentTabInputs.length; i++) {
            if (currentTabInputs[i].value === "") {
                currentTabInputs[i].className += " invalid";
                isValid = false;
            }
        }
        return isValid;
    }
     function fixStepIndicator2(n) {
        var steps = document.getElementsByClassName("step2");
        for (var i = 0; i < steps.length; i++) {
            if (i <= n) {
                steps[i].className = "step2 active";
            } else {
                steps[i].className = "step2";
            }
        }
    }

    function captureValues3() {
        var selectedValue = document.querySelector('input[name="chair1"]:checked').value;
        var input2 = document.getElementById("my-range-field2").value;
        var input3 = document.getElementById("chair3").value;
        var input4 = document.getElementById("chair4").value;
    
        document.getElementById("chairInput1").value = selectedValue;
       document.getElementById("chairInput2").value = input2;
        document.getElementById("chairInput3").value = input3;
        document.getElementById("chairInput4").value = input4;
    }
    
    // Execute captureValues when the Next button is clicked
    document.getElementById("nextBtn2").addEventListener("click", function() {
        captureValues3();
    });
    
    document.getElementById("regForm2").addEventListener("submit", function() {
      window.location.href = "service_selection.php";
    });

    //event organizer
    var currentTab = 0;
    showTab3(currentTab);

    function showTab3(n) {
        var tabs = document.getElementsByClassName("tab3");
        tabs[n].style.display = "block";
        if (n === 0) {
            document.getElementById("prevBtn3").style.display = "none";
        } else {
            document.getElementById("prevBtn3").style.display = "inline";
        }
        if (n === (tabs.length - 1)) {
            document.getElementById("nextBtn3").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn3").innerHTML = "Next";
        }
        fixStepIndicator3(n);
    }

    function nextPrev3(n) {
        var tabs = document.getElementsByClassName("tab3");
        if (n === 1 && !validateForm3()) {
            return false;
        }
        tabs[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= tabs.length) {
            document.getElementById("regForm3").submit();
            return false;
        }
        showTab3(currentTab);
    }

    function validateForm3() {
        var tabs = document.getElementsByClassName("tab3");
        var currentTabInputs = tabs[currentTab].getElementsByTagName("input");
        var isValid = true;
        for (var i = 0; i < currentTabInputs.length; i++) {
            if (currentTabInputs[i].value === "") {
                currentTabInputs[i].className += " invalid";
                isValid = false;
            }
        }
        return isValid;
    }
     function fixStepIndicator3(n) {
        var steps = document.getElementsByClassName("step3");
        for (var i = 0; i < steps.length; i++) {
            if (i <= n) {
                steps[i].className = "step3 active";
            } else {
                steps[i].className = "step3";
            }
        }
    }

    function captureValues4() {
        var selectedValue = document.querySelector('input[name="event1"]:checked').value;
        var input2 = document.getElementById("my-range-field3").value;
        var input3 = document.getElementById("event3").value;
        var input4 = document.getElementById("event4").value;
    
        document.getElementById("eventInput1").value = selectedValue;
       document.getElementById("eventInput2").value = input2;
        document.getElementById("eventInput3").value = input3;
        document.getElementById("eventInput4").value = input4;
    }
    
    // Execute captureValues when the Next button is clicked
    document.getElementById("nextBtn3").addEventListener("click", function() {
        captureValues4();
    });
    
    document.getElementById("regForm3").addEventListener("submit", function() {
      window.location.href = "service_selection.php";
    });

    //photographer
    var currentTab = 0;
    showTab4(currentTab);

    function showTab4(n) {
        var tabs = document.getElementsByClassName("tab4");
        tabs[n].style.display = "block";
        if (n === 0) {
            document.getElementById("prevBtn4").style.display = "none";
        } else {
            document.getElementById("prevBtn4").style.display = "inline";
        }
        if (n === (tabs.length - 1)) {
            document.getElementById("nextBtn4").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn4").innerHTML = "Next";
        }
        fixStepIndicator4(n);
    }

    function nextPrev4(n) {
        var tabs = document.getElementsByClassName("tab4");
        if (n === 1 && !validateForm4()) {
            return false;
        }
        tabs[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= tabs.length) {
            document.getElementById("regForm4").submit();
            return false;
        }
        showTab4(currentTab);
    }

    function validateForm4() {
        var tabs = document.getElementsByClassName("tab4");
        var currentTabInputs = tabs[currentTab].getElementsByTagName("input");
        var isValid = true;
        for (var i = 0; i < currentTabInputs.length; i++) {
            if (currentTabInputs[i].value === "") {
                currentTabInputs[i].className += " invalid";
                isValid = false;
            }
        }
        return isValid;
    }
     function fixStepIndicator4(n) {
        var steps = document.getElementsByClassName("step4");
        for (var i = 0; i < steps.length; i++) {
            if (i <= n) {
                steps[i].className = "step4 active";
            } else {
                steps[i].className = "step4";
            }
        }
    }

    function captureValues5() {
        var selectedValue = document.querySelector('input[name="photo1"]:checked').value;
        var input2 = document.getElementById("my-range-field4").value;
        var input3 = document.getElementById("photo3").value;
        var input4 = document.getElementById("photo4").value;
    
        document.getElementById("photoInput1").value = selectedValue;
       document.getElementById("photoInput2").value = input2;
        document.getElementById("photoInput3").value = input3;
        document.getElementById("photoInput4").value = input4;
    }
    
    // Execute captureValues when the Next button is clicked
    document.getElementById("nextBtn4").addEventListener("click", function() {
        captureValues5();
    });
    
    document.getElementById("regForm4").addEventListener("submit", function() {
      window.location.href = "service_selection.php";
    });

    //master of ceremony
    var currentTab = 0;
    showTab5(currentTab);

    function showTab5(n) {
        var tabs = document.getElementsByClassName("tab5");
        tabs[n].style.display = "block";
        if (n === 0) {
            document.getElementById("prevBtn5").style.display = "none";
        } else {
            document.getElementById("prevBtn5").style.display = "inline";
        }
        if (n === (tabs.length - 1)) {
            document.getElementById("nextBtn5").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn5").innerHTML = "Next";
        }
        fixStepIndicator5(n);
    }

    function nextPrev5(n) {
        var tabs = document.getElementsByClassName("tab5");
        if (n === 1 && !validateForm5()) {
            return false;
        }
        tabs[currentTab].style.display = "none";
        currentTab += n;
        if (currentTab >= tabs.length) {
            document.getElementById("regForm5").submit();
            return false;
        }
        showTab5(currentTab);
    }

    function validateForm5() {
        var tabs = document.getElementsByClassName("tab5");
        var currentTabInputs = tabs[currentTab].getElementsByTagName("input");
        var isValid = true;
        for (var i = 0; i < currentTabInputs.length; i++) {
            if (currentTabInputs[i].value === "") {
                currentTabInputs[i].className += " invalid";
                isValid = false;
            }
        }
        return isValid;
    }
     function fixStepIndicator5(n) {
        var steps = document.getElementsByClassName("step5");
        for (var i = 0; i < steps.length; i++) {
            if (i <= n) {
                steps[i].className = "step5 active";
            } else {
                steps[i].className = "step5";
            }
        }
    }

    function captureValues6() {
        var selectedValue = document.querySelector('input[name="master1"]:checked').value;
        var input2 = document.getElementById("my-range-field5").value;
        var input3 = document.getElementById("master3").value;
        var input4 = document.getElementById("master4").value;
    
        document.getElementById("masterInput1").value = selectedValue;
       document.getElementById("masterInput2").value = input2;
        document.getElementById("masterInput3").value = input3;
        document.getElementById("masterInput4").value = input4;
    }
    
    // Execute captureValues when the Next button is clicked
    document.getElementById("nextBtn5").addEventListener("click", function() {
        captureValues6();
    });
    
    document.getElementById("regForm5").addEventListener("submit", function() {
      window.location.href = "service_selection.php";
    });

    // flatpickr

    // <script src="<?php echo base_url(); ?>assets\js\flatpickr.js"></script>
    
        flatpickr("#my-range-field3", {
          mode: "range"
        });

        flatpickr("#my-range-field1", {
            mode: "range"
          });
      
          flatpickr("#my-range-field2", {
            mode: "range"
          });

          flatpickr("#my-range-field", {
            mode: "range"
          });
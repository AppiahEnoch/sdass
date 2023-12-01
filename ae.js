var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});

function myAjax1() {
  $.ajax({
    type: "post",
    data: {
      id: id,
    },
    cache: false,
    url: "",
    dataType: "text",
    success: function (data, status) {
      //alert(data);
    },
    error: function (xhr, status, error) {
      // alert(error);
    },
  });
}

function sendFile() {
  var formData = new FormData();
  formData.append("myfile", document.getElementById("myfile").files[0]);

  $.ajax({
    type: "post",
    cache: false,
    url: "updateGESlist.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function (data, status) {
      // handle the success response here
    },
    error: function (xhr, status, error) {
      // handle the error response here
    },
  });
}

function getInput() {
  email = $("#tf_email").val();
  mobile = $("#tf_mobile").val();
  ghanaCard = $("#tf_ghanaCard").val();

  email = trimV(email);
  mobile = trimV(mobile);
  ghanaCard = trimV(ghanaCard);
}

function validateGhanaMobile(number) {
  var pattern = /^0[2-9]\d{8}$/;
  return pattern.test(number);
}

const validateEmail = (email) => {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

function aeEmpty(e) {
  var ee = "";
  try {
    ee = e.trim();
  } catch (error) {
    return true;
  }
  try {
    switch (ee) {
      case "":
      case 0:
      case "0":
      case null:
      case false:
      case undefined:
        return true;
      default:
        return false;
    }
  } catch (error) {
    return true;
  }
}

function isNumber(n) {
  return !isNaN(Number(n)) && isFinite(n);
}
function isNumeric(n) {
  return !isNaN(Number(n)) && isFinite(n);
}

function showErrorText(message) {
  $("#error_message").text(message);
  $("#error_message").show();
}

function hideErrorText() {
  $("#error_message").text("");
  $("#error_message").hide();
}

function showSpin(number) {
  var spinnerID = "#spin" + number;

  if ($(spinnerID).hasClass("d-none")) {
    $(spinnerID).removeClass("d-none");
  }
  $(spinnerID).show();
}

function hideSpin(number) {
  var spinnerID = "#spin" + number;
  if (!$(spinnerID).hasClass("d-none")) {
    $(spinnerID).addClass("d-none");
  }
  $(spinnerID).hide();
}

function hideAllSpin() {
  for (var i = 1; i <= 10; i++) {
    hideSpin(i);
  }
}
function openPage_blank(url) {
  window.open(url, "_blank");
}

function openPage(url) {
  window.location.href = url;
}

function showAEMsuccess(aeBody, aeTitle) {
  if (!aeEmpty(aeTitle)) {
    $("#aeAlertTitle").text(aeTitle);
  }

  if (!aeEmpty(aeBody)) {
    $("#aeAlertBody").text(aeBody);
  }
  $("#aeMsuccess").modal("show");
}

function showAEMsuccessw(aeBody, aeTitle) {
  if (!aeEmpty(aeTitle)) {
    $("#aeAlertTitlew").text(aeTitle);
  }

  if (!aeEmpty(aeBody)) {
    $("#aeAlertBodyw").text(aeBody);
  }
  $("#aeMsuccessw").modal("show");
}

function showAEMerror(aeBody, aeTitle) {
  if (!aeEmpty(aeTitle)) {
    $("#aeMerrorTitle").text(aeTitle);
  }

  if (!aeEmpty(aeBody)) {
    $("#aeMerrorBody").text(aeBody);
  }
  $("#aeMerror").modal("show");
}

function showMYesNo(aeBody) {
  if (!aeEmpty(aeBody)) {
    $("#aeMBody").text(aeBody);
  }
  $("#aeMyesNo").modal("show");
}

function passwordConfirm(a, b) {
  return a == b;
}

function trimV(a) {
  try {
    a = a.trim();
  } catch (error) {}
  return a;
}

function refreshPage() {
  location.reload();
}

function showCodeField() {
  $("#codeHide").show();
}
function hideCodeField() {
  $("#codeHide").hide();
}

function validateGhanaCard(ghanaCard) {
  if (aeEmpty(ghanaCard)) {
    return false;
  }
  ghanaCard = ghanaCard.toUpperCase();
  var i = ghanaCard.length;

  if (i < 8) {
    return false;
  }

  if (i > 20) {
    return false;
  }

  ii = ghanaCard.substring(0, 4);

  if (!passwordConfirm(ii, "GHA-")) {
    return false;
  }

  return true;
}

function openPageReplace(url) {
  location.href = url;
}

function validatePassword(password) {
  var passwordRegex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
  var m =
    "must be at least 8 characters long " +
    " and contains at least one lowercase letter, one " +
    "uppercase letter, one number, and one special character";

  return passwordRegex.test(password);
}

function checkImageFileSize(id) {
  var file = document.getElementById(id).files[0];
  if (file.size > 1258291) {
    showAEMerror("FILE TOO LARGE");

    return false;
  }
  if (!file.type.startsWith("image/")) {
    showAEMerror("CHOOSE IMAGE FILE ONLY");
    return false;
  }
  return true;
}

function changeImageSRC(fileID, imageTagID) {
  var file = document.getElementById(fileID).files[0];
  document.getElementById(imageTagID).src = URL.createObjectURL(file);
}

function trimVariables(variablesArray) {
  for (let i = 0; i < variablesArray.length; i++) {
    variablesArray[i] = variablesArray[i].trim();
  }
  return variablesArray;
}

function updateImageSRC(inputFileId, imgTagId) {
  const inputFile = document.getElementById(inputFileId); // get the input file element by its ID
  const file = inputFile.files[0]; // get the first file in the input
  if (file) {
    const reader = new FileReader(); // create a FileReader object
    reader.onload = function () {
      const imgTag = document.getElementById(imgTagId); // get the img tag by its ID
      imgTag.src = reader.result; // set the src attribute of the img tag to the base64-encoded data URL of the selected file
    };
    reader.readAsDataURL(file); // read the selected file as a data URL
  }
}

function extractNumberFromString(str) {
  const match = str.match(/\d+/); // matches one or more digits
  return match ? parseInt(match[0]) : null; // convert the match to a number
}

function getSelectedText(selectId) {
  // Get a reference to the select element
  const select = document.getElementById(selectId);

  // Get the selected option
  const selectedOption = select.options[select.selectedIndex];

  // Get the selected text
  const selectedText = selectedOption.text;

  // Do something with the selected text
  return selectedText;
}

function aeDownload(filePath) {
  if (aeEmpty(filePath)) {
    return "#";
  }

  const fileName = filePath.split("/").pop();

  // Create a new anchor element with the file path as the href attribute
  const link = document.createElement("a");
  link.href = filePath;

  // Set the download attribute to force download and specify the file name
  link.download = fileName;

  // Simulate a click on the anchor element
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

function showToast(toastID, title, message, positionInPercentage) {
  console.log(
    "Function called: ",
    toastID,
    title,
    message,
    positionInPercentage
  );

  var toastElement = document.getElementById(toastID);

  if (!toastElement) {
    console.error("No element found with ID: ", toastID);
    return;
  }

  if (title != null) {
    toastElement
      .getElementsByClassName("toast-header")[0]
      .getElementsByTagName("strong")[0].innerText = title;
  }

  if (message != null) {
    toastElement.getElementsByClassName("toast-body")[0].innerText = message;
  }

  toastElement.style.position = "fixed";

  if (positionInPercentage != null) {
    toastElement.style.top = positionInPercentage + "%";
  }

  toastElement.style.left = "50%";
  toastElement.style.transform = "translate(-50%, -50%)";
  toastElement.style.zIndex = "99999";

  var toast = new bootstrap.Toast(toastElement);
  toast.show();
}

function showToastYN(toastID, title, message, positionInPercentage) {
  var toast = document.getElementById(toastID);

  // Change title of the toast
  if (title != null) {
    toast
      .getElementsByClassName("toast-header")[0]
      .getElementsByTagName("strong")[0].innerText = title;
  }

  // Change message of the toast
  if (message != null) {
    toast.querySelector("#toastMessage").innerText = message;
  }

  toast.style.position = "fixed";

  if (positionInPercentage != null) {
    toast.style.top = positionInPercentage + "%";
  }
  toast.style.left = "50%";
  toast.style.transform = "translate(-50%, -50%)";
  toast.style.zIndex = "99999";

  var bsToast = new bootstrap.Toast(toast);
  bsToast.show();
}

function closeToast(toastID) {
  var toastElement = document.getElementById(toastID);
  var bsToast = new bootstrap.Toast(toastElement);
  bsToast.hide();
}

function getOTP() {
  let otp = "";
  for (let i = 0; i < 6; i++) {
    otp += Math.floor(Math.random() * 10); // Generate a random number between 0 and 9
  }
  return otp;
}

function isFileImage2(fileId) {
  var input = document.getElementById(fileId);
  if (input.files && input.files[0]) {
    var file = input.files[0];
    var size = file.size / 1024 / 1024; // size in MB
    var type = file.type;
    if (!type.startsWith("image")) {
      // Using the hard-coded toastID "aeToastE"
      showToast(
        "aeToastE",
        "ONLY IMAGE FILE ALLOWED",
        "Please Choose Image File",
        20
      );
      document.getElementById(fileId).value = "";
      return false;
    } else if (size > 100) {
      // Using the hard-coded toastID "aeToastE"
      showToast(
        "aeToastE",
        "FILE TOO LARGE",
        "Your file is too large must be less than 1MB",
        20
      );
      document.getElementById(fileId).value = "";
      return false;
    } else {
      return true;
    }
  }
}

function isFileExcel(fileId) {
  var input = document.getElementById(fileId);
  if (input.files && input.files[0]) {
    var file = input.files[0];
    var size = file.size / 1024 / 1024; // size in MB
    var type = file.type;
    if (
      type !==
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" &&
      type !== "application/vnd.ms-excel"
    ) {
      // Using the hard-coded toastID "aeToastE"
      showToast(
        "aeToastE",
        "ONLY EXCEL FILE ALLOWED",
        "Please Choose Excel File",
        20
      );
      document.getElementById(fileId).value = "";
      return false;
    } else if (size > 1000) {
      // Using the hard-coded toastID "aeToastE"
      showToast("aeToastE", "FILE TOO LARGE", "Your file is too large", 20);
      document.getElementById(fileId).value = "";
      return false;
    } else {
      return true;
    }
  }
}

function showWrapper4(idsToShow, prefix, count) {
  idsToShow = idsToShow.map((id) => (id.startsWith("#") ? id : "#" + id));

  // generate ids
  const ids = Array.from({ length: count }, (_, i) => `#${prefix}${i + 1}`);

  ids.forEach(function (id) {
    if (idsToShow.includes(id)) {
      // Show the element if it's not already visible
      if ($(id).hasClass("d-none")) {
        $(id).removeClass("d-none");
      }
    } else {
      // Hide the element if it's not in the idsToShow list
      $(id).addClass("d-none");
    }
  });
}

function showWrapper5(idsToShow, prefix, count) {
  // toggleWrappers(['wrapper2', 'wrapper3'], 'wrapper', 4);

  idsToShow = idsToShow.map((id) => (id.startsWith("#") ? id : "#" + id));

  // generate ids
  const ids = Array.from({ length: count }, (_, i) => `#${prefix}${i + 1}`);

  ids.forEach(function (id) {
    if (idsToShow.includes(id)) {
      try {
        if ($(id).hasClass("d-none")) {
          // If it is hidden, show it
          $(id).removeClass("d-none");
        } else {
          // If it is visible, hide it
          $(id).addClass("d-none");
        }
      } catch (error) {
        console.error(`Error toggling ${id}: ${error}`);
      }
    } else {
      // Hide the rest
      try {
        $(id).addClass("d-none");
      } catch (error) {
        console.error(`Error hiding ${id}: ${error}`);
      }
    }
  });
}

function updateImageView(imageId, imageUrl) {
  if (aeEmpty(imageUrl)) {
    return;
  }
  document.getElementById(imageId).src = imageUrl;
}

function isFilePDF2(fileId) {
  var input = document.getElementById(fileId);
  if (input.files && input.files[0]) {
    var file = input.files[0];
    var size = file.size / 1024 / 1024; // size in MB
    var type = file.type;
    if (
      type !== "application/pdf" &&
      type !==
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    ) {
      showToast(
        "aeToastE",
        "ONLY PDF OR DOCX FILE ALLOWED",
        "Please Choose PDF or DOCX File",
        20
      );
      document.getElementById(fileId).value = "";
      return false;
    } else if (size > 3) {
      showToast("aeToastE", "FILE TOO LARGE", "Your file is too large", 20);
      document.getElementById(fileId).value = "";
      return false;
    } else {
      return true;
    }
  }
}

function aeModal(modalId) {
  var modalElement = document.getElementById(modalId);
  var modalInstance = new bootstrap.Modal(modalElement, {
    keyboard: false,
  });

  if (modalInstance._isShown) {
    modalInstance.hide();
  } else {
    modalInstance.show();
  }
}


function aeModal2(id) {
  if ($('#' + id).hasClass('show')) {
    $('#' + id).modal('hide');
  } else {
    $('#' + id).modal('show');
  }
}


function aeLoading() {
  var spinner = $("#spinner-container");
  if (spinner.hasClass("d-none")) {
    spinner.removeClass("d-none");
  } else {
    spinner.addClass("d-none");
  }
}

function deleteAll(tableName, successMessage) {
  aeLoading();
  $.ajax({
    type: "post",
    data: {
      table: tableName,
    },
    cache: false,
    url: "../deleteAll.php",
    dataType: "text",
    success: function (data, status) {
      // alert("sss:"+data)
      if (data == 1) {
        showToast("aeToastS", "SUCCESS!", successMessage, "20");
      }
      aeLoading();
    },
    error: function (xhr, status, error) {
      alert("Error:" + error);
    },
  });
}

function showToastR(
  toastID,
  title = null,
  message = null,
  positionInPercentage = 50
) {
  var toast = document.getElementById(toastID);

  if (!toast) {
    console.error("Toast with given ID does not exist.");
    return;
  }

  // Change title of the toast
  if (title) {
    toast.querySelector(".toast-header strong").innerText = title;
  }

  // Change message of the toast
  if (message) {
    toast.querySelector("#toastMessage").innerText = message;
  }

  var bsToast = new bootstrap.Toast(toast);

  var okButton = toast.querySelector(".btn-primary");

  // Remove previous event listeners
  okButton.replaceWith(okButton.cloneNode(true));
  okButton = toast.querySelector(".btn-primary"); // reselect the button

  // Attach the new event
  okButton.addEventListener("click", function () {
    location.reload(); // Reload the page when clicked
  });

  toast.style.position = "fixed";
  toast.style.top = positionInPercentage + "%";
  toast.style.left = "50%";
  toast.style.transform = "translate(-50%, -50%)";
  toast.style.zIndex = "99999";

  bsToast.show();
}

function showToastY(
  toastID,
  title = null,
  message = null,
  positionInPercentage = 50,
  yesCallback = null,
  noCallback = null
) {
  // CALL
  //   showToastY(
  //     "aeToastY",
  //     "Confirm Delete All.",
  //     "Are you sure you want to delete all intern registration codes?",
  //     "20",
  //     functionForYesOption, functionForNOption
  // );

  var toast = document.getElementById(toastID);

  if (!toast) {
    console.error("Toast with given ID does not exist.");
    return;
  }

  // Change title of the toast
  if (title) {
    toast.querySelector(".toast-header strong").innerText = title;
  }

  // Change message of the toast
  if (message) {
    toast.querySelector("#toastMessage").innerText = message;
  }

  var bsToast = new bootstrap.Toast(toast);

  if (yesCallback && typeof yesCallback === "function") {
    var yesButton = toast.querySelector(".btn-success");

    // Remove previous event listeners
    yesButton.replaceWith(yesButton.cloneNode(true));
    yesButton = toast.querySelector(".btn-success"); // reselect the button

    // Attach the new event
    yesButton.addEventListener("click", function () {
      yesCallback();
      bsToast.hide(); // Hide the toast after executing the callback
    });
  }

  // Handling No button
  var noButton = toast.querySelector(".btn-danger");
  // Remove previous event listeners
  noButton.replaceWith(noButton.cloneNode(true));
  noButton = toast.querySelector(".btn-danger"); // reselect the button

  // Attach the new event
  noButton.addEventListener("click", function () {
    if (noCallback && typeof noCallback === "function") {
      noCallback();
    }
    bsToast.hide(); // Hide the toast whether there's a noCallback or not
  });

  toast.style.position = "fixed";
  toast.style.top = positionInPercentage + "%";
  toast.style.left = "50%";
  toast.style.transform = "translate(-50%, -50%)";
  toast.style.zIndex = "99999";

  bsToast.show();
}

function showToastP(
  toastID,
  title = null,
  message = null,
  positionInPercentage = 50,
  okCallback = null
) {
  var toast = document.getElementById(toastID);

  if (!toast) {
    console.error("Toast with given ID does not exist.");
    return;
  }

  // Change title of the toast
  if (title) {
    toast.querySelector(".toast-header strong").innerText = title;
  }

  // Change message of the toast
  if (message) {
    toast.querySelector("#toastMessage").innerText = message;
  }

  var bsToast = new bootstrap.Toast(toast, {
    autohide: false, // Disable autohide
  });

  // Event listener for the OK button
  var okButton = toast.querySelector(".btn-success");
  okButton.addEventListener("click", function () {
    if (okCallback && typeof okCallback === "function") {
      okCallback(); // Execute the callback function if provided
    }
    bsToast.hide(); // Hide the toast after executing the callback
  });

  // Style the toast
  toast.style.position = "fixed";
  toast.style.top = positionInPercentage + "%";
  toast.style.left = "50%";
  toast.style.transform = "translate(-50%, -50%)";
  toast.style.zIndex = "99999";

  // Show the toast
  bsToast.show();
}

function aeModal2(modalId) {
  // Close all modals
  var allModals = document.querySelectorAll(".modal");
  allModals.forEach((modalElement) => {
    var instance = bootstrap.Modal.getInstance(modalElement);
    if (instance && instance._isShown) {
      instance.hide();
    }
  });

  // Open the intended modal
  var targetModalElement = document.getElementById(modalId);
  var targetModalInstance = new bootstrap.Modal(targetModalElement, {
    keyboard: false,
  });
  targetModalInstance.show();
}

function hideModal() {
  $(".modal").modal("hide");
}

function ae_fill_form(formId) {
  // call example
  // ae_fill_form('formId');

  $(`#${formId}`)
    .find(":input")
    .each(function () {
      let $input = $(this);
      switch ($input.attr("type")) {
        case "text":
          $input.val("Dummy Text");
          break;
        case "email":
          $input.val("dummy@example.com");
          break;
        case "password":
          $input.val("dummyPassword123");
          break;
        case "number":
          $input.val("123");
          break;
        case "date":
          $input.val("2023-10-18");
          break;
        case "tel":
          $input.val("123-456-7890");
          break;
        case "checkbox":
          $input.prop("checked", true);
          break;
        case "radio":
          $input.prop("checked", true);
          break;
        case "textarea":
          $input.val("Dummy Text Area Content");
          break;
        default:
          console.log("Unhandled input type:", $input.attr("type"));
      }
    });
  $(`#${formId}`)
    .find("select")
    .each(function () {
      let $select = $(this);
      let options = $select.find("option");
      if (options.length >= 2) {
        options.eq(1).prop("selected", true);
      } else if (options.length > 0) {
        options.eq(0).prop("selected", true);
      }
    });
}

$(document).ready(function () {
  $(".ae-reset").on("click", function () {
    $(this).closest("form")[0].reset();
  });
});

function ae_download(scriptName, id = "") {
  $.ajax({
    type: "post",
    data: { id: id },
    cache: false,
    url: scriptName,
    dataType: "text",
    success: function (data, status) {
      aeDownload(data);
      showToast(
        "aeToastS",
        "Download Status",
        "File downloaded successfully",
        "20"
      );
    },
    error: function (xhr, status, error) {
      showToast("aeToastE", "Download Error", "Error downloading file", "20");
    },
  });
}

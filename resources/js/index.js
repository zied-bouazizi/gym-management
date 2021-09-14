/* global feather:false */

(function () {
  feather.replace({ 'aria-hidden': 'true' });
})();

// Update renewal modal according to member
let renewModal = document.getElementById('renewModal');
renewModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  let button = event.relatedTarget;
  // Extract info from data-bs-* attributes
  let id = button.getAttribute('data-bs-id');
  let firstName = button.getAttribute('data-bs-first-name');
  let lastName = button.getAttribute('data-bs-last-name');
  let membershipExpiry = button.getAttribute('data-bs-membership-expiry');
  // Update the modal's content
  let modalTitle = renewModal.querySelector('.modal-title');
  let modalBodyInput = renewModal.querySelector('.modal-body input');
  let modalFooterInput = renewModal.querySelector('.modal-footer input');

  modalTitle.innerHTML = 'Renewal <span class="fw-bold">' + firstName + ' ' + lastName + '</span> Membership';
  modalBodyInput.value = membershipExpiry;
  modalFooterInput.value = id;
});

// Update edit modal according to member
let editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  let button = event.relatedTarget;
  // Extract info from data-bs-* attributes
  let id = button.getAttribute('data-bs-id');
  let firstName = button.getAttribute('data-bs-first-name');
  let lastName = button.getAttribute('data-bs-last-name');
  let phone = button.getAttribute('data-bs-phone');
  let createDate = button.getAttribute('data-bs-create-date');
  // Update the modal's content
  let modalTitle = editModal.querySelector('.modal-title');
  let modalBodyFirstNameInput = editModal.querySelector('.modal-body input[name="first_name"]');
  let modalBodyLastNameInput = editModal.querySelector('.modal-body input[name="last_name"]');
  let modalBodyPhoneInput = editModal.querySelector('.modal-body input[name="phone"]');
  let modalBodyDateInput = editModal.querySelector('.modal-body input[name="create_date"]');
  let modalFooterInput = editModal.querySelector('.modal-footer input');

  modalTitle.innerHTML = 'Update <span class="fw-bold">' + firstName + ' ' + lastName;
  modalBodyFirstNameInput.value = firstName;
  modalBodyLastNameInput.value = lastName;
  modalBodyPhoneInput.value = phone;
  modalBodyDateInput.value = createDate;
  modalFooterInput.value = id;
});

// Update delete modal according to member
let deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  let button = event.relatedTarget;
  // Extract info from data-bs-* attributes
  let id = button.getAttribute('data-bs-id');
  let firstName = button.getAttribute('data-bs-first-name');
  let lastName = button.getAttribute('data-bs-last-name');
  // Update the modal's content
  let modalTitle = deleteModal.querySelector('.modal-title');
  let modalBody = deleteModal.querySelector('.modal-body');
  let modalFooterInput = deleteModal.querySelector('.modal-footer input');

  modalTitle.textContent = firstName + ' ' + lastName;
  modalBody.innerHTML = 'Are you sure to delete <span class="fw-bold">' + firstName + ' ' + lastName + '</span> member?';
  modalFooterInput.value = id;
});
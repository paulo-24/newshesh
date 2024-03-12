document.getElementById('addButton').addEventListener('click',
function(){
    document.querySelector('.bg-modal').style.display = 'flex'
});
document.querySelector('.close').addEventListener('click',function(){
    document.querySelector('.bg-modal').style.display = 'none';
});

  // JavaScript to capture the employee ID and populate the form
  const editButtons = document.querySelectorAll('.edit-btn');
  const editForm = document.getElementById('editForm');
  const editEmployeeIdInput = document.getElementById('editEmployeeId');

  editButtons.forEach(button => {
      button.addEventListener('click', function() {
          const employeeId = this.dataset.id;
          editEmployeeIdInput.value = employeeId;
          // Show the modal
          document.getElementById('modal').style.display = 'block';
      });
  });
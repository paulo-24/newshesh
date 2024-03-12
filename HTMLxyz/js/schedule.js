const editableTable = document.getElementById('editableEmployeeTable');
const nonEditableTable = document.getElementById('nonEditableEmployeeTable');

// Load data from localStorage on page load
window.addEventListener('load', function () {
    loadTableData();
    updateMonthTime();
});

// Add event listener to the save button
document.getElementById('saveButton').addEventListener('click', function () {
    saveTableData();
});

// Function to save data from editable table to localStorage
function saveTableData() {
    const data = [];
    const rows = editableTable.rows;

    for (let i = 0; i < rows.length; i++) {
        const rowData = [];
        const cells = rows[i].cells;

        for (let j = 0; j < cells.length; j++) {
            rowData.push(cells[j].textContent);
        }
        data.push(rowData);
    }
    localStorage.setItem('editableTableData', JSON.stringify(data));
}

// Function to load data from localStorage to non-editable table
function loadTableData() {
    const data = localStorage.getItem('editableTableData');

    if (data) {
        const parsedData = JSON.parse(data);
        const rows = nonEditableTable.rows;

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].cells;

            for (let j = 0; j < cells.length; j++) {
                cells[j].textContent = parsedData[i][j];
            }
        }
    }
}




 // Function to update month, date, and time in real-time
 function updateDateTime() {
    const now = new Date();
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const month = months[now.getMonth()];
    const date = now.getDate();
    const year = now.getFullYear();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();

    const formattedDateTime = `${month} ${date}, ${year} ${hours}:${minutes}:${seconds}`;

    document.getElementById('editableMonthTime').textContent = formattedDateTime;
}

// Update time every second
setInterval(updateDateTime, 1000);

// Initial call to update the time when the page loads
updateDateTime();



  
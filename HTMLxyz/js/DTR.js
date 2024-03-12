function openPrintWindow() {
    // Clone the print container element
    var printContent = document.getElementById("print-container").cloneNode(true);
    
    // Write the print content and styles into the current window
    document.write('<html><head><title>BIGBREW DTR</title>');
    document.write('<link rel="stylesheet" type="text/css" href="css/DailyTimeRecord.css">'); // Link your CSS file here
    document.write('</head><body>');
    document.write(printContent.innerHTML);
    document.write('</body></html>');
    
    // Close the document
    document.close();
    
    // Trigger the print dialog
    window.print();
}

var customers = new Array();
customers.push(["Date", "Account", "Ref", "Transcation", "Balance"]);
customers.push(["19-10-2020", "Chequing", "c0003","+10.00", "10.00"]);
customers.push(["17-10-2020", "Chequing", "c0002","-10.00", "0.00"]);
customers.push(["15-10-2020", "Savings", "s0001","+5.00", "5.00"]);
customers.push(["11-10-2020", "Chequing", "c0001","-5.00", "10.00"]);

//Create a HTML Table element.
var table = document.createElement("TABLE");
table.border = "1";

//Get the count of columns.
var columnCount = customers[0].length;

//Add the header row.
var row = table.insertRow(-1);
for (var i = 0; i < columnCount; i++) {
    var headerCell = document.createElement("TH");
    headerCell.innerHTML = customers[0][i];
    row.appendChild(headerCell);
}

//Add the data rows.
for (var i = 1; i < customers.length; i++) {
    row = table.insertRow(-1);
    for (var j = 0; j < columnCount; j++) {
        var cell = row.insertCell(-1);
        cell.innerHTML = customers[i][j];
    }
}

var dvTable = document.getElementById("transaction-table");
dvTable.innerHTML = "";
dvTable.appendChild(table);
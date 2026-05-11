const xlsx = require('xlsx');
const file = 'C:\\Users\\pc\\Downloads\\mprinthouse_products.xlsx';
const wb = xlsx.readFile(file);
const ws = wb.Sheets[wb.SheetNames[0]];
const data = xlsx.utils.sheet_to_json(ws, { header: 1 });
console.log("Headers:", data[0]);
console.log("Row 1:", data[1]);

const xlsx = require('xlsx');

const file = 'C:\\Users\\pc\\Downloads\\eprint_ae_product_catalogue_v8.xlsx';
const wb = xlsx.readFile(file);
const ws = wb.Sheets[wb.SheetNames[0]]; // usually the first sheet
const data = xlsx.utils.sheet_to_json(ws, { header: 1 });

console.log("Headers from Sheet 1:", data[0]);
console.log("Row 1:", data[1]);

if (wb.SheetNames.length > 1) {
    const ws2 = wb.Sheets[wb.SheetNames[1]];
    const data2 = xlsx.utils.sheet_to_json(ws2, { header: 1 });
    console.log("Headers from Sheet 2:", data2[0]);
    console.log("Row 1:", data2[1]);
}

const xlsx = require('xlsx');

const compFile = 'C:\\Users\\pc\\Downloads\\product-name-comparison-review.xlsx';
const wb = xlsx.readFile(compFile);
const ws = wb.Sheets['Name Comparison'];
const compData = xlsx.utils.sheet_to_json(ws, { defval: '' });

const keeps = new Set();
const deletes = [];

let lastKeepSku = null;
let lastDeleteParentSku = null;

compData.forEach(row => {
    let dec = String(row['Decision'] || '').toUpperCase().trim();
    if (dec === 'IGNORE') return;
    
    const sku = String(row['SKU']).trim();
    let parentSku = String(row['Parent SKU']).trim();

    if (dec === 'KEEP' || dec === '') {
        keeps.add(sku);
        lastKeepSku = sku;
        lastDeleteParentSku = null;
    } else if (dec === 'DELETE') {
        if (!parentSku) {
            parentSku = lastDeleteParentSku || lastKeepSku;
        }
        lastDeleteParentSku = parentSku;
        
        deletes.push({ sku, parentSku, name: row['Product Name'] });
    }
});

let orphans = 0;
deletes.forEach(d => {
    if (!keeps.has(d.parentSku)) {
        orphans++;
        console.log(`Orphaned Delete Row: SKU=${d.sku}, Parent=${d.parentSku}, Name=${d.name}`);
    }
});

console.log(`Total Keeps: ${keeps.size}`);
console.log(`Total Deletes: ${deletes.length}`);
console.log(`Total Orphans: ${orphans}`);

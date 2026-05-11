const xlsx = require('xlsx');
const fs = require('fs');

const compFile = 'C:\\Users\\pc\\Downloads\\product-name-comparison-review.xlsx';
const dbStateFile = 'C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\db_state.json';
const sqlOutFile = 'C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\catalog_fix.sql';

const dbState = JSON.parse(fs.readFileSync(dbStateFile, 'utf8'));

const compWb = xlsx.readFile(compFile);
const compWs = compWb.Sheets['Name Comparison'];
const compData = xlsx.utils.sheet_to_json(compWs, { defval: '' });

const keeps = new Set();
const rawDeletes = [];
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
        rawDeletes.push({ sku, parentSku });
    }
});

const deleteMap = {};
rawDeletes.forEach(d => { deleteMap[d.sku] = d.parentSku; });

function findUltimateParent(sku) {
    let current = sku;
    let visited = new Set();
    while (current && !keeps.has(current)) {
        if (visited.has(current)) break;
        visited.add(current);
        current = deleteMap[current];
    }
    return current;
}

const sqlStatements = [];
sqlStatements.push("BEGIN;");

// 1. Process KEEPs
let keepUpdates = 0;
keeps.forEach(sku => {
    const dbInfo = dbState[sku];
    if (dbInfo) {
        // Keeps should be 'product' and parent 0
        sqlStatements.push(`UPDATE wp_posts SET post_type = 'product', post_parent = 0 WHERE ID = ${dbInfo.id};`);
        keepUpdates++;
    }
});

// 2. Process DELETEs (Variations)
let deleteUpdates = 0;
rawDeletes.forEach(d => {
    const dbInfo = dbState[d.sku];
    if (dbInfo) {
        const ultimateParentSku = findUltimateParent(d.sku);
        const parentDbInfo = dbState[ultimateParentSku];
        
        if (parentDbInfo) {
            sqlStatements.push(`UPDATE wp_posts SET post_type = 'product_variation', post_parent = ${parentDbInfo.id} WHERE ID = ${dbInfo.id};`);
            deleteUpdates++;
        } else {
            console.log(`WARNING: Parent SKU ${ultimateParentSku} for variation ${d.sku} not found in DB!`);
            // Still make it a variation, but no parent
            sqlStatements.push(`UPDATE wp_posts SET post_type = 'product_variation' WHERE ID = ${dbInfo.id};`);
        }
    }
});

sqlStatements.push("COMMIT;");

fs.writeFileSync(sqlOutFile, sqlStatements.join('\n'));
console.log(`✅ SQL generated successfully!`);
console.log(`Keep Updates: ${keepUpdates}`);
console.log(`Variation Updates: ${deleteUpdates}`);

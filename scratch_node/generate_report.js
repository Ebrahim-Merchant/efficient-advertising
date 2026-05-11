const xlsx = require('xlsx');
const fs = require('fs');

const compFile = 'C:\\Users\\pc\\Downloads\\product-name-comparison-review.xlsx';
const dbStateFile = 'C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\db_state.json';
const reportFile = 'C:\\Users\\pc\\.gemini\\antigravity\\brain\\73c0c977-cbd7-4bc0-aa3c-f86a5aa0d023\\database_audit_report.md';

const dbState = JSON.parse(fs.readFileSync(dbStateFile, 'utf8'));

const compWb = xlsx.readFile(compFile);
const compWs = compWb.Sheets['Name Comparison'];
const compData = xlsx.utils.sheet_to_json(compWs, { defval: '' });

const expectedState = {}; // sku -> 'product' or 'product_variation'
const skuToName = {};

compData.forEach(row => {
    let dec = String(row['Decision'] || '').toUpperCase().trim();
    if (dec === 'IGNORE') return;
    
    const sku = String(row['SKU']).trim();
    skuToName[sku] = row['Suggested Final Name'] || row['Product Name'] || row['Variant'] || sku;

    if (dec === 'KEEP' || dec === '') {
        expectedState[sku] = 'product';
    } else if (dec === 'DELETE') {
        expectedState[sku] = 'product_variation';
    }
});

let correct = 0;
let incorrectType = [];
let missing = [];

Object.keys(expectedState).forEach(sku => {
    const expected = expectedState[sku];
    const actual = dbState[sku] ? dbState[sku].type : null;
    
    if (actual === expected) {
        correct++;
    } else if (actual) {
        incorrectType.push({ sku, name: skuToName[sku], expected, actual });
    } else {
        missing.push({ sku, name: skuToName[sku], expected });
    }
});

// Markdown Generation
let md = `# Live Database vs Excel Logic Audit Report\n\n`;
md += `This report compares your live WooCommerce database against your exact Excel logic.\n\n`;

md += `## 📊 High-Level Summary\n`;
md += `- **Total Valid Excel SKUs:** ${Object.keys(expectedState).length}\n`;
md += `- **SKUs Currently in Database:** ${Object.keys(dbState).length}\n`;
md += `- **Perfect Matches:** ${correct}\n`;
md += `- **Incorrect Type (Need Moving):** ${incorrectType.length}\n`;
md += `- **Missing from Database entirely:** ${missing.length}\n\n`;

md += `## ⚠️ Incorrect Types (The Errors)\n`;
md += `These products exist in your database, but are saved as the *wrong type*. For example, they might be saved as variations when they should be standalone products.\n\n`;

if (incorrectType.length === 0) {
    md += `*None! All SKUs that exist in the database have the correct type!*\n\n`;
} else {
    md += `| SKU | Product Name | Should Be | Currently Is |\n`;
    md += `|---|---|---|---|\n`;
    incorrectType.forEach(item => {
        md += `| ${item.sku} | ${item.name} | \`${item.expected}\` | \`${item.actual}\` |\n`;
    });
    md += `\n`;
}

md += `## ❌ Missing Products\n`;
md += `These SKUs are defined in your Excel file but are **missing completely** from your live WooCommerce database.\n\n`;
md += `<details><summary>Click to view all ${missing.length} missing SKUs</summary>\n\n`;
md += `| SKU | Product Name | Expected Type |\n`;
md += `|---|---|---|\n`;
missing.forEach(item => {
    md += `| ${item.sku} | ${item.name} | \`${item.expected}\` |\n`;
});
md += `\n</details>\n`;

fs.writeFileSync(reportFile, md);
console.log("Report generated at " + reportFile);

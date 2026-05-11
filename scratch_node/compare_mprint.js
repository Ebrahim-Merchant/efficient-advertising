const xlsx = require('xlsx');
const { execSync } = require('child_process');
const fs = require('fs');

const mprintExcelPath = 'C:\\Users\\pc\\Downloads\\mprinthouse_products.xlsx';
const mprintWb = xlsx.readFile(mprintExcelPath);
const mprintWs = mprintWb.Sheets[mprintWb.SheetNames[0]];
const mprintData = xlsx.utils.sheet_to_json(mprintWs);

// 1. Extract Mprint Product Names
const mprintProducts = mprintData.map(row => ({
    name: (row['Product Name'] || '').trim(),
    category: (row['Category'] || '').trim(),
    subcategory: (row['Sub-Category'] || '').trim()
})).filter(p => p.name);

// 2. Fetch current WooCommerce Products from Database
const query = `SELECT post_title FROM wp_posts WHERE post_type = 'product' AND post_status NOT IN ('trash', 'auto-draft')`;
const mysqlCmd = `"C:\\Users\\pc\\AppData\\Roaming\\Local\\lightning-services\\mysql-8.0.35+4\\bin\\win64\\bin\\mysql.exe" -h 127.0.0.1 -P 10005 -u root -proot local -N -B -e "${query}"`;

let dbProductTitles = [];
try {
    const output = execSync(mysqlCmd).toString();
    dbProductTitles = output.split('\n').map(line => line.trim().toLowerCase()).filter(Boolean);
} catch (error) {
    console.error("Error querying database:", error.message);
    process.exit(1);
}

// 3. Comparison Logic
const missingInDb = [];
const existingInDb = [];

mprintProducts.forEach(mProd => {
    const mNameLower = mProd.name.toLowerCase();
    // Check for exact match or partial match (since names might slightly differ)
    const exists = dbProductTitles.some(dbTitle => dbTitle === mNameLower || dbTitle.includes(mNameLower) || mNameLower.includes(dbTitle));
    
    if (exists) {
        existingInDb.push(mProd);
    } else {
        missingInDb.push(mProd);
    }
});

// 4. Output Results to Markdown
let report = `# Mprint Product Comparison Report\n\n`;
report += `This report compares products from **mprinthouse_products.xlsx** against the current **WooCommerce Database**.\n\n`;
report += `### Summary\n`;
report += `- Total Products in Mprint List: ${mprintProducts.length}\n`;
report += `- Products already in your database: ${existingInDb.length}\n`;
report += `- **Products missing from your database: ${missingInDb.length}**\n\n`;

report += `## ❌ Missing Products (Available in Mprint but not in Database)\n\n`;
report += `| Product Name | Category | Sub-Category |\n`;
report += `| :--- | :--- | :--- |\n`;
missingInDb.forEach(p => {
    report += `| ${p.name} | ${p.category} | ${p.subcategory} |\n`;
});

report += `\n## ✅ Existing Products (Already in Database)\n\n`;
report += `| Product Name | Category | Sub-Category |\n`;
report += `| :--- | :--- | :--- |\n`;
existingInDb.forEach(p => {
    report += `| ${p.name} | ${p.category} | ${p.subcategory} |\n`;
});

fs.writeFileSync('C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\mprint_comparison_report.md', report);

console.log(`Comparison complete. Missing: ${missingInDb.length}, Existing: ${existingInDb.length}`);
console.log(`Report generated at: C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\mprint_comparison_report.md`);

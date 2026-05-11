const mysql = require('child_process').execSync;
const fs = require('fs');

const skusToDraft = [
    // Specialty Business Cards (8)
    'PS-048', 'PS-049', 'PS-050', 'PS-051', 'PS-052', 'PS-053', 'PS-054', 'PS-055',
    // Single & Double-Sided Flyers (5)
    'PS-065', 'PS-066', 'PS-067', 'PS-068', 'PS-069',
    // Bi-Fold Brochures (8)
    'PS-079', 'PS-080', 'PS-081', 'PS-082', 'PS-083', 'PS-084', 'PS-085', 'PS-086',
    // Tri-Fold Brochures (4)
    'PS-087', 'PS-088', 'PS-089', 'PS-090',
    // Z-Fold & Gate-Fold Brochures (4)
    'PS-091', 'PS-092', 'PS-093', 'PS-094',
    // Variable Data Printing (3)
    'PS-258', 'PS-259', 'PS-260',
    // CD & DVD Printing (2)
    'PS-271', 'PS-272',
    // CD & DVD Covers (2)
    'PS-273', 'PS-274'
];

let query = `
    SELECT p.ID as variant_id, p.post_parent as parent_id 
    FROM wp_posts p
    JOIN wp_postmeta pm ON p.ID = pm.post_id
    WHERE pm.meta_key = '_sku' AND pm.meta_value IN (${skusToDraft.map(s => `'${s}'`).join(',')})
`;

const cmd = `"C:\\Users\\pc\\AppData\\Roaming\\Local\\lightning-services\\mysql-8.0.35+4\\bin\\win64\\bin\\mysql.exe" -h 127.0.0.1 -P 10005 -u root -proot local -N -B -e "${query}"`;

const output = mysql(cmd).toString().trim();
const lines = output.split('\n').filter(Boolean);

const variantIds = new Set();
const parentIds = new Set();

lines.forEach(line => {
    const [vId, pId] = line.split('\t');
    variantIds.add(vId);
    if (pId && pId !== '0') {
        parentIds.add(pId);
    }
});

const sqlStatements = [];
sqlStatements.push("BEGIN;");

// Draft variants
variantIds.forEach(id => {
    sqlStatements.push(`UPDATE wp_posts SET post_status = 'draft' WHERE ID = ${id};`);
});

// Draft parents
parentIds.forEach(id => {
    sqlStatements.push(`UPDATE wp_posts SET post_status = 'draft' WHERE ID = ${id};`);
});

sqlStatements.push("COMMIT;");

fs.writeFileSync('C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\draft_items.sql', sqlStatements.join('\n'));
console.log(`Generated SQL to draft ${variantIds.size} variants and ${parentIds.size} parents.`);

const xlsx = require('xlsx');
const { execSync } = require('child_process');
const fs = require('fs');

const file = 'C:\\Users\\pc\\Downloads\\eprint_ae_product_catalogue_v8.xlsx';
const wb = xlsx.readFile(file);
const ws = wb.Sheets[wb.SheetNames[0]];
const data = xlsx.utils.sheet_to_json(ws, { defval: '' });

// 1. Build Excel Mapping
// Product Group -> Set of Category Names
const productCategories = new Map();

data.forEach(row => {
    const parentCat = (row['Category'] || '').trim();
    const subCat = (row['Sub-Category'] || '').trim();
    const productGroup = (row['Product Group'] || '').trim();
    // Sometimes the DB post_title is the "Individual Product" if it's a simple product,
    // but the user's screenshot had Product Group mapped. We'll map both just in case.
    const individual = (row['Individual Product'] || '').trim();

    if (productGroup) {
        if (!productCategories.has(productGroup)) {
            productCategories.set(productGroup, new Set());
        }
        if (parentCat) productCategories.get(productGroup).add(parentCat);
        if (subCat) productCategories.get(productGroup).add(subCat);
    }
    
    if (individual && individual !== productGroup) {
        if (!productCategories.has(individual)) {
            productCategories.set(individual, new Set());
        }
        if (parentCat) productCategories.get(individual).add(parentCat);
        if (subCat) productCategories.get(individual).add(subCat);
    }
});

// 2. Fetch Database Terms
const termsQuery = `SELECT t.name, tt.term_taxonomy_id FROM wp_terms t JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id WHERE tt.taxonomy = 'product_cat'`;
const termsCmd = `"C:\\Users\\pc\\AppData\\Roaming\\Local\\lightning-services\\mysql-8.0.35+4\\bin\\win64\\bin\\mysql.exe" -h 127.0.0.1 -P 10005 -u root -proot local -N -B -e "${termsQuery}"`;
const termsOutput = execSync(termsCmd).toString().trim().split('\n').filter(Boolean);

const termNameToId = new Map();
termsOutput.forEach(line => {
    const [name, id] = line.split('\t');
    termNameToId.set(name.trim().toLowerCase(), id);
    // Replace & with &amp; because WooCommerce stores "Print & Stationery" as "Print &amp; Stationery"
    termNameToId.set(name.trim().toLowerCase().replace('&amp;', '&'), id);
});

// 3. Fetch Database Products
const productsQuery = `SELECT ID, post_title FROM wp_posts WHERE post_type = 'product' AND post_status != 'trash'`;
const productsCmd = `"C:\\Users\\pc\\AppData\\Roaming\\Local\\lightning-services\\mysql-8.0.35+4\\bin\\win64\\bin\\mysql.exe" -h 127.0.0.1 -P 10005 -u root -proot local -N -B -e "${productsQuery}"`;
const productsOutput = execSync(productsCmd).toString().trim().split('\n').filter(Boolean);

const sqlStatements = [];
sqlStatements.push('BEGIN;');

let matched = 0;
let unmatched = 0;

productsOutput.forEach(line => {
    const [id, title] = line.split('\t');
    const cleanTitle = title.trim();
    
    if (productCategories.has(cleanTitle)) {
        const cats = productCategories.get(cleanTitle);
        let foundTerm = false;
        cats.forEach(catName => {
            const termId = termNameToId.get(catName.toLowerCase());
            if (termId) {
                sqlStatements.push(`INSERT IGNORE INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (${id}, ${termId}, 0);`);
                foundTerm = true;
            }
        });
        if (foundTerm) {
            matched++;
        } else {
            unmatched++;
        }
    } else {
        // Try fallback fuzzy match
        let foundTerm = false;
        for (let [group, cats] of productCategories.entries()) {
            if (cleanTitle.includes(group) || group.includes(cleanTitle)) {
                cats.forEach(catName => {
                    const termId = termNameToId.get(catName.toLowerCase());
                    if (termId) {
                        sqlStatements.push(`INSERT IGNORE INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (${id}, ${termId}, 0);`);
                        foundTerm = true;
                    }
                });
                break;
            }
        }
        if (foundTerm) matched++;
        else unmatched++;
    }
});

sqlStatements.push('COMMIT;');

fs.writeFileSync('C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\category_mappings.sql', sqlStatements.join('\n'));
console.log(`Generated mapping SQL. Matched: ${matched}, Unmatched: ${unmatched}, Total Inserts: ${sqlStatements.length - 2}`);

const mysql = require('child_process').execSync;
const fs = require('fs');

const cmd = `"C:\\Users\\pc\\AppData\\Roaming\\Local\\lightning-services\\mysql-8.0.35+4\\bin\\win64\\bin\\mysql.exe" -h 127.0.0.1 -P 10005 -u root -proot local -N -B -e "SELECT ID, post_title FROM wp_posts WHERE post_title LIKE '%10 pt%' OR post_title LIKE '%10pt%';"`;

const output = mysql(cmd).toString().trim();
const lines = output.split('\n').filter(Boolean);

const sqlStatements = [];
sqlStatements.push("BEGIN;");

lines.forEach(line => {
    const [id, ...titleParts] = line.split('\t');
    const oldTitle = titleParts.join('\t');
    let newTitle = oldTitle;

    if (/10\s*pt/i.test(newTitle)) {
        newTitle = newTitle.replace(/10\s*pt/gi, '250 GSM');
    }

    if (newTitle !== oldTitle) {
        const escapedNewTitle = newTitle.replace(/'/g, "''");
        
        // Update post_title
        sqlStatements.push(`UPDATE wp_posts SET post_title = '${escapedNewTitle}' WHERE ID = ${id};`);
        
        // Update _product_name_custom in postmeta if it exists
        sqlStatements.push(`UPDATE wp_postmeta SET meta_value = '${escapedNewTitle}' WHERE post_id = ${id} AND meta_key = '_product_name_custom';`);
    }
});

sqlStatements.push("COMMIT;");

fs.writeFileSync('C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\scratch_node\\rename_10pt_gsm.sql', sqlStatements.join('\n'));
console.log(`Generated ${sqlStatements.length - 2} UPDATE statements for rename.`);

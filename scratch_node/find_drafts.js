const mysql = require('child_process').execSync;

const parentNames = [
    "CD & DVD Printing",
    "Single & Double-Sided Flyers",
    "Bi-Fold Brochures",
    "Specialty Business Cards",
    "Z-Fold & Gate-Fold Brochures",
    "Tri-Fold Brochures",
    "CD & DVD Covers",
    "Variable Data Printing"
];

let query = `SELECT ID, post_title, post_type FROM wp_posts WHERE post_title IN (${parentNames.map(n => `'${n}'`).join(',')}) AND post_type IN ('product', 'product_variation');`;

const cmd = `"C:\\Users\\pc\\AppData\\Roaming\\Local\\lightning-services\\mysql-8.0.35+4\\bin\\win64\\bin\\mysql.exe" -h 127.0.0.1 -P 10005 -u root -proot local -N -B -e "${query}"`;

const output = mysql(cmd).toString().trim();
console.log(output);

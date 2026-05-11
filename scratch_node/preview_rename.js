const mysql = require('child_process').execSync;
const fs = require('fs');

const cmd = `"C:\\Users\\pc\\AppData\\Roaming\\Local\\lightning-services\\mysql-8.0.35+4\\bin\\win64\\bin\\mysql.exe" -h 127.0.0.1 -P 10005 -u root -proot local -N -B -e "SELECT ID, post_title FROM wp_posts WHERE post_title LIKE '%12 pt%' OR post_title LIKE '%12pt%' OR post_title LIKE '%14 pt%' OR post_title LIKE '%14pt%' OR post_title LIKE '%16 pt%' OR post_title LIKE '%16pt%';"`;

const output = mysql(cmd).toString().trim();
const lines = output.split('\n').filter(Boolean);

let md = `# Business Card Variants Name Change Proposal\n\n`;
md += `You requested to change the 'pt' designations to GSM for Business Card products. Here are the items I found in your database and the proposed changes:\n\n`;

md += `## Proposed Changes\n`;
md += `| ID | Current Name | Proposed New Name |\n`;
md += `|---|---|---|\n`;

let total12 = 0;
let total14 = 0;
let total16 = 0;

lines.forEach(line => {
    const [id, ...titleParts] = line.split('\t');
    const oldTitle = titleParts.join('\t');
    let newTitle = oldTitle;

    if (/12\s*pt/i.test(newTitle)) {
        newTitle = newTitle.replace(/12\s*pt/gi, '300 GSM');
        total12++;
    }
    if (/14\s*pt/i.test(newTitle)) {
        newTitle = newTitle.replace(/14\s*pt/gi, '350 GSM');
        total14++;
    }
    if (/16\s*pt/i.test(newTitle)) {
        newTitle = newTitle.replace(/16\s*pt/gi, '400 GSM');
        total16++;
    }

    md += `| ${id} | ${oldTitle} | **${newTitle}** |\n`;
});

md += `\n## Summary\n`;
md += `- **12 pt → 300 GSM:** ${total12} items\n`;
md += `- **14 pt → 350 GSM:** ${total14} items\n`;
md += `- **16 pt → 400 GSM:** ${total16} items\n`;
md += `- **Total items to modify:** ${lines.length}\n`;

md += `\n> [!IMPORTANT]\n> I noticed there are also some **10pt** variants. You didn't specify a conversion for 10pt. Should I leave them as 10pt, or would you like to convert them to something like 250 GSM?\n`;

fs.writeFileSync('C:\\Users\\pc\\.gemini\\antigravity\\brain\\73c0c977-cbd7-4bc0-aa3c-f86a5aa0d023\\implementation_plan.md', md);
console.log("Implementation plan written.");

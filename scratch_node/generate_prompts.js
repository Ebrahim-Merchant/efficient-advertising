const xlsx = require('xlsx');

const mprintExcelPath = 'C:\\Users\\pc\\Downloads\\mprinthouse_products.xlsx';
const mprintWb = xlsx.readFile(mprintExcelPath);
const mprintWs = mprintWb.Sheets[mprintWb.SheetNames[0]];
const mprintData = xlsx.utils.sheet_to_json(mprintWs);

const logoPrompt = "The product should clearly feature the 'Efficient Advertising' logo and branding in a professional, realistic manner.";
const settingPrompt = "The setting should be a realistic, clean, modern commercial or urban area in Dubai, with natural lighting and no cliché landmarks.";

const productPrompts = mprintData.map(row => {
    const name = row['Product Name'];
    const category = row['Category'];
    const subcategory = row['Sub-Category'];
    const desc = row['Product Description'] || '';
    
    let specificPrompt = '';
    if (category.includes('Flags')) {
        specificPrompt = `A high-quality ${name} standing on a heavy square white cement base, positioned realistically between palm trees near a building facade.`;
    } else if (category.includes('Signage')) {
        specificPrompt = `A luxury custom ${name} mounted professionally on a modern office wall or building exterior with premium fixings.`;
    } else if (category.includes('Stationery')) {
        specificPrompt = `A professional, close-up photograph of a ${name} set, showing realistic paper texture and premium print quality.`;
    } else {
        specificPrompt = `A professional commercial photograph of a ${name} in a realistic, high-end business setting.`;
    }

    return {
        name: name,
        prompt: `${specificPrompt} ${logoPrompt} ${settingPrompt} 8k resolution, photorealistic, commercial photography style.`
    };
});

console.log(JSON.stringify(productPrompts.slice(0, 10), null, 2));

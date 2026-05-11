const xlsx = require('xlsx');
const fs = require('fs');

const compFile = 'C:\\Users\\pc\\Downloads\\product-name-comparison-review.xlsx';
const eprintFile = 'C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\competitor_research\\eprint_ae_product_catalogue_v8.xlsx';
const outputFile = 'C:\\Users\\pc\\Local Sites\\newefficientadvertising09042026\\app\\public\\woo_catalog_recovery.csv';

function escapeCSV(str) {
    if (str === null || str === undefined) return '';
    str = String(str);
    if (str.includes(',') || str.includes('"') || str.includes('\n')) {
        str = '"' + str.replace(/"/g, '""') + '"';
    }
    return str;
}

function pipeToHtml(pipeStr, heading) {
    if (!pipeStr) return '';
    const items = pipeStr.split('|').map(s => s.trim()).filter(Boolean);
    if (items.length === 0) return '';
    const li = items.map(i => `<li>✔ ${i}</li>`).join('');
    return (heading ? `<h4>${heading}</h4>` : '') + `<ul>${li}</ul>`;
}

function buildDesc(row) {
    const parts = [];
    if (row['Full Description']) parts.push(`<div class="ea-prod-desc"><p>${row['Full Description']}</p></div>`);
    if (row['Key Features (pipe-separated)']) parts.push(pipeToHtml(row['Key Features (pipe-separated)'], '🏆 Key Features'));
    if (row['Material / Substrate Options']) parts.push(pipeToHtml(row['Material / Substrate Options'], '📋 Material / Substrate Options'));
    if (row['Finish Options']) parts.push(pipeToHtml(row['Finish Options'], '✨ Finish Options'));
    if (row['Ideal Use Cases']) parts.push(pipeToHtml(row['Ideal Use Cases'], '💼 Ideal Use Cases'));
    return parts.join('\n');
}

console.log("Loading metadata...");
const eprintWb = xlsx.readFile(eprintFile);
const eprintWs = eprintWb.Sheets[eprintWb.SheetNames[0]];
const eprintData = xlsx.utils.sheet_to_json(eprintWs, { defval: '' });

const metaDict = {};
eprintData.forEach(row => {
    if (row['SKU']) metaDict[String(row['SKU']).trim()] = row;
});

const compWb = xlsx.readFile(compFile);
const compWs = compWb.Sheets['Name Comparison'];
const compData = xlsx.utils.sheet_to_json(compWs, { defval: '' });

const keeps = new Set();
const rawDeletes = [];
let lastKeepSku = null;
let lastDeleteParentSku = null;

// First pass: collect all rows
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
        rawDeletes.push({ sku, parentSku, row });
    }
});

// Build a map of all Delete rows to their direct parent
const deleteMap = {};
rawDeletes.forEach(d => {
    deleteMap[d.sku] = d.parentSku;
});

// Function to recursively find the ultimate KEEP parent
function findUltimateParent(sku) {
    let current = sku;
    let visited = new Set();
    while (current && !keeps.has(current)) {
        if (visited.has(current)) break; // prevent infinite loops
        visited.add(current);
        current = deleteMap[current];
    }
    return current;
}

const finalParents = {}; // sku -> [children rows]
const itemsToProcess = [];

compData.forEach(row => {
    let dec = String(row['Decision'] || '').toUpperCase().trim();
    if (dec === 'KEEP' || dec === '') {
        itemsToProcess.push(row);
    }
});

rawDeletes.forEach(d => {
    const ultimateParent = findUltimateParent(d.sku);
    if (ultimateParent && keeps.has(ultimateParent)) {
        if (!finalParents[ultimateParent]) finalParents[ultimateParent] = [];
        finalParents[ultimateParent].push(d.row);
    } else {
        console.log(`WARNING: Could not find Keep parent for SKU ${d.sku}`);
    }
});

const outRows = [];
const WOO_HEADERS = [
    'Type', 'SKU', 'Name', 'Published', 'Visibility in catalog', 'Short description', 'Description',
    'In stock?', 'Categories', 'Parent', 'Attribute 1 name', 'Attribute 1 value(s)', 'Attribute 1 visible', 'Attribute 1 global',
    'Meta: _yoast_wpseo_title', 'slug', 'Image Alt Text'
];
outRows.push(WOO_HEADERS.join(','));

let pCount = 0;
let vCount = 0;

itemsToProcess.forEach(row => {
    const sku = String(row['SKU']).trim();
    const children = finalParents[sku] || [];
    const meta = metaDict[sku] || {};
    const isVariable = children.length > 0;
    
    let catStr = meta['Category'] || row['Category'] || '';
    if (meta['Sub-Category'] || row['Sub Category']) catStr += ` > ${meta['Sub-Category'] || row['Sub Category']}`;
    
    const attrValues = children.map(c => c['Variant'] || 'Default').filter(Boolean).join(',');
    
    outRows.push([
        isVariable ? 'variable' : 'simple',
        sku,
        row['Suggested Final Name'] || meta['Individual Product'] || 'Product',
        '1', 'visible',
        meta['Short Description'] || '', buildDesc(meta),
        '1', catStr, '',
        isVariable ? 'Options' : '', isVariable ? attrValues : '', isVariable ? '1' : '', isVariable ? '0' : '',
        meta['SEO Title (≤60 chars)'] || '', meta['URL Slug'] || '', meta['Image Alt Text'] || ''
    ].map(escapeCSV).join(','));
    pCount++;
    
    children.forEach(child => {
        const cSku = String(child['SKU']).trim();
        const cMeta = metaDict[cSku] || meta;
        outRows.push([
            'variation',
            cSku,
            child['Variant'] || 'Variation',
            '1', 'visible',
            cMeta['Short Description'] || '', buildDesc(cMeta),
            '1', '', sku,
            'Options', child['Variant'] || 'Default', '', '0',
            cMeta['SEO Title (≤60 chars)'] || '', '', cMeta['Image Alt Text'] || ''
        ].map(escapeCSV).join(','));
        vCount++;
    });
});

fs.writeFileSync(outputFile, outRows.join('\n'));
console.log(`Parents (Keep): ${pCount} | Variations (Delete): ${vCount} | Total: ${pCount + vCount}`);

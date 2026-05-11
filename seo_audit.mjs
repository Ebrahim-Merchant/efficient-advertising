import https from 'https';

const url = 'https://finchgiftshop.com';

https.get(url, (res) => {
  let data = '';
  res.on('data', (chunk) => { data += chunk; });
  res.on('end', () => {
    const titleMatch = data.match(/<title>([^<]*)<\/title>/);
    const metaDescMatch = data.match(/<meta[^>]*name="description"[^>]*content="([^"]*)"[^>]*>/i) || data.match(/<meta[^>]*content="([^"]*)"[^>]*name="description"[^>]*>/i);
    const h1Matches = [...data.matchAll(/<h1[^>]*>(.*?)<\/h1>/gi)].map(m => m[1].replace(/<[^>]+>/g, '').trim());
    const h2Matches = [...data.matchAll(/<h2[^>]*>(.*?)<\/h2>/gi)].map(m => m[1].replace(/<[^>]+>/g, '').trim());
    const imgMatches = [...data.matchAll(/<img[^>]*>/gi)];
    const noAltImgs = imgMatches.filter(m => !m[0].includes('alt="') && !m[0].includes("alt='"));
    
    console.log(`Title: ${titleMatch ? titleMatch[1].trim() : 'N/A'}`);
    console.log(`Meta Description: ${metaDescMatch ? metaDescMatch[1].trim() : 'N/A'}`);
    console.log(`H1 Tags: ${JSON.stringify(h1Matches)}`);
    console.log(`Total Images: ${imgMatches.length}`);
    console.log(`Images without Alt: ${noAltImgs.length}`);
    console.log(`HTML Size: ${data.length} bytes`);
  });
}).on('error', (err) => {
  console.log(`Error: ${err.message}`);
});

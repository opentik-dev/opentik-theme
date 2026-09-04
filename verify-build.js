const fs = require('fs');
const path = require('path');
const root = path.resolve(__dirname);
const files = ['assets/dist/css/main.css', 'assets/dist/js/main.js'];
let failed = false;
files.forEach((relativePath) => {
  const filePath = path.join(root, relativePath);
  if (!fs.existsSync(filePath)) {
    console.error(`Missing build output: ${relativePath}`);
    failed = true;
  }
});
if (failed) {
  process.exit(1);
}
console.log('Build verification passed.');

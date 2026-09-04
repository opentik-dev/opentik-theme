const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname);
const pairs = [
  ['assets/dist/css/main.css', 'assets/src/css/style.css'],
  ['assets/dist/js/main.js', 'assets/src/js/main.js'],
];
let failed = false;

for (const [outputPath, sourcePath] of pairs) {
  const outputFile = path.join(root, outputPath);
  const sourceFile = path.join(root, sourcePath);

  if (!fs.existsSync(outputFile)) {
    console.error(`Missing build output: ${outputPath}`);
    failed = true;
    continue;
  }

  const inputMtime = fs.statSync(sourceFile).mtimeMs;
  const outputMtime = fs.statSync(outputFile).mtimeMs;
  if (outputMtime < inputMtime) {
    console.error(
      `Stale build output: ${outputPath} is older than source (${sourcePath})`
    );
    failed = true;
  }
}

if (failed) {
  process.exit(1);
}
console.log('Build verification passed (files present and up to date).');
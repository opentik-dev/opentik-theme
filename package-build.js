const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const root = path.resolve(__dirname);
const buildDir = path.join(root, 'build');
const staging = path.join(buildDir, 'opentik-theme');
const zipPath = path.join(buildDir, 'opentik-theme.zip');

const copyDirs = ['assets/dist', 'inc', 'parts'];
const copyFiles = [
  'index.php',
  'home.php',
  'single.php',
  'page.php',
  'archive.php',
  'search.php',
  'header.php',
  'footer.php',
  'functions.php',
  'style.css',
  'screenshot.png',
  'README.md',
];

function rmrf(target) {
  if (fs.existsSync(target)) fs.rmSync(target, { recursive: true, force: true });
}

rmrf(staging);
fs.mkdirSync(staging, { recursive: true });

for (const dir of copyDirs) {
  fs.cpSync(path.join(root, dir), path.join(staging, dir), { recursive: true });
}
for (const file of copyFiles) {
  const source = path.join(root, file);
  if (!fs.existsSync(source)) {
    console.error(`Missing package file: ${file}`);
    process.exit(1);
  }
  fs.copyFileSync(source, path.join(staging, file));
}

rmrf(zipPath);
execSync(`cd "${staging}" && zip -r "${zipPath}" .`, { stdio: 'inherit' });

const zipSize = (fs.statSync(zipPath).size / 1024).toFixed(1);
console.log(`Package created: build/opentik-theme.zip (${zipSize} KB)`);
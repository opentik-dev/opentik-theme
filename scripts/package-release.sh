#!/usr/bin/env bash
set -euo pipefail

project_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
build_root="$project_root/build"
theme_root="$build_root/opentik-theme"
output_path="$build_root/opentik-theme.zip"
legacy_output_path="$project_root/opentik-theme.zip"

directories=(
  "assets/dist"
  "inc"
  "parts"
)

files=(
  "index.php"
  "home.php"
  "single.php"
  "page.php"
  "archive.php"
  "search.php"
  "header.php"
  "footer.php"
  "functions.php"
  "style.css"
  "README.md"
  "screenshot.png"
)

for relative_path in "${directories[@]}" "${files[@]}"; do
  if [[ ! -e "$project_root/$relative_path" ]]; then
    echo "Missing package input: $relative_path" >&2
    exit 1
  fi
done

for required_asset in "assets/dist/css/main.css" "assets/dist/js/main.js"; do
  if [[ ! -f "$project_root/$required_asset" ]]; then
    echo "Built asset is missing: $required_asset. Run npm run build first." >&2
    exit 1
  fi
done

mkdir -p "$build_root"
rm -rf "$theme_root"
mkdir -p "$theme_root"

for relative_path in "${directories[@]}"; do
  mkdir -p "$theme_root/$(dirname "$relative_path")"
  cp -R "$project_root/$relative_path" "$theme_root/$(dirname "$relative_path")/"
done

for relative_path in "${files[@]}"; do
  cp "$project_root/$relative_path" "$theme_root/$relative_path"
done

rm -f "$output_path" "$legacy_output_path"
(cd "$build_root" && zip -qr "$output_path" opentik-theme)

package_size="$(stat -c '%s' "$output_path")"
echo "WordPress package created: ${output_path#"$project_root/"} (${package_size} bytes)"

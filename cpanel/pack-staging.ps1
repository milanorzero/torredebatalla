param(
  [string]$ProjectRoot = "C:\laravel\torredebatalla",
  [string]$OutDir = "C:\laravel\torredebatalla\cpanel\dist"
)

$ErrorActionPreference = 'Stop'

function Ensure-Dir([string]$Path) {
  if (-not (Test-Path -LiteralPath $Path)) {
    New-Item -ItemType Directory -Path $Path | Out-Null
  }
}

Ensure-Dir $OutDir

$stamp = Get-Date -Format 'yyyyMMdd-HHmmss'
$publicZip = Join-Path $OutDir ("staging-public-$stamp.zip")
$appZip    = Join-Path $OutDir ("staging-laravel-app-$stamp.zip")

function Has-Tar {
  try {
    $null = Get-Command tar -ErrorAction Stop
    return $true
  } catch {
    return $false
  }
}

Write-Host "Creating public zip -> $publicZip"
# On Windows, public/storage is often a symlink created by `php artisan storage:link` and can fail to zip.
# Also avoid re-zipping existing zip artifacts.
$publicItems = Get-ChildItem -LiteralPath (Join-Path $ProjectRoot 'public') -Force | Where-Object {
  $_.Name -ne 'storage' -and $_.Extension -ne '.zip'
}
if (Has-Tar) {
  $tarOk = $true
  Push-Location (Join-Path $ProjectRoot 'public')
  try {
    tar -a -c -f $publicZip --exclude=./storage --exclude=storage --exclude=storage/* --exclude=storage/** --exclude=*.zip .
    if ($LASTEXITCODE -ne 0) {
      Write-Host "tar failed with exit code $LASTEXITCODE"
      $tarOk = $false
    }
  } catch {
    Write-Host "tar threw an error; falling back to Compress-Archive"
    $tarOk = $false
  } finally {
    Pop-Location
  }

  if (-not $tarOk) {
    if (Test-Path -LiteralPath $publicZip) {
      Remove-Item -LiteralPath $publicZip -Force
    }
    Compress-Archive -Path ($publicItems.FullName) -DestinationPath $publicZip
  }
} else {
  Compress-Archive -Path ($publicItems.FullName) -DestinationPath $publicZip
}

Write-Host "Creating app zip (everything except public) -> $appZip"
$exclude = @(
  'cpanel',
  'public',
  '.git',
  '.github',
  'node_modules',
  'vendor\bin',
  'storage\logs\*',
  '.env'
)

$items = Get-ChildItem -LiteralPath $ProjectRoot -Force | Where-Object {
  $name = $_.Name
  -not ($exclude -contains $name)
}

if (Has-Tar) {
  Push-Location $ProjectRoot
  try {
    tar -a -c -f $appZip `
      --exclude=public `
      --exclude=cpanel `
      --exclude=.git `
      --exclude=.github `
      --exclude=node_modules `
      --exclude=vendor/bin `
      --exclude=storage/logs `
      --exclude=.env `
      --exclude=bootstrap/cache `
      .
  } finally {
    Pop-Location
  }
} else {
  # Compress-Archive accepts paths; we pass full paths.
  Compress-Archive -Path ($items.FullName) -DestinationPath $appZip
}

Write-Host "Done. Upload:"
Write-Host "- $publicZip to /home/torredeb/staging.torredebatalla.cl/public_html/staging/ and Extract"
Write-Host "- $appZip to /home/torredeb/staging.torredebatalla.cl/laravel-app/ and Extract"
